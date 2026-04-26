<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML horizontal rule (HR) element.
 */
class Hr extends Node {
    
    /**
     * Constructor for the Hr element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML representation of the hr element.
     *
     * @return string The HTML representation of the hr element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<hr'
            . $this->getAttributes()
            . ' />';
            
        return $html;
    }
}

?>