<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a list item HTML element (li, dt, or dd).
 */
class ListItem extends Node {
    protected string $type = 'li'; // Default list item type

    /**
     * Constructor for the ListItem element.
     */
    public function __construct() {
        
    }

    /**
     * Set the type of the list item.
     * 
     * @param string $type The tag type (li, dt, dd)
     * @return void
     */
    public function setType(string $type): void {
        $this->type = $type;
    }

    /**
     * Generate HTML representation of the list item.
     * 
     * @return string The HTML representation of the list item
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<' . $this->type
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</' . $this->type . '>';
            
        return $html;
    }
}

?>