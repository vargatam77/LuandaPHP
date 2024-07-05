<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a label HTML element.
 */
class label extends global_attr {
    protected ?html_content $content = null; // Content within the label
    protected int $level = 0; // Level of indentation for HTML output
    protected ?string $input = null; // Associated input element ID
    protected ?string $parent = null; // Parent form ID for the label
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the label element.
     */
    public function __construct() {
    }
    
    /**
     * Set the associated input element ID for the label.
     *
     * @param string $input_id ID of the associated input element.
     */
    public function setInput(string $input_id): void {
        $this->input = $input_id;
    }
    
    /**
     * Set the parent form ID for the label.
     *
     * @param string $form_id Parent form ID for the label.
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
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
     * Generate HTML representation of the label element.
     *
     * @return string The HTML string representing the label element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $label = "\n" . $space . "<label"
            . (($this->parent) ? " form='" . $this->parent . "'" : "")
            . (($this->input) ? " for='" . $this->input . "'" : "")
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</label>";
                
        return $label;
    }
}

?>