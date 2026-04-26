<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <nav> HTML element with attributes and content.
 */
class Nav extends Node {
    
    /**
     * Constructor for the Nav element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate HTML representation of the nav element.
     *
     * @return string The HTML representation of the nav element
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<nav'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</nav>';
            
        return $html;
    }
}

?>