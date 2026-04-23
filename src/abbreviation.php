<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <abbr> element.
 */
class Abbreviation extends Node {
    
    /**
     * Constructor for the abbreviation element.
     */
    public function __construct() {
        
    }

    /**
     * Generate the HTML representation of the abbreviation.
     *
     * @return string The HTML representation of the abbreviation.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space
            . '<abbr'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</abbr>';

        return $html;
    }
}

?>