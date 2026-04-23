<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\DataBase;

use TamasVarga\LuandaPHP\Misc\IncidentReporter;
use TamasVarga\LuandaPHP\Misc\IniParser;
use PDO;
use PDOStatement;
use PDOException;

/**
 * Multi-connection database manager.
 *
 * Handle naming:
 *   Connection opened, no db selected  → handle: configname
 *   Database selected on handle        → handle renamed: configname.dbname
 *
 * Connections and their original DbConfig are both stored internally.
 * Multiple handles can share one PDO (same server, different db).
 *
 * Flow:
 *   construct(parser, configname)          opens server connection → handle: configname
 *   selectDatabase(handleName, dbname)     USE db, renames handle to configname.dbname
 *   add()                                  clones first connection creds, no db → handle: configname
 *   add(configname)                        clones named connection creds, no db → handle: configname
 *   add(parser, configname)                fresh connection from ini → handle: configname
 *   exec(handleName, procedure, params)    CALL on handle's connection → PDOStatement|null
 */
class DataBase {
    
    // [ configname => PDO ]
    private array $connections = [];
    
    // [ configname => DbConfig ] stored so cloneConnection can reuse credentials
    private array $configs = [];
    
    // [ handleName => [ 'connName' => string, 'currentDb' => string|null ] ]
    private array $handles = [];
    
    // -------------------------------------------------------------------------
    // Construction
    // -------------------------------------------------------------------------
    
    public function __construct(IniParser &$parser, string $configName) {
        $_config = new DbConfig();
        $parser->fillSettingStruct($configName, $_config);
        $this->openConnection($_config, $configName);
    }
    
    // -------------------------------------------------------------------------
    // Public API
    // -------------------------------------------------------------------------
    
    /**
     * Add a connection or clone an existing one.
     *
     *   add()                   clone first connection, no db → handle: its configname
     *   add(configname)         clone named connection, no db → handle: configname
     *   add(parser, configname) fresh connection from ini     → handle: configname
     *
     * Cloning without a db on the source is rejected — it would produce a
     * duplicate handle name. Parser provided without configname is also rejected.
     * Parser null and configname null with no connections is rejected.
     */
    public function add(?IniParser &$parser = null, ?string $configName = null): bool {
        $_result = false;
        
        if ($parser === null && $configName === null) {
            $_first = $this->resolveFirstConnName();
            if ($_first !== '') {
                $_result = $this->cloneConnection($_first);
            }
        } elseif ($parser === null && $configName !== null) {
            $_result = $this->cloneConnection($configName);
        } elseif ($parser !== null && $configName !== null) {
            $_config = new DbConfig();
            $parser->fillSettingStruct($configName, $_config);
            $_result = $this->openConnection($_config, $configName);
        } else {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::add', 'Parser provided but configName is null.');
            }
        }
        
