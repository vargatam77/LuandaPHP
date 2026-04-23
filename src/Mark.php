<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <mark> HTML element.
 */
class Mark extends Node {

    /**
     * Constructor for the Mark element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <mark> element.
     *
     * @return string The HTML representation of the <mark> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<mark'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</mark>';

        return $html;
    }
}

?>
