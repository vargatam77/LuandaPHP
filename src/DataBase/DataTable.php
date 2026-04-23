<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\DataBase;

use TamasVarga\LuandaPHP\Misc\IncidentReporter;

/**
 * DataTable — orchestrates DB interaction, column metadata, and row lifecycle.
 * Holds a Database reference, a column collection, a row collection,
 * and a proc registry. All DB access goes through here.
 */
class DataTable {
    
    private DataBase $db;
    private string   $tableName;
    private ?string  $dbHandle;
    
    private array    $columns     = [];  // field_name => Column
    private array    $primaryKeys = [];  // [ field_name, ... ]
    private array    $uniqueKeys  = [];  // [ field_name => [ field_name, ... ] ]
    
    private array    $rows        = [];  // Row[]
    private array    $registry    = [];  // alias => [ proc, type ]
    
    /**
     * @param DataBase    $db        Shared connection manager (passed by reference implicitly — objects always are)
     * @param string      $tableName Table or view name
     * @param string|null $dbHandle  Handle name (configname.dbname). Null defers to DataBase first handle.
     *                               If the handle does not exist yet, DataTable will call selectDatabase
     *                               on the DataBase instance to register it automatically.
     */
    public function __construct(DataBase $db, string $tableName, ?string $dbHandle = null) {
        $this->db        = $db;
        $this->tableName = $tableName;
        $this->dbHandle  = $dbHandle;
        
        if ($dbHandle !== null && str_contains($dbHandle, '.')) {
            $_parts = explode('.', $dbHandle, 2);
            $this->db->selectDatabase($_parts[0], $_parts[1]);
        }
    }
    
    // -------------------------------------------------------------------------
    // Column initialisation
    // -------------------------------------------------------------------------
    
