<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Data;

use TamasVarga\LuandaPHP\Misc\IncidentReporter;

/**
 * DataAgent
 *
 * Wraps a PDO MySQL connection and exposes a clean interface for
 * database operations: connecting, switching databases, managing
 * transactions, adjusting collation, and registering stored procedures
 * as dynamic properties.
 *
 * Quirk: stored procedures are attached as dynamic properties via
 * addStoredProcedure(), so $agent->myProc->Execute([...]) works naturally.
 * PHP 8.2+ requires #[\AllowDynamicProperties] for this to work without
 * deprecation notices — add it to this class if targeting 8.2+.
 */
class DataAgent {
	
	/** @var \PDO|null  Active PDO connection, null until Connect() is called. */
	protected ?\PDO $dbDriver = null;
	
	/** @var string|null  DSN string built from constructor args (host + port only, no DB name). */
	protected ?string $dbDomain = null;
	
	
	/**
	 * @param string $server  MySQL host. Defaults to localhost.
	 * @param string $port    MySQL port. Defaults to 3306.
	 */
	public function __construct(string $server = '127.0.0.1', string $port = '3306') {
		$this->dbDomain = 'mysql:host=' . $server . ';port=' . $port;
	}
	
	
	/**
	 * Open a PDO connection to the MySQL server.
	 *
	 * The charset and collation are applied at connection time via MYSQL_ATTR_INIT_COMMAND,
	 * so they take effect before any query runs. Any options passed in $options are merged
	 * on top of the defaults — same key in $options wins.
	 *
	 * Note: no database is selected here. Call setDatabase() afterwards if needed,
	 * or include the DB name in the DSN manually.
	 *
	 * @param string $username   MySQL username.
	 * @param string $password   MySQL password.
	 * @param array  $options    Additional PDO options. Merged over defaults; caller's values take precedence.
	 * @param string $charset    MySQL charset constant. See db_charset. Defaults to utf8mb4.
	 * @param string $collation  MySQL collation constant. See db_collation. Defaults to utf8mb4_general_ci.
	 *
	 * @return bool  True on success, false on connection failure (error also reported via IncidentReporter).
	 */
	public function Connect(string $username, string $password, array $options = [], string $charset = db_charset::UTF8MB4, string $collation = db_collation::UTF8MB4_GENERAL) {
		$_retval = true;
		
		try {
			$this->dbDriver = new \PDO(
				$this->dbDomain,
				$username,
				$password,
				array_replace([
					\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
					\PDO::ATTR_EMULATE_PREPARES   => false,
					\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $charset . ' COLLATE ' . $collation,
				], $options)
				);
		} catch (\PDOException $_error) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('DataAgent::Connect', $_error->getMessage(), db_error::ERR_CONNECT);
			$_retval = false;
		}
		
