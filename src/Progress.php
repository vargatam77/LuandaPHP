<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <progress> HTML element.
 */
class Progress extends Node {
    protected int|float|null $value = null; // Current progress value
    protected int|float|null $max = null;   // Maximum value

    /**
     * Constructor for the Progress element.
     *
     * @param int|float|null $value Current progress value. Omit for indeterminate.
     * @param int|float|null $max   Maximum value (default 1.0).
     */
    public function __construct(int|float|null $value = null, int|float|null $max = null) {
        $this->value = $value;
        $this->max   = $max;
    }

    /**
     * Generate the HTML representation of the <progress> element.
     *
     * @return string The HTML representation of the <progress> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<progress'
            . ($this->value !== null ? ' value="' . $this->value . '"' : '')
            . ($this->max   !== null ? ' max="'   . $this->max   . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</progress>';

        return $html;
    }
}

?>
