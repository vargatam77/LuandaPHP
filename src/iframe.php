<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML iframe element.
 */
class Iframe extends Node {
    protected ?string $src = null; // URL of the content to embed
    
    /**
     * Constructor for the iframe element.
     *
     * @param string $src URL of the content to embed
     * @param string $title Title attribute of the iframe
     */
    public function __construct(string $src = '', string $title = '') {
        $this->src = $src;
        if ($title !== '') {
            $this->setTitle($title);
        }
    }
    
    /**
     * Set the URL of the content to embed.
     *
     * @param string $src URL of the content to embed.
     * @return void
     */
    public function setUrl(string $src = ''): void {
        $this->src = $src;
    }
    
    /**
     * Generate HTML representation of the iframe element.
     *
     * @return string The HTML representation of the iframe element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<iframe'
            . ($this->src ? ' src="' . $this->src . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</iframe>';
                
        return $html;
    }
}

?>