		return $_retval;
	}
	
	
	/**
	 * Switch the active database on the current connection.
	 *
	 * Equivalent to running USE `dbName` manually. The database name is
	 * passed directly into the query string — sanitize or validate it
	 * upstream if it comes from user input.
	 *
	 * @param string $dbName  Name of the database to select.
	 * @return bool  True on success, false on failure.
	 */
	public function setDatabase($dbName): bool {
		$_retval = true;
		
		try {
			$this->dbDriver->exec('USE ' . $dbName);
		} catch (\PDOException $_error) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('DataAgent::setDatabase', $_error->getMessage(), db_error::ERR_EXECUTE);
			$_retval = false;
		}
		
		return $_retval;
	}
	
	
	/**
	 * Return the name of the currently selected database.
	 *
	 * Uses SELECT DATABASE() which returns NULL if no database is selected.
	 *
	 * @return string|null  Database name, or null if none selected / on error.
	 */
	public function getDatabase(): ?string {
		$_retval = null;
		
		try {
			$_retval = $this->dbDriver->query('SELECT DATABASE()')->fetchColumn();
		} catch (\PDOException $_error) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('DataAgent::getDatabase', $_error->getMessage(), db_error::ERR_EXECUTE);
		}
		
		return $_retval;
	}
	
	
	/**
	 * Change the charset and collation on the existing connection.
	 *
	 * Useful when switching between databases with different encoding
	 * requirements mid-session. Does not affect the connection's DSN.
	 *
	 * @param string $charset    MySQL charset string (e.g. 'utf8mb4'). Use db_charset constants.
	 * @param string $collation  MySQL collation string. Use db_collation constants.
	 * @return bool  True on success, false on failure.
	 */
	public function setCollation($charset, $collation): bool {
		$_retval = true;
		
		try {
			$this->dbDriver->exec('SET NAMES ' . $charset . ' COLLATE ' . $collation);
		} catch (\PDOException $_error) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('DataAgent::setCollation', $_error->getMessage(), db_error::ERR_EXECUTE);
			$_retval = false;
		}
		
		return $_retval;
	}
	
	
	/**
	 * Register a stored procedure as a dynamic property on this instance.
	 *
	 * After calling this, the SP is accessible as $agent->spname->Execute([...]).
	 * The property name matches the SP name exactly, so name them accordingly.
	 *
	 * Quirk: uses dynamic property assignment ($this->$spname), which requires
	 * #[\AllowDynamicProperties] on this class in PHP 8.2+.
	 *
	 * @param string $spname  Name of the stored procedure (must match the DB exactly).
	 */
	public function addStoredProcedure(string $spname): void {
		$this->$spname = new StoredProcedure($this->dbDriver, $spname);
	}
	
	
	/**
	 * Begin a database transaction.
	 *
	 * @return bool  True on success, false on failure.
	 */
	public function begin(): bool {
		$_retval = true;
		
		try {
			$this->dbDriver->beginTransaction();
		} catch (\PDOException $_error) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('DataAgent::begin', $_error->getMessage(), db_error::ERR_TRANSACTION);
			$_retval = false;
		}
		
		return $_retval;
	}
	
	
	/**
	 * Commit the current transaction.
	 *
	 * @return bool  True on success, false on failure.
	 */
	public function commit(): bool {
		$_retval = true;
		
		try {
			$this->dbDriver->commit();
		} catch (\PDOException $_error) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('DataAgent::commit', $_error->getMessage(), db_error::ERR_TRANSACTION);
			$_retval = false;
		}
		
		return $_retval;
	}
	
	
	/**
	 * Roll back the current transaction.
	 *
	 * @return bool  True on success, false on failure.
	 */
	public function rollback(): bool {
		$_retval = true;
		
		try {
			$this->dbDriver->rollBack();
		} catch (\PDOException $_error) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('DataAgent::rollback', $_error->getMessage(), db_error::ERR_TRANSACTION);
			$_retval = false;
		}
		
		return $_retval;
	}
}


/**
 * StoredProcedure
 *
 * Represents a single MySQL stored procedure and handles parameter binding
 * and execution, returning results as a ResultSet.
 *
 * Supports two calling conventions:
 *   - Positional:  Execute([val1, val2])       → uses ? placeholders
 *   - Named:       Execute(['p1' => v1, ...])  → uses :p1 style placeholders
 *
 * Named vs positional is auto-detected by checking whether the array keys
 * are sequential integers starting from 0 (positional) or not (named).
 */
class StoredProcedure {
	
	/** @var string|null  Stored procedure name as it exists in the database. */
	private ?string $spName = null;
	
	/** @var \PDO|null  Shared PDO connection passed in from DataAgent. */
	private ?\PDO $dbDriver = null;
	
	/** @var array  Array to store the results of a query */
	private array $dbResult = [];
	
