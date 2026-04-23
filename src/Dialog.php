<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <dialog> HTML element.
 */
class Dialog extends Node {
    protected bool $open = false; // Whether the dialog is open by default

    /**
     * Constructor for the Dialog element.
     */
    public function __construct() {

    }

    /**
     * Show the dialog open by default.
     *
     * @return void
     */
    public function open(): void {
        $this->open = true;
    }

    /**
     * Generate the HTML representation of the <dialog> element.
     *
     * @return string The HTML representation of the <dialog> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<dialog'
            . ($this->open ? ' open="open"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</dialog>';

        return $html;
    }
}

?>