    /**
     * Load column metadata and key info via registered '_columns' proc alias.
     * Register before calling: $table->register('_columns', 'sp_table_columns');
     * Safe to call on views — key collections will simply be empty.
     * Can be called again to refresh if schema changed at runtime.
     */
    public function loadColumns(): bool {
        $_result = false;
        
        if (!isset($this->registry['_columns'])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::loadColumns',
                    "No '_columns' proc registered. Use register('_columns', 'your_proc').",
                    table_error::MISSING_PROC
                    );
            }
        } else {
            $_Stmt = $this->db->exec(
                $this->dbHandle,
                $this->registry['_columns']['proc'],
                [$this->tableName]
                );
            
            if ($_Stmt !== null) {
                $_columns      = [];
                $_primary_keys = [];
                $_unique_keys  = [];
                
                foreach ($_Stmt->fetchAll() as $_row_data) {
                    $_Col                  = new Column($_row_data);
                    $_columns[$_Col->name] = $_Col;
                    
                    if ($_Col->isPrimary) {
                        $_primary_keys[] = $_Col->name;
                    }
                    
                    if ($_Col->isUnique) {
                        $_unique_keys[$_Col->name] = [$_Col->name];
                    }
                }
                
                $this->columns     = $_columns;
                $this->primaryKeys = $_primary_keys;
                $this->uniqueKeys  = $_unique_keys;
                $_result           = true;
            }
        }
        
        return $_result;
    }
    
    // -------------------------------------------------------------------------
    // Proc registry
    // -------------------------------------------------------------------------
    
    /**
     * Register a stored procedure alias.
     *
     * @param string $alias  Friendly name to call on this table
     * @param string $proc   Stored procedure name in DB
     * @param string $type   read | write | delete
     */
    public function register(string $alias, string $proc, string $type = 'read'): void {
        if (!in_array($type, ['read', 'write', 'delete'])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::register',
                    "Invalid proc type '$type' for alias '$alias'. Use read, write or delete.",
                    table_error::INVALID_PROC_TYPE
                    );
            }
        } else {
            $this->registry[$alias] = ['proc' => $proc, 'type' => $type];
        }
    }
    
    /**
     * Magic call — handles registered read proc aliases.
     * e.g. $table->getUsers(1) calls the proc registered as 'getUsers'
     */
    public function __call(string $alias, array $params): bool {
        $_result = false;
        
        if (!isset($this->registry[$alias])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::__call',
                    "No proc registered for alias '$alias'.",
                    table_error::MISSING_PROC
                    );
            }
        } elseif ($this->registry[$alias]['type'] !== 'read') {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::__call',
                    "Alias '$alias' is not a read proc. Write and delete procs are called via save().",
                    table_error::INVALID_PROC_TYPE
                    );
            }
        } else {
            $_Stmt = $this->db->exec(
                $this->dbHandle,
                $this->registry[$alias]['proc'],
                $params
                );
            
            if ($_Stmt !== null) {
                $this->populate($_Stmt->fetchAll());
                $_result = true;
            }
        }
        
        return $_result;
    }
    
    // -------------------------------------------------------------------------
    // Row access
    // -------------------------------------------------------------------------
    
    public function getRows(): array {
        return $this->rows;
    }
    
    public function getRow(int $index): ?Row {
        $_result = null;
        
        if (isset($this->rows[$index])) {
            $_result = $this->rows[$index];
        } else {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::getRow',
                    "Row at index $index does not exist.",
                    table_error::ROW_NOT_FOUND
                    );
            }
        }
        
        return $_result;
    }
    
    /**
     * Add a new empty row ready for population and saving.
     * Fields are pre-seeded from column defaults.
     * Requires loadColumns() to have been called first.
     */
    public function addRow(): Row {
        $_data = [];
        
        if (empty($this->columns)) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::addRow',
                    'No column metadata loaded. Call loadColumns() before addRow().',
                    table_error::COLUMN_NOT_FOUND
                    );
            }
        } else {
            foreach ($this->columns as $_Col) {
                $_data[$_Col->name] = $_Col->default;
            }
        }
        
        $_Row         = new Row($_data, true);
        $this->rows[] = $_Row;
        
        return $_Row;
    }
    
    /**
     * Remove a row from the collection (without DB delete).
     * For DB deletion use Row::delete() then save().
     */
    public function removeRow(int $index): void {
        if (!isset($this->rows[$index])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::removeRow',
                    "Row at index $index does not exist.",
                    table_error::ROW_NOT_FOUND
                    );
            }
        } else {
            array_splice($this->rows, $index, 1);
        }
    }
    
    // -------------------------------------------------------------------------
    // Column / key access
    // -------------------------------------------------------------------------
    
    public function getColumns(): array {
        return $this->columns;
    }
    
    public function getColumn(string $name): ?Column {
        $_result = null;
        
        if (isset($this->columns[$name])) {
            $_result = $this->columns[$name];
        } else {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::getColumn',
                    "Column '$name' not found.",
                    table_error::COLUMN_NOT_FOUND
                    );
            }
        }
        
        return $_result;
    }
    
    public function getPrimaryKeys(): array {
        return $this->primaryKeys;
    }
    
    public function getUniqueKeys(): array {
        return $this->uniqueKeys;
    }
    
    // -------------------------------------------------------------------------
    // Save — public entry point
    // -------------------------------------------------------------------------
    
    /**
     * Persist all dirty, new, and deleted rows within a single transaction.
     * Accepts an optional callback fired after each step: callable(string $step, bool $result)
     */
    public function save(?callable $callback = null): bool {
        $_result      = false;
        $_dirty_rows  = [];
        $_delete_rows = [];
        $_success     = true;
        
        foreach ($this->rows as $_index => $_Row) {
            if ($_Row->isDeleted()) {
                $_delete_rows[$_index] = $_Row;
            } elseif ($_Row->isDirty() || $_Row->isNew()) {
                $_dirty_rows[$_index] = $_Row;
            }
        }
        
        $callback && $callback('collect', true);
        
        if (!empty($_dirty_rows) && !isset($this->registry['save'])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::save',
                    'Dirty rows exist but no write proc is registered.',
                    table_error::MISSING_WRITE_PROC
                    );
            }
            $_success = false;
        }
        
        if (!empty($_delete_rows) && !isset($this->registry['delete'])) {
            if (IncidentReporter::isAlive()) {
                IncidentReporter::report(
                    __CLASS__ . '::save',
                    'Deleted rows exist but no delete proc is registered.',
                    table_error::MISSING_DELETE_PROC
                    );
            }
            $_success = false;
        }
        
        $callback && $callback('validate', $_success);
        
        if ($_success && empty($_dirty_rows) && empty($_delete_rows)) {
            $callback && $callback('nothing_to_save', true);
            $_result = true;
        }
        
        if ($_success && (!empty($_dirty_rows) || !empty($_delete_rows))) {
            $_success = $this->beginSave($callback);
            
            if ($_success && !empty($_dirty_rows)) {
                $_success = $this->processDirty($_dirty_rows, $callback);
            }
            
            if ($_success && !empty($_delete_rows)) {
                $_success = $this->processDeleted($_delete_rows, $callback);
            }
            
            if ($_success) {
                $_result = $this->commitSave($_delete_rows, $callback);
            } else {
                $this->rollbackSave($callback);
            }
        }
        
        return $_result;
    }
    
    // -------------------------------------------------------------------------
    // Save — internal steps
    // -------------------------------------------------------------------------
    
    private function beginSave(?callable $callback): bool {
        $_result = $this->db->begin($this->dbHandle);
        $callback && $callback('begin', $_result);
        return $_result;
    }
    
    private function processDirty(array $dirty_rows, ?callable $callback): bool {
        $_result = true;
        
        foreach ($dirty_rows as $_Row) {
            $_Stmt = $this->db->exec(
                $this->dbHandle,
                $this->registry['save']['proc'],
                array_values($_Row->getAll())
                );
            
            if ($_Stmt === null || $_Stmt->rowCount() < 1) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report(
                        __CLASS__ . '::processDirty',
                        'Write proc returned no affected rows — possible constraint violation or duplicate key.',
                        table_error::WRITE_AFFECTED_NONE
                        );
                }
                $_result = false;
                break;
            }
            
            $_Row->commit();
        }
        
        $callback && $callback('dirty', $_result);
        return $_result;
    }
    
    private function processDeleted(array $delete_rows, ?callable $callback): bool {
        $_result = true;
        
        foreach ($delete_rows as $_Row) {
            $_params = [];
            
            foreach ($this->primaryKeys as $_pk) {
                $_params[] = $_Row->get($_pk);
            }
            
            $_Stmt = $this->db->exec(
                $this->dbHandle,
                $this->registry['delete']['proc'],
                $_params
                );
            
            if ($_Stmt === null || $_Stmt->rowCount() < 1) {
                if (IncidentReporter::isAlive()) {
                    IncidentReporter::report(
                        __CLASS__ . '::processDeleted',
                        'Delete proc returned no affected rows — row may not exist.',
                        table_error::DELETE_AFFECTED_NONE
                        );
                }
                $_result = false;
                break;
            }
        }
        
        $callback && $callback('deleted', $_result);
        return $_result;
    }
    
    private function commitSave(array $delete_rows, ?callable $callback): bool {
        $_result = $this->db->commit($this->dbHandle);
        
        if ($_result) {
            foreach (array_reverse(array_keys($delete_rows)) as $_index) {
                array_splice($this->rows, $_index, 1);
            }
        }
        
        $callback && $callback('commit', $_result);
        return $_result;
    }
    
    private function rollbackSave(?callable $callback): void {
        $this->db->rollback($this->dbHandle);
        $callback && $callback('rollback', true);
    }
    
    // -------------------------------------------------------------------------
    // Internal
    // -------------------------------------------------------------------------
    
    private function populate(array $rows): void {
        $_populated = [];
        
        foreach ($rows as $_row_data) {
            $_populated[] = new Row($_row_data, false);
        }
        
        $this->rows = $_populated;
    }
}

// -------------------------------------------------------------------------
// Helper definitions
// -------------------------------------------------------------------------

/**
 * Error codes for DataTable operations.
 * Snake_case per naming convention for definition-only helpers.
 */
class table_error {
    const MISSING_PROC         = 3001;
    const MISSING_WRITE_PROC   = 3002;
    const MISSING_DELETE_PROC  = 3003;
    const INVALID_PROC_TYPE    = 3004;
    const ROW_NOT_FOUND        = 3005;
    const COLUMN_NOT_FOUND     = 3006;
    const WRITE_AFFECTED_NONE  = 3007;
    const DELETE_AFFECTED_NONE = 3008;
}

?>