	/**
	 * @param \PDO   $dbDriver  Active PDO connection (shared from DataAgent).
	 * @param string $name      Stored procedure name.
	 */
	public function __construct(\PDO $dbDriver, string $name) {
		$this->spName   = $name;
		$this->dbDriver = $dbDriver;
	}
	
	
	/**
	 * Execute the stored procedure and return results.
	 *
	 * Parameter binding is automatic:
	 *   - No params:    CALL proc()
	 *   - Positional:   CALL proc(?, ?)           — bound via execute()
	 *   - Named:        CALL proc(:p1, :p2)        — bound via bindValue() with type detection
	 *
	 * Named params use pdoType() to infer the correct PDO::PARAM_* constant,
	 * which matters for MySQL SPs that are strict about int/bool/null types.
	 *
	 * The cursor is always closed in the finally block to avoid "commands out
	 * of sync" errors that MySQL throws when a result set is left open.
	 *
	 * @param array $spparams  Parameters to pass to the SP. Empty array = no params.
	 * @return ResultSet|null  Query results, or null on failure.
	 */
	public function Execute(array $spparams = []): bool {
		$_retval			= true;
		
		$_hasparams			= false;
		$_hasnamedparams	= false;
		$_placeholders		= '';
		$_dbStatement		= null;
		
		$_hasparams = !empty($spparams);
		
		if ($_hasparams) {
			// Detect named params: if keys are not [0, 1, 2, ...], they must be named strings.
			$_hasnamedparams = array_keys($spparams) !== range(0, count($spparams) - 1);
			$_placeholders   = implode(', ', array_map(fn($key) => ($_hasnamedparams ? ':' . $key : '?'), array_keys($spparams)));
		}
		
		try {
			$_dbStatement = $this->dbDriver->prepare('CALL ' . $this->spName . '(' . ($_hasparams ? $_placeholders : '') . ')');
			
			if (!$_hasparams) {
				$_dbStatement->execute();
			} else if (!$_hasnamedparams) {
				// Positional: pass values directly to execute().
				$_dbStatement->execute($spparams);
			} else {
				// Named: bind each value individually with its correct PDO type.
				foreach ($spparams as $_name => $_param) $_dbStatement->bindValue(':' . $_name, $_param, $this->pdoType($_param));
				$_dbStatement->execute();
			}
			
			$this->dbResult = $_dbStatement->fetchAll();
			
			if (!empty($this->dbResult)) {
				// For each column name in the first row, extract that column's
				// values across all rows and assign them as a dynamic property.
				foreach (array_keys($this->dbResult[0]) as $_col) {
					$this->$_col = array_column($this->dbResult, $_col);
				}
			}
			
		} catch (\PDOException $_error) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('StoredProcedure::Execute', $_error->getMessage(), db_error::ERR_EXECUTE);
			$_retval = false;
		} finally {
			// Always close the cursor — leaving a MySQL result set open causes
			// "commands out of sync" errors on the next query.
			$_dbStatement?->closeCursor();
		}
		
		return $_retval;
	}
	
	/**
	 * Magic getter — only handles the virtual "length" property.
	 *
	 * Column properties are set directly in the constructor, so they don't
	 * pass through here. Accessing any other undefined property returns null.
	 *
	 * @param string $value  Property name.
	 * @return mixed  Row count for "length", null for anything else.
	 */
	public function __get(string $value): mixed {
		$_retval = null;
		
		if ($value === 'length')
			$_retval = count($this->dbResult);
			
		return $_retval;
	}
	
	/**
	 * Map a PHP value's runtime type to the appropriate PDO parameter constant.
	 *
	 * Used when binding named parameters so MySQL gets the right type hint.
	 * Floats and arrays fall through to PARAM_STR (MySQL handles the cast).
	 *
	 * @param mixed $value  The value to inspect.
	 * @return int  One of PDO::PARAM_INT, PARAM_BOOL, PARAM_NULL, or PARAM_STR.
	 */
	protected function pdoType(mixed $value): int {
		return match (gettype($value)) {
			'integer' => \PDO::PARAM_INT,
			'boolean' => \PDO::PARAM_BOOL,
			'NULL'    => \PDO::PARAM_NULL,
			default   => \PDO::PARAM_STR,
		};
	}
}


/**
 * db_error
 *
 * Integer codes for MySQL operation error categories.
 * Passed as the third argument to IncidentReporter::report() so errors
 * can be grouped and filtered by type in logs.
 */
class db_error {
	public const ERR_CONNECT     = 1;   // connection failed
	public const ERR_PREPARE     = 2;   // SQL preparation failed
	public const ERR_EXECUTE     = 3;   // SP execution failed
	public const ERR_FETCH       = 4;   // fetch failed
	public const ERR_TRANSACTION = 5;   // begin/commit/rollback failed
}


/**
 * db_charset
 *
 * Named constants for MySQL charset identifiers.
 * Used in DSN strings and SET NAMES queries.
 *
 * For any new project, prefer UTF8MB4 — it covers the full Unicode range
 * including emoji and supplementary scripts. Everything else here is for
 * legacy database compatibility.
 *
 * Note: some constants share the same string value on purpose (ISO8859_2 = latin2,
 * ISO8859_9 = latin5, CP1256_ARABIC = cp1256). These are intentional aliases
 * so callers can use the name that matches their mental model.
 */
