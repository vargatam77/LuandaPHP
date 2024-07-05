<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a heading HTML element.
 */
class heading extends global_attr {
    protected ?html_content $content = null; // Content of the heading
    protected ?int $headingLevel = null; // Level of the heading (e.g., 1 for <h1>, 2 for <h2>, etc.)
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
     * Constructor to initialize heading with a specified level.
     *
     * @param int $headingLevel The level of the heading (e.g., 1 for <h1>, 2 for <h2>, etc.).
     */
    public function __construct(int $headingLevel) {
        $this->setHeadingLevel($headingLevel);
    }
    
    /**
     * Add content to the heading element.
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
     * Add a cloned content to the heading element.
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
     * Set the level of the heading.
     *
     * @param int $headingLevel The level of the heading (e.g., 1 for <h1>, 2 for <h2>, etc.).
     */
    public function setHeadingLevel(int $headingLevel): void {
        $this->headingLevel = $headingLevel;
    }
    
    /**
     * Generate HTML representation of the heading.
     *
     * @return string The HTML string representing the heading.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        $head = "\n{$space}<h{$this->headingLevel}"
            . $this->getAttributes()
            . ">"
            . ($this->content ? $this->content->getHtml() : "")
            . "\n{$space}</h{$this->headingLevel}>";
            
        return $head;
    }
}

?>