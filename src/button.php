<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a button HTML element.
 */
class button extends global_attr {
    protected ?html_content $content = null; // Content of the button
    protected ?string $type = null; // Type of the button
    protected bool $focused = false; // Indicates if the button is focused
    protected bool $disabled = false; // Indicates if the button is disabled
    protected ?string $parent = null; // Parent form ID for the button
    public ?string $value = null; // Value attribute of the button
    protected int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the level of the button element.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor method for the button class.
     *
     * @param string $type The type of the button (e.g., 'submit', 'reset', 'button').
     */
    public function __construct(string $type) {
        $this->type = $type;
    }
    
    /**
     * Disable the button.
     */
    public function disable(): void {
        $this->disabled = true;
    }
    
    /**
     * Focus on the button.
     */
    public function focus(): void {
        $this->focused = true;
    }
    
    /**
     * Set the parent form ID for the button.
     *
     * @param string $form_id The ID of the parent form.
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Add content to the button.
     *
     * @param mixed $content The content to add to the button.
     */
    public function addContent($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Add a clone of content to the button.
     *
     * @param mixed $content The content to clone and add to the button.
     */
    public function addClone($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add(Cloner::getClone($content));
    }
    
    /**
     * Generate the HTML representation of the button element.
     *
     * @return string The HTML representation of the button element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        // Generate the indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the button element
        $button = "\n" . $space . "<button type='" . $this->type . "'"
            . (($this->value) ? " value='" . $this->value . "'" : "")
            . (($this->focused) ? " autofocus='autofocus'" : "")
            . (($this->disabled) ? " disabled='disabled'" : "")
            . (($this->parent) ? " form='" . $this->parent . "'" : "")
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</button>";
                
        return $button;
    }
}

?>