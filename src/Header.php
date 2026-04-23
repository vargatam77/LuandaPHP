<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <header> HTML element.
 */
class Header extends Node {

    /**
     * Constructor for the Header element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <header> element.
     *
     * @return string The HTML representation of the <header> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<header'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</header>';

        return $html;
    }
}

?>
