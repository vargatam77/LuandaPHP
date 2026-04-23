<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Class Anchor
 *
 * Represents a hyperlink (<a>) element with various attributes.
 */
class Anchor extends Node {
    protected ?string $url = null; // URL attribute
    protected ?string $target = null; // Target attribute
    protected ?string $rel = null; // Relationship attribute
    protected ?string $type = null; // Type attribute
    
    /**
     * Constructor for the Anchor element.
     * 
     * @param string|null $url Optional URL
     */
    public function __construct(?string $url = null) {
        if ($url) $this->url = $this->safeUrl($url);
    }
    
    /**
     * Sets the target attribute of the hyperlink.
     *
     * @param string $target The target attribute value
     * @return void
     */
    public function setTarget(string $target): void {
        $this->target = $this->safeHtml($target);
    }
    
    /**
     * Sets the rel (relationship) attribute of the hyperlink.
     *
     * @param string $rel The rel attribute value
     * @return void
     */
    public function setRelation(string $rel): void {
        $this->rel = $this->safeHtml($rel);
    }
    
    /**
     * Sets the type attribute of the hyperlink.
     *
     * @param string $type The type attribute value
     * @return void
     */
    public function setType(string $type): void {
        $this->type = $this->safeHtml($type);
    }
    
    /**
     * Generates the HTML representation of the hyperlink.
     *
     * @return string The HTML representation of the hyperlink
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<a'
            . ($this->url ? ' href="' . $this->url . '"' : '') // Omit href if null
            . ($this->target ? ' target="' . $this->target . '"' : '')
            . ($this->type ? ' type="' . $this->type . '"' : '')
            . ($this->rel ? ' rel="' . $this->rel . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</a>';
            
        return $html;
    }
}

?>