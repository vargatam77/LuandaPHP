<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class select
 * Represents a <select> HTML element with options.
 */
class select extends global_attr {
    protected int $level = 0;             // Indentation level
    protected ?string $parent = null;     // Form ID
    protected ?int $size = null;          // Size attribute
    protected bool $required = false;     // Required attribute
    protected bool $multiple = false;     // Multiple attribute
    protected bool $disabled = false;     // Disabled attribute
    protected bool $focused = false;      // Autofocus attribute
    protected array $options = [];        // Array of options
    
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
     * Disables the select element.
     */
    public function disable(): void {
        $this->disabled = true;
    }
    
    /**
     * Focuses the select element.
     */
    public function focus(): void {
        $this->focused = true;
    }
    
    /**
     * Sets the parent form ID.
     *
     * @param string $form_id The ID of the parent form
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Sets the size attribute of the select element.
     *
     * @param int $size The size attribute value
     */
    public function setSize(int $size): void {
        $this->size = $size;
    }
    
    /**
     * Enables the multiple attribute for selecting multiple options.
     */
    public function enableMultiple(): void {
        $this->multiple = true;
    }
    
    /**
     * Adds an option to the select element.
     *
     * @param option $element The option element to add
     */
    public function addOption(option $element): void {
        $this->options[] = $element;
    }
    
    /**
     * Sets the required attribute for the select element.
     *
     * @param bool $isRequired Whether the select is required or not
     */
    public function setRequired(bool $isRequired = true): void {
        $this->required = $isRequired;
    }
    
    /**
     * Retrieves the index of the selected option.
     *
     * @return int|null The index of the selected option, or null if none is selected
     */
    public function getSelected(): ?int {
        foreach ($this->options as $index => $option) {
            if ($option->isSelected()) {
                return $index;
            }
        }
        return null;
    }
    
    /**
     * Retrieves the HTML representation of all options.
     *
     * @return string The HTML representation of the options
     */
    public function getOptions(): string {
        $optionsHtml = '';
        foreach ($this->options as $option) {
            $option->setLevel($this->level + 1);
            $optionsHtml .= $option->getHtml();
        }
        return $optionsHtml;
    }
    
    /**
     * Generates and retrieves the HTML representation of the select element.
     *
     * @return string The HTML representation of the select element
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        // Start select tag
        $select = "\n" . $space . "<select"
            . (($this->parent) ? " form='" . $this->parent . "'" : "")
            . (($this->disabled) ? " disabled='disabled'" : "")
            . (($this->required) ? " required='required'" : "")
            . (($this->focused) ? " autofocus='autofocus'" : "")
            . (($this->multiple) ? " multiple='multiple'" : "")
            . (($this->size) ? " size='" . $this->size . "'" : "")
            . $this->getAttributes()
            . ">";
            
            // Add options
            $select .= $this->getOptions();
            
            // Close select tag
            $select .= "\n" . $space . "</select>";
            
        return $select;
    }
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Class option
 * Represents an <option> HTML element.
 */
class option extends global_attr {
    protected int $level = 0;         // Indentation level
    public string $value;           // Value attribute
    public string $text;            // Text content
    protected bool $disabled = false; // Disabled attribute
    protected bool $selected = false; // Selected attribute
    
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
     *
     * @param string $value The value attribute of the option
     * @param string $text The text content of the option
     */
    public function __construct(string $value, string $text) {
        $this->value = $value;
        $this->text = $text;
    }
    
    /**
     * Enables the option.
     */
    public function enable(): void {
        $this->disabled = false;
    }
    
    /**
     * Disables the option.
     */
    public function disable(): void {
        $this->disabled = true;
    }
    
    /**
     * Selects the option.
     */
    public function select(): void {
        $this->selected = true;
    }
    
    /**
     * Deselects the option.
     */
    public function deSelect(): void {
        $this->selected = false;
    }
    
    /**
     * Checks if the option is selected.
     *
     * @return bool True if the option is selected, false otherwise
     */
    public function isSelected(): bool {
        return $this->selected;
    }
    
    /**
     * Checks if the option is disabled.
     *
     * @return bool True if the option is disabled, false otherwise
     */
    public function isDisabled(): bool {
        return $this->disabled;
    }
    
    /**
     * Generates and retrieves the HTML representation of the option element.
     *
     * @return string The HTML representation of the option element
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        // Generate option tag
        $option = "\n" . $space . "\t<option value='" . $this->value . "'"
            . (($this->disabled) ? " disabled='disabled'" : "")
            . (($this->selected) ? " selected='selected'" : "")
            . ">" . $this->text . "</option>";
            
            return $option;
    }
}

?>