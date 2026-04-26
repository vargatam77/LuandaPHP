<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <div> HTML element.
 */
class Div extends Node {
    
    /**
     * Constructor for the Div element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML representation of the <div> element.
     *
     * @return string The HTML representation of the <div> element.
     */
    public function getHtml(): string {
        $this->content?->setLevel($this->level + 1);
        
        $_indent = str_repeat(indent_type::TAB, $this->level);
        
        $_html = special_chars::NEWLINE . $_indent . '<div'
        	. $this->getClasses()
        	. $this->getAttributes()
        	. $this->getEvents()
            . '>'
            . $this->content?->getHtml()
            . special_chars::NEWLINE . $_indent . '</div>';
                
        return $_html;
    }
}

?>