class db_charset {
	
	// -------------------------------------------------------------------------
	// Unicode — use these for all new projects
	// -------------------------------------------------------------------------
	
	/** Full Unicode, emoji, all scripts. Always prefer this. */
	public const UTF8MB4 = 'utf8mb4';
	
	/** Legacy 3-byte UTF8 — no emoji, kept for old DB compat only */
	public const UTF8 = 'utf8';
	
	
	// -------------------------------------------------------------------------
	// Western European
	// -------------------------------------------------------------------------
	
	/** Latin1 — Western European, legacy default in old MySQL */
	public const LATIN1 = 'latin1';
	
	/** Latin2 — Central European: Hungarian, Polish, Czech, Slovak, Slovenian, Croatian */
	public const LATIN2 = 'latin2';
	
	/** Latin5 — Turkish */
	public const LATIN5 = 'latin5';
	
	/** Latin7 — Baltic: Estonian, Latvian, Lithuanian */
	public const LATIN7 = 'latin7';
	
	/** CP1250 — Windows Central European: Hungarian, Polish, Czech, Slovak */
	public const CP1250 = 'cp1250';
	
	/** CP1251 — Windows Cyrillic */
	public const CP1251 = 'cp1251';
	
	/** CP1256 — Windows Arabic */
	public const CP1256 = 'cp1256';
	
	/** CP1257 — Windows Baltic */
	public const CP1257 = 'cp1257';
	
	/** ISO 8859-2 — Central European (alias for latin2, same coverage) */
	public const ISO8859_2 = 'latin2';
	
	/** ISO 8859-9 — Turkish (alias for latin5) */
	public const ISO8859_9 = 'latin5';
	
	
	// -------------------------------------------------------------------------
	// East Asian
	// -------------------------------------------------------------------------
	
	/** GBK — Simplified Chinese (mainland China) */
	public const GBK = 'gbk';
	
	/** GB2312 — Simplified Chinese, older standard, subset of GBK */
	public const GB2312 = 'gb2312';
	
	/** Big5 — Traditional Chinese (Taiwan, Hong Kong) */
	public const BIG5 = 'big5';
	
	/** EUC-KR — Korean */
	public const EUCKR = 'euckr';
	
	/** CP932 — Japanese Windows (Shift-JIS superset) */
	public const CP932 = 'cp932';
	
	/** UJIS — Japanese EUC */
	public const UJIS = 'ujis';
	
	/** SJIS — Japanese Shift-JIS */
	public const SJIS = 'sjis';
	
	
	// -------------------------------------------------------------------------
	// Middle Eastern / Other
	// -------------------------------------------------------------------------
	
	/** Hebrew */
	public const HEBREW = 'hebrew';
	
	/** Greek */
	public const GREEK = 'greek';
	
	/** Arabic (alias for cp1256) */
	public const CP1256_ARABIC = 'cp1256';
}


/**
 * db_collation
 *
 * Named constants for MySQL collation identifiers.
 * Used in CREATE DATABASE, CREATE TABLE, or SET NAMES queries.
 *
 * Collation controls sort order and comparison rules (case sensitivity,
 * accent handling, language-specific ordering). It must be compatible
 * with the charset in use — mixing them causes MySQL errors.
 *
 * For new projects on MySQL 8.0+: use UTF8MB4_0900 (best accuracy).
 * For older MySQL or wide compatibility: use UTF8MB4_UNICODE or UTF8MB4_GENERAL.
 */
class db_collation {
	
	// -------------------------------------------------------------------------
	// UTF8MB4 — use for all new projects
	// -------------------------------------------------------------------------
	
	/** Fast, case insensitive, good for most Western languages */
	public const UTF8MB4_GENERAL     = 'utf8mb4_general_ci';
	
	/** Proper Unicode rules, better accent/special char handling */
	public const UTF8MB4_UNICODE     = 'utf8mb4_unicode_ci';
	
	/** Unicode 9.0 rules — most accurate, use for multilingual apps */
	public const UTF8MB4_UNICODE_520 = 'utf8mb4_unicode_520_ci';
	
