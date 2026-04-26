<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a main HTML element.
 */
class Main extends Node {
    
    /**
     * Constructor for the Main element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate HTML representation of the main element.
     *
     * @return string The HTML representation of the main element.
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<main'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</main>';
            
        return $html;
    }
}

?>