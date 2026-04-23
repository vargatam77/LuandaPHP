<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <fieldset> HTML element.
 */
class FieldSet extends Node {
    protected ?string $parent = null;   // Associated form ID
    protected ?Legend $legend = null;   // Optional legend label

    /**
     * Constructor for the FieldSet element.
     *
     * @param string|null $legendText Optional legend label text.
     */
    public function __construct(?string $legendText = null) {
        if ($legendText !== null) {
            $this->legend = new Legend($legendText);
        }
    }

    /**
     * Associate this fieldset with a form by its ID.
     *
     * @param string $formId The ID of the parent form.
     * @return void
     */
    public function setParent(string $formId): void {
        $this->parent = $formId;
    }

    /**
     * Set a Legend element explicitly.
     *
     * @param Legend $legend The legend element.
     * @return void
     */
    public function setLegend(Legend $legend): void {
        $this->legend = $legend;
    }

    /**
     * Generate the HTML representation of the <fieldset> element.
     *
     * @return string The HTML representation of the <fieldset> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        if ($this->legend) {
            $this->legend->setLevel($this->level + 1);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<fieldset'
            . ($this->inert  ? ' disabled="disabled"' : '')
            . ($this->parent ? ' form="' . $this->parent . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->legend  ? $this->legend->getHtml()  : '')
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</fieldset>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <legend> HTML element.
 */
class Legend extends Node {
    protected string $label; // Caption text

    /**
     * Constructor for the Legend element.
     *
     * @param string $label The caption text.
     */
    public function __construct(string $label) {
        $this->label = $this->safeHtml($label);
    }

    /**
     * Generate the HTML representation of the <legend> element.
     *
     * @return string The HTML representation of the <legend> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<legend'
            . $this->getAttributes()
            . '>'
            . $this->label
            . ($this->content ? $this->content->getHtml() : '')
            . '</legend>';

        return $html;
    }
}

?>
