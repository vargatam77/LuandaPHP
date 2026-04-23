<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <noscript> HTML element.
 */
class Noscript extends Node {
    
    /**
     * Constructor for the Noscript element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate HTML representation of the noscript element.
     *
     * @return string The HTML representation of the noscript element
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<noscript'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</noscript>';
            
        return $html;
    }
}

?>