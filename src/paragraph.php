<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a <p> HTML element with attributes and content.
 */
class paragraph extends global_attr {
    protected ?html_content $content = null; // Content of the <p> element
    protected int $level = 0; // Level of indentation for HTML output
    
    /**
     * Sets the level of indentation for HTML output.
     *
     * @param int $level Level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the paragraph element.
     */
    public function __construct() {
    }
    
    /**
     * Adds content to the paragraph element.
     *
     * @param mixed $content Content to add.
     */
    public function addContent($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Adds a clone of content to the paragraph element.
     *
     * @param mixed $content Content to clone and add.
     */
    public function addClone($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add(Cloner::getClone($content));
    }
    
    /**
     * Generates the HTML representation of the paragraph element.
     *
     * @return string HTML representation of the paragraph element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $paragraph = "\n" . $space . "<p"
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</p>";
                
        return $paragraph;
    }
}

?>