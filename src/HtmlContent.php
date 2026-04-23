<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents HTML content that can contain nested elements.
 */
class HtmlContent {
    private array $contents = []; // Array to store child content elements
    private int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     * @return void
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
     * @param object $content The content to add.
     * @return void
     */
    public function add(object $content): void {
        $this->contents[] = $content;
    }
    
    /**
     * Get the number of elements in the content.
     *
     * @return int The number of elements in the content array.
     */
    public function length(): int {
        return count($this->contents);
    }
    
    /**
     * Generate HTML representation of the content and its nested elements.
     *
     * @return string The HTML representation of the content.
     */
    public function getHtml(): string {
        $html = '';
        
        foreach ($this->contents as $object) {
            $object->setLevel($this->level + 1);
            $html .= $object->getHtml();
        }
        
        return $html;
    }
}

?>