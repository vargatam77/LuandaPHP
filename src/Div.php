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
        $this->content?->setLevel($this->level);
        
        $_indent = str_repeat(self::$indentString, $this->level);
        
        $_html = self::$newlineString
        	. $_indent . '<div'
        	. $this->getClasses()
        	. $this->getAttributes()
        	. $this->getEvents()
            . '>'
            . $this->content?->getHtml()
            . self::$newlineString
        	. $_indent . '</div>';
                
        return $_html;
    }
}

?>
