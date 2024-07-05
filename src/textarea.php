<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class textarea
 * Represents a textarea element with various attributes.
 */
class textarea extends global_attr {
    protected int $level = 0;            // Indentation level
    protected ?string $parent = null;    // Form ID attribute
    public ?string $value = null;      // Initial value
    public bool $readonly = false;     // Readonly flag
    public bool $required = false;     // Required flag
    protected bool $disabled = false;    // Disabled flag
    protected ?int $minlen = null;       // Minimum length attribute
    protected ?int $maxlen = null;       // Maximum length attribute
    protected ?int $rows = null;         // Rows attribute
    protected ?int $cols = null;         // Columns attribute
    protected ?string $placeholder = null; // Placeholder attribute
    protected bool $focused = false;     // Focused flag
    
    /**
     * Sets the indentation level for formatting.
     *
     * @param int $level The level of indentation
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor.
     */
    public function __construct() {
        
    }
    
    /**
     * Disables the textarea element.
     */
    public function disable(): void {
        $this->disabled = true;
    }
    
    /**
     * Sets the focus on the textarea element.
     */
    public function focus(): void {
        $this->focused = true;
    }
    
    /**
     * Sets the parent form ID attribute.
     *
     * @param string $form_id The ID of the parent form
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Sets the size (columns and rows) of the textarea.
     *
     * @param int $cols The number of columns
     * @param int $rows The number of rows
     */
    public function setSize(int $cols, int $rows): void {
        $this->cols = $cols;
        $this->rows = $rows;
    }
    
    /**
     * Sets the minimum and maximum length attributes.
     *
     * @param int|null $minlen The minimum length (optional)
     * @param int|null $maxlen The maximum length (optional)
     */
    public function setMinMaxLen(?int $minlen = null, ?int $maxlen = null): void {
        $this->minlen = $minlen;
        $this->maxlen = $maxlen;
    }
    
    /**
     * Sets the placeholder attribute.
     *
     * @param string $placeholder The placeholder text
     */
    public function setPlaceholder(string $placeholder): void {
        $this->placeholder = $placeholder;
    }
    
    /**
     * Generates the HTML representation of the textarea element.
     *
     * @return string The HTML representation of the textarea
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $textarea = "\n{$space}<textarea"
            .($this->parent ? " form='{$this->parent}'" : "")
            .($this->readonly ? " readonly='readonly'" : "")
            .($this->disabled ? " disabled='disabled'" : "")
            .($this->minlen ? " minlength='{$this->minlen}'" : "")
            .($this->maxlen ? " maxlength='{$this->maxlen}'" : "")
            .($this->rows ? " rows='{$this->rows}'" : "")
            .($this->cols ? " cols='{$this->cols}'" : "")
            .($this->required ? " required='required'" : "")
            .($this->focused ? " autofocus='autofocus'" : "")
            .($this->placeholder ? " placeholder='{$this->placeholder}'" : "")
            .$this->getAttributes()
            .">"
            .($this->value ? "\n{$this->value}" : "")
            ."</textarea>";
            
        return $textarea;
    }
}
?>