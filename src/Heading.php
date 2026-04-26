<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a heading HTML element.
 */
class Heading extends Node {
    protected ?int $headingLevel = null; // Level of the heading (e.g., 1 for <h1>, 2 for <h2>, etc.)
    
    /**
     * Constructor to initialize heading with a specified level.
     *
     * @param int $headingLevel The level of the heading
     */
    public function __construct(int $headingLevel) {
        $this->setHeadingLevel($headingLevel);
    }
    
    /**
     * Set the level of the heading.
     *
     * @param int $headingLevel The level of the heading
     * @return void
     */
    public function setHeadingLevel(int $headingLevel): void {
        $this->headingLevel = $headingLevel;
    }
    
    /**
     * Generate HTML representation of the heading.
     *
     * @return string The HTML representation of the heading
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<h' . (string)$this->headingLevel
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</h' . (string)$this->headingLevel . '>';
            
        return $html;
    }
}

?>