<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML horizontal rule (HR) element.
 */
class hr {
    protected int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the HR element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate HTML representation of the HR element.
     *
     * @return string The HTML string representing the HR element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        $hr = "\n" . $space . "<hr/>";
        
        return $hr;
    }
}

?>