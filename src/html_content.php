<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents HTML content that can contain nested elements.
 */
class html_content {
    private array $contents = []; // Array to store content elements
    private int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor to initialize HTML content.
     */
    public function __construct() {
        
    }
    
    /**
     * Add content to the HTML element.
     *
     * @param mixed $content The content to add.
     */
    public function add($content): void {
        $this->contents[] = $content;
    }
    
    /**
     * Get the number of elements in the content.
     *
     * @return int The number of elements in the content.
     */
    public function length(): int {
        return count($this->contents);
    }
    
    /**
     * Generate HTML representation of the content.
     *
     * @return string The HTML string representing the content and its nested elements.
     */
    public function getHtml(): string {
        $html = '';
        
        if ($this->contents) {
            foreach ($this->contents as $object) {
                $object->setLevel($this->level + 1);
                $html .= $object->getHtml();
            }
        }
        
        return $html;
    }
}

?>