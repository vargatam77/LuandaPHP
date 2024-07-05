<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class span
 * Represents a <span> HTML element.
 */
class span extends global_attr {
    protected ?html_content $content = null;  // Content of the span element
    protected int $level = 0;                  // Indentation level
    
    /**
     * Sets the indentation level for formatting.
     *
     * @param int $level The level of indentation
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor.
     */
    public function __construct() {
        
    }
    
    /**
     * Adds content to the span element.
     *
     * @param mixed $content The content to add
     */
    public function addContent($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Adds a cloned content to the span element using Cloner.
     *
     * @param mixed $content The content to clone and add
     */
    public function addClone($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add(Cloner::getClone($content));
    }
    
    /**
     * Retrieves the HTML representation of the span element and its content.
     *
     * @return string The HTML representation of the span element
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);   // Indentation
        
        // Generate span tag
        $span = "\n" . $space . "<span"
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</span>";
                
        return $span;
    }
}
?>