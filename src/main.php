<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a main HTML element.
 */
class main extends global_attr {
    protected ?html_content $content = null; // Content of the main element
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
     * Constructor for the main element.
     */
    public function __construct() {
    }
    
    /**
     * Add content to the main element.
     *
     * @param mixed $content Content to add to the main element.
     */
    public function addContent($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Add a cloned content to the main element.
     *
     * @param mixed $content Content to clone and add to the main element.
     */
    public function addClone($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add(Cloner::getClone($content));
    }
    
    /**
     * Generate HTML representation of the main element.
     *
     * @return string The HTML string representing the main element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $main = "\n" . $space . "<main"
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</main>";
                
        return $main;
    }
}

?>