        return $_result;
    }
    
    /**
     * Select a database on a bare connection handle (one without a dot).
     * Runs USE, then renames the handle from configname to configname.dbname.
     * Calling this on a handle that already has a db selected is rejected —
     * use add() to open a second db on the same server instead.
     */
    public function selectDatabase(string $handleName, string $dbName): bool {
        $_result     = false;
        $_new_handle = $handleName . '.' . $dbName;
        
        if (!isset($this->handles[$handleName])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::selectDatabase', 'Handle not found: ' . $handleName);
            }
        } elseif (str_contains($handleName, '.')) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::selectDatabase', 'Handle "' . $handleName . '" already has a database selected. Use add() to open another.');
            }
        } elseif (isset($this->handles[$_new_handle])) {
            // handle already registered with this db — nothing to do, not an error
            $_result = true;
        } else {
            $_conn_name = $this->handles[$handleName]['connName'];
            $_Pdo       = $this->connections[$_conn_name] ?? null;
            
            if ($_Pdo === null) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report('DataBase::selectDatabase', 'Connection not found for handle: ' . $handleName);
                }
            } else {
                try {
                    $_Pdo->exec('USE ' . $dbName);
                    unset($this->handles[$handleName]);
                    $this->handles[$_new_handle] = [
                        'connName'  => $_conn_name,
                        'currentDb' => $dbName
                    ];
                    $_result = true;
                } catch (PDOException $e) {
                    if (IncidentReporter::isAlive()) {
                        IncidentReporter::report('DataBase::selectDatabase', 'USE ' . $dbName . ' failed on "' . $handleName . '" | ' . $e->getMessage());
                    }
                }
            }
        }
        
        return $_result;
    }
    
    /**
     * Execute a stored procedure on a named handle.
     * Returns PDOStatement on success, null on failure.
     */
    public function exec(?string $handleName, string $procedure, array $params = []): ?PDOStatement {
        $_result       = null;
        $_Pdo          = $this->getPdo($handleName);
        
        if ($_Pdo !== null) {
            $_placeholders = [];
            $_bound        = [];
            
            foreach ($params as $_i => $_value) {
                $_key            = ':p' . $_i;
                $_placeholders[] = $_key;
                $_bound[$_key]   = $_value;
            }
            
            $_sql  = 'CALL ' . $procedure;
            $_sql .= !empty($_placeholders)
            ? '(' . implode(', ', $_placeholders) . ')'
                : '()';
                
                try {
                    $_Stmt = $_Pdo->prepare($_sql);
                    
                    foreach ($_bound as $_key => $_value) {
                        $_Stmt->bindValue($_key, $_value);
                    }
                    
                    $_Stmt->execute();
                    $_result = $_Stmt;
                    
                } catch (PDOException $e) {
                    if (IncidentReporter::isAlive()) {
                        IncidentReporter::report('DataBase::exec', 'Procedure "' . $procedure . '" failed on "' . $handleName . '" | ' . $e->getMessage());
                    }
                }
        }
        
        return $_result;
    }
    
    /**
     * Remove a handle. Closes underlying connection if no other handle uses it.
     */
    public function removeHandle(?string $handleName = null): void {
        $_target = $handleName ?? array_key_first($this->handles);
        
        if ($_target === null) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::removeHandle', 'No handles registered.');
            }
        } elseif (!isset($this->handles[$_target])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::removeHandle', 'Handle not found: ' . $_target);
            }
        } else {
            $_conn_name = $this->handles[$_target]['connName'];
            unset($this->handles[$_target]);
            
            if (!$this->connectionHasHandles($_conn_name)) {
                unset($this->connections[$_conn_name]);
                unset($this->configs[$_conn_name]);
            }
        }
    }
    
    // -------------------------------------------------------------------------
    // Transaction management
    // -------------------------------------------------------------------------
    
    public function begin(?string $handleName = null): bool {
        $_result = false;
        $_Pdo    = $this->getPdo($handleName);
        
        if ($_Pdo !== null) {
            try {
                $_result = $_Pdo->beginTransaction();
            } catch (PDOException $e) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report('DataBase::begin', 'Begin transaction failed on "' . $handleName . '" | ' . $e->getMessage());
                }
            }
        }
        
        return $_result;
    }
    
    public function commit(?string $handleName = null): bool {
        $_result = false;
        $_Pdo    = $this->getPdo($handleName);
        
        if ($_Pdo !== null) {
            try {
                $_result = $_Pdo->commit();
            } catch (PDOException $e) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report('DataBase::commit', 'Commit failed on "' . $handleName . '" | ' . $e->getMessage());
                }
            }
        }
        
        return $_result;
    }
    
    public function rollback(?string $handleName = null): bool {
        $_result = false;
        $_Pdo    = $this->getPdo($handleName);
        
        if ($_Pdo !== null) {
            try {
                $_result = $_Pdo->rollBack();
            } catch (PDOException $e) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report('DataBase::rollback', 'Rollback failed on "' . $handleName . '" | ' . $e->getMessage());
                }
            }
        }
        
        return $_result;
    }
    
    // -------------------------------------------------------------------------
    // Internal
    // -------------------------------------------------------------------------
    
    /**
     * Opens a fresh PDO connection from a DbConfig struct.
     * Stores both the PDO and the original config (needed for cloning).
     * Registers a bare handle as configname with no db selected.
     */
    private function openConnection(DbConfig $config, string $configName): bool {
        $_result = false;
        
        if (isset($this->connections[$configName])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::openConnection', 'Connection already exists: ' . $configName);
            }
        } else {
            try {
                $_dsn = 'mysql:host=' . $config->host
                . ';port='     . $config->port
                . ';charset=utf8mb4';
                
                $_options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                
                $_Pdo = new PDO($_dsn, $config->user, $config->pwd, $_options);
                
                $this->connections[$configName] = $_Pdo;
                $this->configs[$configName]     = $config;
                $this->handles[$configName]     = [
                    'connName'  => $configName,
                    'currentDb' => null
                ];
                
                $_result = true;
                
            } catch (PDOException $e) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report('DataBase::openConnection', 'PDO connect failed for "' . $configName . '" | ' . $e->getMessage());
                }
            }
        }
        
        return $_result;
    }
    
    /**
     * Clones an existing connection's credentials into a new PDO instance.
     * The source must have a db selected (its handle name contains a dot),
     * which means the bare configname is free for the new handle.
     * Cloning a bare connection would produce a duplicate handle name — rejected.
     */
    private function cloneConnection(string $configName): bool {
        $_result = false;
        
        if (!isset($this->connections[$configName])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::cloneConnection', 'Source connection not found: ' . $configName);
            }
        } elseif (isset($this->handles[$configName])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::cloneConnection', 'Cannot clone "' . $configName . '": source has no database selected, handle name would collide.');
            }
        } else {
            $_config = $this->configs[$configName] ?? null;
            
            if ($_config === null) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report('DataBase::cloneConnection', 'No stored config found for: ' . $configName);
                }
            } else {
                try {
                    $_dsn = 'mysql:host=' . $_config->host
                    . ';port='     . $_config->port
                    . ';charset=utf8mb4';
                    
                    $_options = [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ];
                    
                    $_new_Pdo = new PDO($_dsn, $_config->user, $_config->pwd, $_options);
                    
                    $this->connections[$configName] = $_new_Pdo;
                    $this->handles[$configName]     = [
                        'connName'  => $configName,
                        'currentDb' => null
                    ];
                    
                    $_result = true;
                    
                } catch (PDOException $e) {
                    if (IncidentReporter::isAlive()) {
                        IncidentReporter::report('DataBase::cloneConnection', 'PDO clone failed for "' . $configName . '" | ' . $e->getMessage());
                    }
                }
            }
        }
        
        return $_result;
    }
    
    /**
     * Returns the configname of the first registered connection.
     * Used by add() with no arguments to identify what to clone.
     */
    private function resolveFirstConnName(): string {
        $_result = '';
        $_first  = array_key_first($this->connections);
        
        if ($_first === null) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::resolveFirstConnName', 'No connections registered.');
            }
        } else {
            $_result = $_first;
        }
        
        return $_result;
    }
    
    /**
     * Returns the PDO for a given handle name.
     * If handleName is null, falls back to the first registered handle.
     * Reports if no handles exist, handle has no db selected, handle not found,
     * or underlying connection is missing.
     */
    private function getPdo(?string $handleName): ?PDO {
        $_result = null;
        $_target = $handleName ?? array_key_first($this->handles);
        
        if ($_target === null) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::getPdo', 'No handles registered.');
            }
        } elseif (!str_contains($_target, '.')) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::getPdo', 'Handle "' . $_target . '" has no database selected.');
            }
        } elseif (!isset($this->handles[$_target])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report('DataBase::getPdo', 'Handle not found: ' . $_target);
            }
        } else {
            $_conn_name = $this->handles[$_target]['connName'];
            
            if (!isset($this->connections[$_conn_name])) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report('DataBase::getPdo', 'Connection not found for handle: ' . $_target);
                }
            } else {
                $_result = $this->connections[$_conn_name];
            }
        }
        
        return $_result;
    }
    
    /**
     * Returns true if any handle still references the given connection name.
     * Used by removeHandle to decide whether to close the underlying PDO.
     */
    private function connectionHasHandles(string $connName): bool {
        $_result = false;
        
        foreach ($this->handles as $_handle) {
            if ($_handle['connName'] === $connName) {
                $_result = true;
                break;
            }
        }
        
        return $_result;
    }
}

// -------------------------------------------------------------------------
// Helper definitions
// -------------------------------------------------------------------------

/**
 * Settings struct filled by IniParser from the binary ini.
 * Property declaration order must match the binary layout exactly.
 */
class DbConfig {
    public string $host;
    public string $user;
    public string $pwd;
    public int    $port;
}

/**
 * Error code constants for the database layer.
 * Snake_case per naming convention for definition-only helpers.
 */
class db_error {
    const CONNECTION_FAILED    = 1001;
    const CONNECTION_NOT_FOUND = 1002;
    const DUPLICATE_CONNECTION = 1003;
    const EXEC_FAILED          = 1004;
    const TRANSACTION_FAILED   = 1005;
}

?>