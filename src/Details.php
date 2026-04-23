<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <details> HTML element.
 */
class Details extends Node {
    protected bool $open = false;           // Whether the details are open by default
    protected ?Summary $summary = null;     // The summary label for this details block

    /**
     * Constructor for the Details element.
     *
     * @param string|null $summaryText Optional visible label text.
     */
    public function __construct(?string $summaryText = null) {
        if ($summaryText !== null) {
            $this->summary = new Summary($summaryText);
        }
    }

    /**
     * Expand the details block by default.
     *
     * @return void
     */
    public function expand(): void {
        $this->open = true;
    }

    /**
     * Set a Summary element explicitly.
     *
     * @param Summary $summary The summary element.
     * @return void
     */
    public function setSummary(Summary $summary): void {
        $this->summary = $summary;
    }

    /**
     * Generate the HTML representation of the <details> element.
     *
     * @return string The HTML representation of the <details> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        if ($this->summary) {
            $this->summary->setLevel($this->level + 1);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<details'
            . ($this->open ? ' open="open"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->summary ? $this->summary->getHtml() : '')
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</details>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <summary> HTML element.
 */
class Summary extends Node {
    protected string $label; // Visible label text

    /**
     * Constructor for the Summary element.
     *
     * @param string $label The visible label text.
     */
    public function __construct(string $label) {
        $this->label = $this->safeHtml($label);
    }

    /**
     * Generate the HTML representation of the <summary> element.
     *
     * @return string The HTML representation of the <summary> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<summary'
            . $this->getAttributes()
            . '>'
            . $this->label
            . ($this->content ? $this->content->getHtml() : '')
            . '</summary>';

        return $html;
    }
}

?>
