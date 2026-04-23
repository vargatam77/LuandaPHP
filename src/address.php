<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an address HTML element.
 */
class Address extends Node {
    
    /**
     * Constructor for the Address element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML representation of the address element.
     *
     * @return string The HTML representation of the address element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<address'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</address>';
                
        return $html;
    }
}

?>