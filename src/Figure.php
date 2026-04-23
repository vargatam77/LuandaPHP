<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <figure> HTML element.
 */
class Figure extends Node {
    protected ?FigCaption $caption = null; // Optional caption for this figure

    /**
     * Constructor for the Figure element.
     *
     * @param string|null $captionText Optional caption text.
     */
    public function __construct(?string $captionText = null) {
        if ($captionText !== null) {
            $this->caption = new FigCaption($captionText);
        }
    }

    /**
     * Set a FigCaption element explicitly.
     *
     * @param FigCaption $caption The caption element.
     * @return void
     */
    public function setCaption(FigCaption $caption): void {
        $this->caption = $caption;
    }

    /**
     * Generate the HTML representation of the <figure> element.
     *
     * @return string The HTML representation of the <figure> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        if ($this->caption) {
            $this->caption->setLevel($this->level + 1);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<figure'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . ($this->caption ? $this->caption->getHtml() : '')
            . "\n" . $space . '</figure>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <figcaption> HTML element.
 */
class FigCaption extends Node {
    protected string $text; // Caption text

    /**
     * Constructor for the FigCaption element.
     *
     * @param string $text The caption text.
     */
    public function __construct(string $text) {
        $this->text = $this->safeHtml($text);
    }

    /**
     * Generate the HTML representation of the <figcaption> element.
     *
     * @return string The HTML representation of the <figcaption> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<figcaption'
            . $this->getAttributes()
            . '>'
            . $this->text
            . ($this->content ? $this->content->getHtml() : '')
            . '</figcaption>';

        return $html;
    }
}

?>
