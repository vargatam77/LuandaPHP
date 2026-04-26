<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <select> HTML element with options.
 */
class Select extends Node {
    protected ?string $parent = null; // Form ID
    protected ?int $size = null; // Size attribute
    protected bool $required = false; // Required attribute
    protected bool $multiple = false; // Multiple attribute
    protected array $options = []; // Array of options
    
    /**
     * Constructor for the Select element.
     */
    public function __construct() {
        
    }
    
    /**
     * Sets the parent form ID.
     *
     * @param string $form_id The ID of the parent form
     * @return void
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Sets the size attribute of the select element.
     *
     * @param int $size The size attribute value
     * @return void
     */
    public function setSize(int $size): void {
        $this->size = $size;
    }
    
    /**
     * Enables the multiple attribute.
     *
     * @return void
     */
    public function enableMultiple(): void {
        $this->multiple = true;
    }
    
    /**
     * Adds an option to the select element.
     *
     * @param Option $element The option element to add
     * @return void
     */
    public function addOption(Option $element): void {
        $this->options[] = $element;
    }
    
    /**
     * Sets the required attribute.
     *
     * @param bool $is_required Whether the select is required
     * @return void
     */
    public function setRequired(bool $is_required = true): void {
        $this->required = $is_required;
    }
    
    /**
     * Retrieves the index of the selected option.
     *
     * @return int|null The index of the selected option
     */
    public function getSelected(): ?int {
        $result = null;
        foreach ($this->options as $index => $option) {
            if ($option->isSelected()) $result = $index;
        }
        return $result;
    }
    
    /**
     * Generate HTML representation of the select element.
     *
     * @return string The HTML representation
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<select'
            . ($this->parent ? ' form="' . $this->parent . '"' : '')
            . ($this->inert ? ' disabled="disabled"' : '')
            . ($this->required ? ' required="required"' : '')
            . ($this->autofocus ? ' autofocus="autofocus"' : '')
            . ($this->multiple ? ' multiple="multiple"' : '')
            . ($this->size ? ' size="' . (string)$this->size . '"' : '')
            . $this->getAttributes()
            . '>';
            
        foreach ($this->options as $option) {
            $option->setLevel($this->level + 1);
            $html .= $option->getHtml();
        }
        
        $html .= "\n" . $space . '</select>';
        
        return $html;
    }
}

/**
 * Represents an <option> HTML element.
 */
class Option extends Node {
    public string $value; // Value attribute
    public string $text; // Text content
    protected bool $selected = false; // Selected attribute
    
    /**
     * Constructor for the Option element.
     *
     * @param string $value The value attribute
     * @param string $text The text content
     */
    public function __construct(string $value, string $text) {
        $this->value = $this->safeHtml($value);
        $this->text = $this->safeHtml($text);
    }
    
    /**
     * Selects the option.
     *
     * @return void
     */
    public function select(): void {
        $this->selected = true;
    }
    
    /**
     * Deselects the option.
     *
     * @return void
     */
    public function deSelect(): void {
        $this->selected = false;
    }
    
    /**
     * Checks if the option is selected.
     *
     * @return bool True if selected
     */
    public function isSelected(): bool {
        return $this->selected;
    }
    
    /**
     * Generate HTML representation of the option element.
     *
     * @return string The HTML representation
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<option value="' . $this->value . '"'
            . ($this->inert ? ' disabled="disabled"' : '')
            . ($this->selected ? ' selected="selected"' : '')
            . $this->getAttributes()
            . '>' . $this->text . '</option>';
            
        return $html;
    }
}