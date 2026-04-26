<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a button HTML element.
 */
class Button extends Node {
    protected ?string $type = null; // Type of the button
    protected ?string $parent = null; // Parent form ID for the button
    public ?string $value = null; // Value attribute of the button
    
    /**
     * Constructor for the button element.
     *
     * @param string $type The type of the button (e.g., 'submit', 'reset', 'button').
     */
    public function __construct(string $type) {
        $this->type = $type;
    }
    
    /**
     * Set the parent form ID for the button.
     *
     * @param string $form_id The ID of the parent form.
     * @return void
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Generate the HTML representation of the button element.
     *
     * @return string The HTML representation of the button element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<button type="' . $this->type . '"'
            . ($this->value ? ' value="' . $this->value . '"' : '')
            . ($this->autofocus ? ' autofocus="autofocus"' : '')
            . ($this->inert ? ' disabled="disabled"' : '')
            . ($this->parent ? ' form="' . $this->parent . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</button>';
                
        return $html;
    }
}

?>