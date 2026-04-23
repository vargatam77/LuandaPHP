<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\DataBase;

/**
 * Represents a single database column and its metadata.
 * Populated from sp_table_columns result row.
 * Pure data holder — no DB access of its own.
 */
class Column {
    
    public string  $name;
    public string  $type;
    public ?int    $size;
    public bool    $unsigned;
    public bool    $nullable;
    public bool    $autoIncrement;
    public bool    $isPrimary;
    public bool    $isUnique;
    public ?string $default;
    public ?string $charset;
    public ?string $collation;
    public ?string $comment;
    public string  $rawType;
    
    public function __construct(array $row) {
        $this->name          = $row['Field'];
        $this->rawType       = $row['Type'];
        $this->nullable      = strtolower($row['Null'])    === 'yes';
        $this->autoIncrement = str_contains(strtolower($row['Extra'] ?? ''), 'auto_increment');
        $this->isPrimary     = strtolower($row['Key']      ?? '') === 'pri';
        $this->isUnique      = strtolower($row['Key']      ?? '') === 'uni';
        $this->default       = $row['Default']             ?? null;
        $this->charset       = $row['Collation']           ? explode('_', $row['Collation'])[0] : ($row['Charset'] ?? null);
        $this->collation     = $row['Collation']           ?? null;
        $this->comment       = $row['Comment'] !== ''      ? $row['Comment'] : null;
        
        $this->parseType($row['Type']);
    }
    
    // -------------------------------------------------------------------------
    // Internal
    // -------------------------------------------------------------------------
    
    private function parseType(string $raw): void {
        $_size     = null;
        $_unsigned = false;
        $_base     = $raw;
        $_matches  = [];
        
        if (preg_match('/^([a-z]+)\(([^)]+)\)/i', $raw, $_matches)) {
            $_base = $_matches[1];
            $_size = is_numeric($_matches[2])
            ? (int)$_matches[2]
            : null;
        } else {
            $_base = preg_replace('/\s+.*$/', '', $raw);
        }
        
        if (str_contains(strtolower($raw), 'unsigned')) {
            $_unsigned = true;
        }
        
        $this->type     = strtolower($_base);
        $this->size     = $_size;
        $this->unsigned = $_unsigned;
    }
}


/**
 * Column type constants.
 * Struct-style constant class, no instantiation.
 */
class col_type {
    // numeric
    const TINYINT    = 'tinyint';
    const SMALLINT   = 'smallint';
    const MEDIUMINT  = 'mediumint';
    const INT        = 'int';
    const BIGINT     = 'bigint';
    const FLOAT      = 'float';
    const DOUBLE     = 'double';
    const DECIMAL    = 'decimal';
    const BIT        = 'bit';
    // string
    const CHAR       = 'char';
    const VARCHAR    = 'varchar';
    const TINYTEXT   = 'tinytext';
    const TEXT       = 'text';
    const MEDIUMTEXT = 'mediumtext';
    const LONGTEXT   = 'longtext';
    const BINARY     = 'binary';
    const VARBINARY  = 'varbinary';
    // blob
    const TINYBLOB   = 'tinyblob';
    const BLOB       = 'blob';
    const MEDIUMBLOB = 'mediumblob';
    const LONGBLOB   = 'longblob';
    // date / time
    const DATE       = 'date';
    const DATETIME   = 'datetime';
    const TIMESTAMP  = 'timestamp';
    const TIME       = 'time';
    const YEAR       = 'year';
    // other
    const ENUM       = 'enum';
    const SET        = 'set';
    const JSON       = 'json';
    const GEOMETRY   = 'geometry';
}


/**
 * Charset constants.
 * Struct-style constant class, no instantiation.
 */
class col_charset {
    const UTF8MB4 = 'utf8mb4';   // full unicode — use this
    const UTF8    = 'utf8';      // broken 3-byte mysql utf8 — avoid
    const LATIN1  = 'latin1';
    const LATIN2  = 'latin2';
    const ASCII   = 'ascii';
    const BINARY  = 'binary';
    const CP1250  = 'cp1250';
    const CP1251  = 'cp1251';
    const CP1256  = 'cp1256';
    const GREEK   = 'greek';
    const HEBREW  = 'hebrew';
    const SJIS    = 'sjis';
    const GBK     = 'gbk';
    const BIG5    = 'big5';
    const UCS2    = 'ucs2';
    const UTF16   = 'utf16';
    const UTF32   = 'utf32';
}


/**
 * Collation constants.
 * Struct-style constant class, no instantiation.
 */
class col_collation {
    // utf8mb4 — most common
    const UTF8MB4_UNICODE_CI = 'utf8mb4_unicode_ci';
    const UTF8MB4_GENERAL_CI = 'utf8mb4_general_ci';
    const UTF8MB4_BIN        = 'utf8mb4_bin';
    const UTF8MB4_0900_AI_CI = 'utf8mb4_0900_ai_ci';  // MySQL 8 default
    const UTF8MB4_0900_AS_CS = 'utf8mb4_0900_as_cs';  // case sensitive
    // latin1
    const LATIN1_SWEDISH_CI  = 'latin1_swedish_ci';
    const LATIN1_GENERAL_CI  = 'latin1_general_ci';
    const LATIN1_BIN         = 'latin1_bin';
    // ascii
    const ASCII_GENERAL_CI   = 'ascii_general_ci';
    const ASCII_BIN          = 'ascii_bin';
    // binary
    const BINARY             = 'binary';
}

?>