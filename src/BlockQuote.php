<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <blockquote> element.
 */
class BlockQuote extends Node {
    protected ?string $citeUrl = null; // URL for the source of the quote
    
    /**
     * Constructor for the blockquote.
     *
     * @param string|null $citeUrl Optional URL source
     */
    public function __construct(?string $citeUrl = null) {
        if($citeUrl) $this->citeUrl = $this->safeUrl($citeUrl);
    }
    
    /**
     * Generate the HTML representation of the blockquote element.
     *
     * @return string The HTML representation of the blockquote element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<blockquote'
            . ($this->citeUrl ? ' cite="' . $this->citeUrl . '"' : '')
            . $this->getAttributes()
            . '>'
            . "\n" . $space . "\t" . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</blockquote>';
            
        return $html;
    }
}

?>