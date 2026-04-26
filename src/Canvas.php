<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a canvas HTML element.
 */
class Canvas extends Node {
    
    /**
     * Constructor for the Canvas element.
     */
    public function __construct() {
        // Default HTML5 fallback content
        $this->addContent(new Text('Your browser does not support the HTML5 canvas tag.'));
    }
    
    /**
     * Generate the HTML representation of the canvas element.
     *
     * @return string The HTML representation of the canvas element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<canvas'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</canvas>';
            
        return $html;
    }
}

?>