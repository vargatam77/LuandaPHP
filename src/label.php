<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a label HTML element.
 */
class Label extends Node {
    protected ?string $input = null; // Associated input element ID
    protected ?string $parent = null; // Parent form ID for the label
    
    /**
     * Constructor for the label element.
     */
    public function __construct() {
        
    }
    
    /**
     * Set the associated input element ID for the label.
     *
     * @param string $input_id ID of the associated input element
     * @return void
     */
    public function setInput(string $input_id): void {
        $this->input = $input_id;
    }
    
    /**
     * Set the parent form ID for the label.
     *
     * @param string $form_id Parent form ID for the label
     * @return void
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Generate HTML representation of the label element.
     *
     * @return string The HTML representation of the label
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<label'
            . ($this->parent ? ' form="' . $this->parent . '"' : '')
            . ($this->input ? ' for="' . $this->input . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</label>';
            
        return $html;
    }
}

?>