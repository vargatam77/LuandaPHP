<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <pre> HTML element.
 */
class Pre extends Node {

    /**
     * Constructor for the Pre element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <pre> element.
     *
     * @return string The HTML representation of the <pre> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<pre'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</pre>';

        return $html;
    }
}

?>
