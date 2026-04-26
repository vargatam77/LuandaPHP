<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Class Text
 *
 * Represents a text element with various formatting options.
 */
class Text extends Node {
    protected string $text = ''; // Text content
    protected bool $formatted = false; // Flag indicating preformatted text
    public bool $strong = false; // Flag indicating strong emphasis
    
    /**
     * Constructor.
     *
     * @param string $text The initial text content
     */
    public function __construct(string $text) {
        $this->setText($text);
    }
    
    /**
     * Sets the text content.
     *
     * @param string $text The text content to set
     * @return void
     */
    public function setText(string $text): void {
        $this->text = $this->safeHtml($text);
    }
    
    /**
     * Appends text to the existing content.
     *
     * @param string $text The text content to append
     * @return void
     */
    public function addText(string $text): void {
        $this->text .= $this->safeHtml($text);
    }
    
    /**
     * Retrieves the current text content.
     *
     * @return string The text content
     */
    public function getText(): string {
        return $this->text;
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
     * Retrieves content from a given URL and sets it as the text content.
     *
     * @param string $url The URL to fetch content from
     * @return void
     */
    public function getFromURL(string $url): void {
        $this->text = $this->safeHtml(file_get_contents($url));
    }
    
    /**
     * Generates the HTML representation of the text element.
     *
     * @return string The HTML representation of the text
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = ($this->formatted ? "\n" . $space . '<pre'
            . $this->getAttributes() . '>' : '')
            . ($this->strong ? '<strong>' : '')
            . $this->text
            . ($this->strong ? '</strong>' : '')
            . ($this->formatted ? '</pre>' : '');
        
        return $html;
    }
}

?>