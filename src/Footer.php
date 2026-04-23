<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <footer> HTML element.
 */
class Footer extends Node {

    /**
     * Constructor for the Footer element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <footer> element.
     *
     * @return string The HTML representation of the <footer> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<footer'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</footer>';

        return $html;
    }
}

?>
