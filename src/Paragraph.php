<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <p> HTML element with attributes and content.
 */
class Paragraph extends Node {
    
    /**
     * Constructor for the Paragraph element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate HTML representation of the paragraph element.
     *
     * @return string The HTML representation of the paragraph element
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<p'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</p>';
            
        return $html;
    }
}

?>