	/** MySQL 8.0+ default — Unicode 9.0, best overall choice on 8.x */
	public const UTF8MB4_0900        = 'utf8mb4_0900_ai_ci';
	
	/** Binary — case sensitive, byte exact, fastest */
	public const UTF8MB4_BIN         = 'utf8mb4_bin';
	
	/** Case sensitive Unicode */
	public const UTF8MB4_UNICODE_CS  = 'utf8mb4_unicode_cs';
	
	
	// -------------------------------------------------------------------------
	// Central / Eastern European — Hungarian, Czech, Slovak, Polish, Slovenian
	// -------------------------------------------------------------------------
	
	/** Latin2 general — Hungarian, Czech, Slovak, Polish, Croatian */
	public const LATIN2_GENERAL      = 'latin2_general_ci';
	
	/** Latin2 Czech/Slovak specific rules */
	public const LATIN2_CZECH        = 'latin2_czech_cs';
	
	/** CP1250 — Windows Central European, case insensitive */
	public const CP1250_GENERAL      = 'cp1250_general_ci';
	
	/** CP1250 Czech/Slovak specific */
	public const CP1250_CZECH        = 'cp1250_czech_cs';
	
	/** CP1250 Croatian */
	public const CP1250_CROATIAN     = 'cp1250_croatian_ci';
	
	/** UTF8MB4 Czech — proper Czech sorting rules */
	public const UTF8MB4_CZECH       = 'utf8mb4_czech_ci';
	
	/** UTF8MB4 Hungarian — proper Hungarian sorting */
	public const UTF8MB4_HUNGARIAN   = 'utf8mb4_hungarian_ci';
	
	/** UTF8MB4 Polish */
	public const UTF8MB4_POLISH      = 'utf8mb4_polish_ci';
	
	/** UTF8MB4 Slovak */
	public const UTF8MB4_SLOVAK      = 'utf8mb4_slovak_ci';
	
	/** UTF8MB4 Slovenian */
	public const UTF8MB4_SLOVENIAN   = 'utf8mb4_slovenian_ci';
	
	/** UTF8MB4 Romanian */
	public const UTF8MB4_ROMANIAN    = 'utf8mb4_romanian_ci';
	
	
	// -------------------------------------------------------------------------
	// Turkish
	// -------------------------------------------------------------------------
	
	/** Latin5 Turkish */
	public const LATIN5_TURKISH      = 'latin5_turkish_ci';
	
	/** UTF8MB4 Turkish — handles dotted/dotless i correctly */
	public const UTF8MB4_TURKISH     = 'utf8mb4_turkish_ci';
	
	
	// -------------------------------------------------------------------------
	// Cyrillic
	// -------------------------------------------------------------------------
	
	/** CP1251 Cyrillic */
	public const CP1251_GENERAL      = 'cp1251_general_ci';
	
	/** UTF8MB4 Russian */
	public const UTF8MB4_RUSSIAN     = 'utf8mb4_russian_ci';
	
	/** UTF8MB4 Ukrainian */
	public const UTF8MB4_UKRAINIAN   = 'utf8mb4_ukrainian_ci';
	
	
	// -------------------------------------------------------------------------
	// East Asian
	// -------------------------------------------------------------------------
	
	/** GBK Simplified Chinese */
	public const GBK_CHINESE         = 'gbk_chinese_ci';
	
	/** GB2312 Simplified Chinese */
	public const GB2312_CHINESE      = 'gb2312_chinese_ci';
	
	/** Big5 Traditional Chinese */
	public const BIG5_CHINESE        = 'big5_chinese_ci';
	
	/** EUC-KR Korean */
	public const EUCKR_KOREAN        = 'euckr_korean_ci';
	
	/** CP932 Japanese */
	public const CP932_JAPANESE      = 'cp932_japanese_ci';
	
	/** UJIS Japanese */
	public const UJIS_JAPANESE       = 'ujis_japanese_ci';
	
	
	// -------------------------------------------------------------------------
	// Legacy UTF8 (3-byte) — only for old DB compat
	// -------------------------------------------------------------------------
	
	public const UTF8_GENERAL        = 'utf8_general_ci';
	public const UTF8_UNICODE        = 'utf8_unicode_ci';
	public const UTF8_BIN            = 'utf8_bin';
}

?>