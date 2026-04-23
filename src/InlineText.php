<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <strong> HTML element (strong importance).
 */
class Strong extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<strong' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</strong>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents an <em> HTML element (stress emphasis).
 */
class Em extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<em' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</em>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <small> HTML element (side comments / fine print).
 */
class Small extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<small' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</small>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <sub> HTML element (subscript).
 */
class Sub extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<sub' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</sub>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <sup> HTML element (superscript).
 */
class Sup extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<sup' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</sup>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <del> HTML element (deleted text).
 */
class Del extends Node {
    protected ?string $citation = null; // URL explaining the deletion
    protected ?string $datetime = null; // Machine-readable date of deletion

    public function __construct() {}

    /**
     * Set the citation URL explaining why text was deleted.
     *
     * @param string $url Citation URL.
     * @return void
     */
    public function setCitation(string $url): void {
        $this->citation = $this->safeUrl($url);
    }

    /**
     * Set the machine-readable date and time of the deletion.
     *
     * @param string $datetime Valid datetime string.
     * @return void
     */
    public function setDatetime(string $datetime): void {
        $this->datetime = $this->safeHtml($datetime);
    }

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<del'
            . ($this->citation ? ' cite="'    . $this->citation . '"' : '')
            . ($this->datetime ? ' datetime="' . $this->datetime . '"' : '')
            . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</del>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents an <ins> HTML element (inserted text).
 */
class Ins extends Node {
    protected ?string $citation = null; // URL explaining the insertion
    protected ?string $datetime = null; // Machine-readable date of insertion

    public function __construct() {}

    /**
     * Set the citation URL explaining why text was inserted.
     *
     * @param string $url Citation URL.
     * @return void
     */
    public function setCitation(string $url): void {
        $this->citation = $this->safeUrl($url);
    }

    /**
     * Set the machine-readable date and time of the insertion.
     *
     * @param string $datetime Valid datetime string.
     * @return void
     */
    public function setDatetime(string $datetime): void {
        $this->datetime = $this->safeHtml($datetime);
    }

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<ins'
            . ($this->citation ? ' cite="'     . $this->citation . '"' : '')
            . ($this->datetime ? ' datetime="' . $this->datetime . '"' : '')
            . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</ins>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <kbd> HTML element (keyboard input).
 */
class Kbd extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<kbd' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</kbd>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <samp> HTML element (sample output).
 */
class Samp extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<samp' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</samp>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <var> HTML element (variable in math or code).
 */
class Var_ extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<var' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</var>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <q> HTML element (inline quotation).
 */
class Q extends Node {
    protected ?string $citation = null; // URL of the quoted source

    /**
     * Constructor for the Q element.
     *
     * @param string|null $citation Optional URL of the quoted source.
     */
    public function __construct(?string $citation = null) {
        if ($citation) $this->citation = $this->safeUrl($citation);
    }

    /**
     * Set the citation URL.
     *
     * @param string $url Source URL.
     * @return void
     */
    public function setCitation(string $url): void {
        $this->citation = $this->safeUrl($url);
    }

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<q'
            . ($this->citation ? ' cite="' . $this->citation . '"' : '')
            . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</q>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <dfn> HTML element (definition term).
 */
class Dfn extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<dfn' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</dfn>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <bdi> HTML element (bidirectional isolate).
 */
class Bdi extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<bdi' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</bdi>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <bdo> HTML element (bidirectional override).
 */
class Bdo extends Node {
    protected string $direction; // Text direction

    /**
     * Constructor for the Bdo element.
     *
     * @param string $direction Use text_direction constants.
     */
    public function __construct(string $direction = text_direction::LEFT) {
        $this->direction = $direction;
    }

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<bdo dir="' . $this->direction . '"'
            . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</bdo>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <wbr> HTML element (line break opportunity).
 */
class Wbr extends Node {
    public function __construct() {}

    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<wbr' . $this->getAttributes() . ' />';
    }
}

?>
