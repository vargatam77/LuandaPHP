<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <output> element.
 */
class Output extends Node {
    public string|int|float|null $value = null; // Current value of the output
    protected ?string $input = null; // Associated input element IDs (for attribute)
    protected ?string $parent = null; // Parent form ID (form attribute)
    
    /**
     * Constructor for the Output element.
     *
     * @param string|null $id The ID of the element
     * @param string|null $value Initial value
     */
    public function __construct(?string $id = null, string|int|float|null $value = null) {
        if ($id) $this->id = $id;
        if ($value !== null) $this->value = is_string($value) ? $this->safeHtml($value) : (string)$value;
    }
    
    /**
     * Set the associated input element ID for the output.
     *
     * @param string $input_id ID of the associated input element
     * @return void
     */
    public function setInput(string $input_id): void {
        $this->input = $input_id;
    }
    
    /**
     * Set the parent form ID for the output.
     *
     * @param string $form_id Parent form ID
     * @return void
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Generate the HTML representation of the output element.
     *
     * @return string The HTML representation of the output element
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<output'
            . ($this->parent ? ' form="' . $this->parent . '"' : '')
            . ($this->input ? ' for="' . $this->input . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->value ? (string)$this->value : '')
            . '</output>';
            
        return $html;
    }
}

?>