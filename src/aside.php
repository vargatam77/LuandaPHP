<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an aside HTML element.
 */
class Aside extends Node {
    
    /**
     * Constructor for the Aside element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML representation of the aside element.
     *
     * @return string The HTML representation of the aside element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<aside'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</aside>';
            
        return $html;
    }
}

?>