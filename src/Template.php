<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <template> HTML element.
 * Content inside is inert and not rendered until activated by JavaScript.
 */
class Template extends Node {

    /**
     * Constructor for the Template element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <template> element.
     *
     * @return string The HTML representation of the <template> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<template'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</template>';

        return $html;
    }
}

?>
