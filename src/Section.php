<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <section> HTML element.
 */
class Section extends Node {

    /**
     * Constructor for the Section element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <section> element.
     *
     * @return string The HTML representation of the <section> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<section'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</section>';

        return $html;
    }
}

?>
