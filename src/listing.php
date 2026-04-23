<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a list HTML element (ul, ol, or dl).
 */
class Listing extends Node {
    protected ?string $listStyle = null; // Style of the list
    
    /**
     * Constructor for the Listing element.
     *
     * @param string $style Style from list_style helper
     */
    public function __construct(string $list_style) {
        $this->listStyle = $list_style;
    }
    
    /**
     * Generate HTML representation of the list element.
     *
     * @return string The HTML representation of the list
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        $list_type = 'ul';
        
        if ($this->listStyle === list_style::ORDERED) $list_type = 'ol';
        if ($this->listStyle === list_style::DESCRIPTION) $list_type = 'dl';
        
        $html = "\n" . $space . '<' . $list_type
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</' . $list_type . '>';
            
        return $html;
    }
}

?>