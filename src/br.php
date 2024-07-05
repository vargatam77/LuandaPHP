<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a line break (<br>) HTML element.
 */
class br {
    protected int $level = 0;  // Level of indentation for HTML output
    
    /**
     * Set the level of the line break element.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
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
        // Generate the indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the br element
        $br = "\n" . $space . "<br/>";
        
        return $br;
    }
}

?>