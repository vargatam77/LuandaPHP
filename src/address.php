<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents an address HTML element.
 */
class address extends global_attr {
    protected ?html_content $content = null;  // Content of the address element
    protected int $level = 0;                  // Level of indentation for HTML output
    
    /**
     * Set the level of the address element.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor method for the address class.
     */
    public function __construct() {
        
    }
    
    /**
     * Add content to the address element.
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
     * Add a cloned content to the address element.
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
     * Generate the HTML representation of the address element.
     *
     * @return string The HTML representation of the address element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        // Generate the indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the address element
        $address = "\n" . $space . "<address"
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</address>";
                
        return $address;
    }
}

?>