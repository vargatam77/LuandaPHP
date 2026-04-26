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
     * @param IRenderableInterface $content The content to add.
     * @return void
     */
    public function Add(IRenderableInterface $content): void {
        $this->contents[] = $content;
    }
    
    /**
     * Get the number of elements in the content.
     *
     * @return int The number of elements in the content array.
     */
    public function Length(): int {
        return count($this->contents);
    }
    
    /**
     * Generate HTML representation of the content and its nested elements.
     *
     * @return string The HTML representation of the content.
     */
    public function getHtml(): string {
        $_html = '';
        
        foreach ($this->contents as $_element) {
            $_element->setLevel($this->level);
            $_html .= $_element->getHtml();
        }
        
        return $_html;
    }
}

?>