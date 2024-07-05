<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a canvas HTML element.
 */
class canvas extends global_attr {
    protected ?html_content $content = null; // Content of the canvas
    protected int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the level of the canvas element.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor method for the canvas class.
     */
    public function __construct() {
        // Constructor can be left empty as no additional setup is needed
    }
    
    /**
     * Add content to the canvas.
     *
     * @param mixed $content The content to add to the canvas.
     */
    public function addContent($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Add a clone of content to the canvas.
     *
     * @param mixed $content The content to clone and add to the canvas.
     */
    public function addClone($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add(Cloner::getClone($content));
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
        
        // Generate the indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the canvas element
        $canvas = "\n" . $space . "<canvas"
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</canvas>";
                
        return $canvas;
    }
}

?>