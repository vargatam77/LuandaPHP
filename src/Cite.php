<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <cite> element.
 */
class Cite extends Node {
    
    /**
     * Constructor for the cite element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML representation of the cite element.
     *
     * @return string The HTML representation of the cite element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<cite'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</cite>';
            
        return $html;
    }
}

?>