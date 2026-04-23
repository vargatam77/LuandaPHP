<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <ruby> HTML element for East Asian typography annotations.
 */
class Ruby extends Node {

    /**
     * Constructor for the Ruby element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <ruby> element.
     *
     * @return string The HTML representation of the <ruby> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<ruby'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</ruby>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents an <rt> HTML element (ruby text annotation).
 */
class Rt extends Node {

    /**
     * Constructor for the Rt element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <rt> element.
     *
     * @return string The HTML representation of the <rt> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<rt'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</rt>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents an <rp> HTML element (ruby fallback parenthesis).
 */
class Rp extends Node {

    /**
     * Constructor for the Rp element.
     */
    public function __construct() {

    }

    /**
     * Generate the HTML representation of the <rp> element.
     *
     * @return string The HTML representation of the <rp> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<rp'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</rp>';

        return $html;
    }
}

?>
