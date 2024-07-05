<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a <div> HTML element.
 */
class div extends global_attr {
    protected ?html_content $content = null; // Content within the <div> element
    protected int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the level of indentation for HTML output.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor method for the div class.
     */
    public function __construct() {
        // Constructor does not require any initializations
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
     * Output the <div> element directly to the browser.
     */
    public function show(): void {
        echo $this->getHtml();
    }
    
    /**
     * Generate the HTML representation of the <div> element.
     *
     * @return string The HTML representation of the <div> element.
     */
    public function getHtml(): string {
        // Ensure content's indentation level is set
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        // Generate indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the <div> element
        $div = "\n" . $space . "<div"
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</div>";
                
        return $div;
    }
}

?>