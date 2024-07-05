<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents an abbreviation HTML element.
 */
class abbreviation extends global_attr {
    protected ?string $title = '';          // Title attribute of the abbreviation
    protected ?string $text = '';           // Text content of the abbreviation
    protected int $level = 0;              // Level of the abbreviation
    
    /**
     * Set the level of the abbreviation.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor method for the abbreviation class.
     *
     * @param string $title The title attribute of the abbreviation.
     * @param string $text The text content of the abbreviation.
     */
    public function __construct(string $title, string $text) {
        $this->title = $title;
        $this->text = $text;
    }
    
    /**
     * Generate the HTML representation of the abbreviation.
     *
     * @return string The HTML representation of the abbreviation.
     */
    public function getHtml(): string {
        // Generate the indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the abbreviation
        $abbr = $space . "<abbr title='" . $this->title . "'"
            . $this->getAttributes()
            . ">"
            . $this->text
            . "</abbr>";
                
        return $abbr;
    }
}

?>