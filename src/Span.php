<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <span> HTML element.
 */
class Span extends Node {
    
    /**
     * Constructor for the Span element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate HTML representation of the span element.
     *
     * @return string The HTML representation of the span element.
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<span'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</span>';
            
        return $html;
    }
}

?>