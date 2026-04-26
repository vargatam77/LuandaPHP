<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a code HTML element. TODO rework this
 */
class Code extends Node {
    protected ?string $text = null; // Text content of the code element
    protected bool $formatted = false; // Flag indicating if content is preformatted
    
    /**
     * Constructor for the Code element.
     *
     * @param string|null $text The initial text content for the code element
     */
    public function __construct(?string $text = null) {
        if($text) $this->setText($text);
    }
    
    /**
     * Set the text content of the code element.
     *
     * @param string $text The text content to set
     * @return void
     */
    public function setText(string $text): void {
        $this->text = $this->safeHtml($text);
    }
    
    /**
     * Set whether the content should be preformatted with a <pre> tag.
     *
     * @param bool $formatted Whether to preformat the content
     * @return void
     */
    public function preformat(bool $formatted = true): void {
        $this->formatted = $formatted;
    }
    
    /**
     * Add a line of text to the existing text content.
     *
     * @param string $text One line of code to add
     * @return void
     */
    public function addLine(string $text): void {
        $this->text .= $this->safeHtml($text) . "\n";
    }
    
    /**
     * Fetch text content from a specified URL and set it as the content.
     *
     * @param string $url The URL from which to fetch content
     * @return void
     */
    public function getFromURL(string $url): void {
        $this->text = $this->safeHtml(file_get_contents($url));
    }
    
    /**
     * Generate the HTML representation of the code element.
     *
     * @return string The HTML representation of the code element
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = ($this->formatted ? "\n" . $space . '<pre>' : '')
            . '<code' . $this->getAttributes() . '>'
            . $this->text
            . '</code>'
            . ($this->formatted ? '</pre>' : '');
                
        return $html;
    }
}

?>