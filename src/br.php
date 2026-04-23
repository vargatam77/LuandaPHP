<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a line break (<br>) HTML element.
 */
class Br extends Node {
    
    /**
     * Constructor method for the br class.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML representation of the br element.
     *
     * @return string The HTML representation of the br element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<br'
            . $this->getAttributes()
            . ' />';
            
        return $html;
    }
}

?>