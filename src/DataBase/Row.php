<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\DataBase;

use TamasVarga\LuandaPHP\Misc\IncidentReporter;

/**
 * Represents a single data row.
 * Holds original and current values, tracks dirty state per field.
 * No DB access — pure data manipulation and retrieval.
 */
class Row {
    
    private array $original   = [];
    private array $current    = [];
    private array $dirty      = [];
    private bool  $isNew      = false;
    private bool  $isDeleted  = false;
    
    /**
     * @param array $data    Associative field => value from DB result
     * @param bool  $is_new  True if this row doesn't exist in DB yet
     */
    public function __construct(array $data = [], bool $is_new = false) {
        $this->original = $data;
        $this->current  = $data;
        $this->isNew    = $is_new;
    }
    
    // -------------------------------------------------------------------------
    // Data access
    // -------------------------------------------------------------------------
    
    /**
     * Get a single field value.
     */
    public function get(string $field): mixed {
        $_value = null;
        
        if (array_key_exists($field, $this->current)) {
            $_value = $this->current[$field];
        } else {
            IncidentReporter::isAlive() && IncidentReporter::report(
                __CLASS__ . '::get',
                "Field '$field' does not exist in row.",
                row_error::FIELD_NOT_FOUND
                );
        }
        
        return $_value;
    }
    
    /**
     * Get all current field values.
     */
    public function getAll(): array {
        return $this->current;
    }
    
    /**
     * Get only modified fields with their current values.
     * Available for application-level use — dirty fields, change tracking, logging etc.
     */
    public function getDirty(): array {
        $_result = [];
        
        foreach ($this->dirty as $_field => $_flag) {
            if ($_flag) {
                $_result[$_field] = $this->current[$_field];
            }
        }
        
        return $_result;
    }
    
    /**
     * Get the original value of a field before any modifications.
     */
    public function getOriginal(string $field): mixed {
        $_value = null;
        
        if (array_key_exists($field, $this->original)) {
            $_value = $this->original[$field];
        } else {
            IncidentReporter::isAlive() && IncidentReporter::report(
                __CLASS__ . '::getOriginal',
                "Field '$field' does not exist in original row data.",
                row_error::FIELD_NOT_FOUND
                );
        }
        
        return $_value;
    }
    
    // -------------------------------------------------------------------------
    // Data manipulation
    // -------------------------------------------------------------------------
    
    /**
     * Set a single field value. Marks field as dirty if value changed.
     */
    public function set(string $field, mixed $value): void {
        if (!array_key_exists($field, $this->current)) {
            IncidentReporter::isAlive() && IncidentReporter::report(
                __CLASS__ . '::set',
                "Field '$field' does not exist in row.",
                row_error::FIELD_NOT_FOUND
                );
        } else {
            if ($this->current[$field] !== $value) {
                $this->current[$field] = $value;
                $this->dirty[$field]   = true;
            }
        }
    }
    
    /**
     * Set multiple fields at once from an associative array.
     */
    public function setAll(array $data): void {
        foreach ($data as $_field => $_value) {
            $this->set($_field, $_value);
        }
    }
    
    /**
     * Revert a single field to its original value.
     */
    public function revert(string $field): void {
        if (!array_key_exists($field, $this->original)) {
            IncidentReporter::isAlive() && IncidentReporter::report(
                __CLASS__ . '::revert',
                "Field '$field' does not exist in original row data.",
                row_error::FIELD_NOT_FOUND
                );
        } else {
            $this->current[$field] = $this->original[$field];
            unset($this->dirty[$field]);
        }
    }
    
    /**
     * Revert all fields to their original values.
     */
    public function revertAll(): void {
        $this->current = $this->original;
        $this->dirty   = [];
    }
    
    /**
     * Mark row for deletion. Table handles the actual delete call.
     */
    public function delete(): void {
        $this->isDeleted = true;
    }
    
    // -------------------------------------------------------------------------
    // State
    // -------------------------------------------------------------------------
    
    public function isDirty(): bool {
        return !empty($this->dirty);
    }
    
    public function isNew(): bool {
        return $this->isNew;
    }
    
    public function isDeleted(): bool {
        return $this->isDeleted;
    }
    
    /**
     * Called by DataTable after a successful save.
     * Resets dirty tracking and promotes current values to original.
     */
    public function commit(): void {
        $this->original  = $this->current;
        $this->dirty     = [];
        $this->isNew     = false;
    }
}


/**
 * Error codes for Row operations.
 * Struct-style constant class, no instantiation.
 */
final class row_error {
    const FIELD_NOT_FOUND = 2001;
    
    private function __construct() {}
}

?>