<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents an article HTML element.
 */
class article extends global_attr {
    protected ?html_content $content = null;  // Content of the article element
    protected int $level = 0;                  // Level of indentation for HTML output
    
    /**
     * Set the level of the article element.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor method for the article class.
     */
    public function __construct() {
        
    }
    
    /**
     * Add content to the article element.
     *
     * @param mixed $content The content to add.
     */
    public function addContent($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Add a cloned content to the article element.
     *
     * @param mixed $content The content to clone and add.
     */
    public function addClone($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add(Cloner::getClone($content));
    }
    
    /**
     * Generate the HTML representation of the article element.
     *
     * @return string The HTML representation of the article element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        // Generate the indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the article element
        $article = "\n" . $space . "<article"
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</article>";
                
        return $article;
    }
}

?>