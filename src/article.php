<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an article HTML element.
 */
class Article extends Node {
    
    /**
     * Constructor for the Article element.
     */
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML representation of the article element.
     *
     * @return string The HTML representation of the article element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<article'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</article>';
                
        return $html;
    }
}

?>