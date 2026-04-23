<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <table> HTML element.
 */
class Table extends Node {
    protected ?Caption $caption = null; // Optional table caption

    /**
     * Constructor for the Table element.
     *
     * @param string|null $captionText Optional caption text.
     */
    public function __construct(?string $captionText = null) {
        if ($captionText !== null) {
            $this->caption = new Caption($captionText);
        }
    }

    /**
     * Set a Caption element explicitly.
     *
     * @param Caption $caption The caption element.
     * @return void
     */
    public function setCaption(Caption $caption): void {
        $this->caption = $caption;
    }

    /**
     * Generate the HTML representation of the <table> element.
     *
     * @return string The HTML representation of the <table> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        if ($this->caption) {
            $this->caption->setLevel($this->level + 1);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<table'
            . $this->getAttributes()
            . '>'
            . ($this->caption ? $this->caption->getHtml() : '')
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</table>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <caption> HTML element.
 */
class Caption extends Node {
    protected string $text; // Caption text

    /**
     * Constructor for the Caption element.
     *
     * @param string $text The caption text.
     */
    public function __construct(string $text) {
        $this->text = $this->safeHtml($text);
    }

    /**
     * Generate the HTML representation of the <caption> element.
     *
     * @return string The HTML representation of the <caption> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<caption'
            . $this->getAttributes()
            . '>'
            . $this->text
            . ($this->content ? $this->content->getHtml() : '')
            . '</caption>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <thead> HTML element.
 */
class THead extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<thead' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</thead>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <tbody> HTML element.
 */
class TBody extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<tbody' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</tbody>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <tfoot> HTML element.
 */
class TFoot extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<tfoot' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</tfoot>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <tr> HTML element.
 */
class TRow extends Node {
    public function __construct() {}

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<tr' . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</tr>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <td> HTML element (table data cell).
 */
class TCell extends Node {
    protected ?int $colspan = null;  // Number of columns to span
    protected ?int $rowspan = null;  // Number of rows to span
    protected ?string $headers = null; // Space-separated list of header IDs

    /**
     * Constructor for the TCell element.
     */
    public function __construct() {}

    /**
     * Set the column span.
     *
     * @param int $span Number of columns to span.
     * @return void
     */
    public function setColspan(int $span): void {
        $this->colspan = $span;
    }

    /**
     * Set the row span.
     *
     * @param int $span Number of rows to span.
     * @return void
     */
    public function setRowspan(int $span): void {
        $this->rowspan = $span;
    }

    /**
     * Associate with header cells by their IDs.
     *
     * @param string $headerIds Space-separated header cell IDs.
     * @return void
     */
    public function setHeaders(string $headerIds): void {
        $this->headers = $headerIds;
    }

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<td'
            . ($this->colspan ? ' colspan="' . $this->colspan . '"' : '')
            . ($this->rowspan ? ' rowspan="' . $this->rowspan . '"' : '')
            . ($this->headers ? ' headers="' . $this->headers . '"' : '')
            . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</td>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <th> HTML element (table header cell).
 */
class THeader extends Node {
    protected ?int $colspan = null;     // Number of columns to span
    protected ?int $rowspan = null;     // Number of rows to span
    protected ?string $scope = null;    // Scope of the header
    protected ?string $abbr = null;     // Abbreviated label

    /**
     * Constructor for the THeader element.
     */
    public function __construct() {}

    /**
     * Set the column span.
     *
     * @param int $span Number of columns to span.
     * @return void
     */
    public function setColspan(int $span): void {
        $this->colspan = $span;
    }

    /**
     * Set the row span.
     *
     * @param int $span Number of rows to span.
     * @return void
     */
    public function setRowspan(int $span): void {
        $this->rowspan = $span;
    }

    /**
     * Set the scope of this header.
     *
     * @param string $scope Use th_scope constants.
     * @return void
     */
    public function setScope(string $scope): void {
        $this->scope = $scope;
    }

    /**
     * Set an abbreviated label for the header.
     *
     * @param string $abbr Short label text.
     * @return void
     */
    public function setAbbr(string $abbr): void {
        $this->abbr = $this->safeHtml($abbr);
    }

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<th'
            . ($this->colspan ? ' colspan="' . $this->colspan . '"' : '')
            . ($this->rowspan ? ' rowspan="' . $this->rowspan . '"' : '')
            . ($this->scope   ? ' scope="'   . $this->scope   . '"' : '')
            . ($this->abbr    ? ' abbr="'    . $this->abbr    . '"' : '')
            . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</th>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <colgroup> HTML element.
 */
class ColGroup extends Node {
    protected ?int $span = null; // Number of columns this group covers

    /**
     * Constructor for the ColGroup element.
     *
     * @param int|null $span Optional span count when no Col children are used.
     */
    public function __construct(?int $span = null) {
        $this->span = $span;
    }

    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<colgroup'
            . ($this->span ? ' span="' . $this->span . '"' : '')
            . $this->getAttributes() . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</colgroup>';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <col> HTML element.
 */
class Col extends Node {
    protected ?int $span = null; // Number of columns this element covers

    /**
     * Constructor for the Col element.
     *
     * @param int|null $span Optional number of columns to span.
     */
    public function __construct(?int $span = null) {
        $this->span = $span;
    }

    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        return "\n" . $space . '<col'
            . ($this->span ? ' span="' . $this->span . '"' : '')
            . $this->getAttributes()
            . ' />';
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for table header scope values.
 */
class th_scope {
    public const ROW      = 'row';
    public const COL      = 'col';
    public const ROWGROUP = 'rowgroup';
    public const COLGROUP = 'colgroup';
    public const AUTO     = 'auto';
}

?>
