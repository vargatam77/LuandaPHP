<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <table> HTML element.
 */
class Table extends Node {
	protected ?Caption $caption = null;	// Optional table caption
	
	/**
	 * Constructor for the Table element.
	 *
	 * @param string|null $captiontext Optional caption text.
	 */
	public function __construct(?string $captiontext = null) {
		if ($captiontext !== null)
			$this->caption = new Caption($captiontext);
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
		$this->content?->setLevel($this->level);
		$this->caption?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<table'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->caption?->getHtml()
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</table>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <caption> HTML element.
 */
class Caption extends Node {
	protected ?string $text = null;	// Caption text
	
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
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<caption'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->text
			. $this->content?->getHtml()
			. '</caption>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <thead> HTML element.
 */
class THead extends Node {
	
	/**
	 * Constructor for the THead element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <thead> element.
	 *
	 * @return string The HTML representation of the <thead> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<thead'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</thead>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <tbody> HTML element.
 */
class TBody extends Node {
	
	/**
	 * Constructor for the TBody element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <tbody> element.
	 *
	 * @return string The HTML representation of the <tbody> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<tbody'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</tbody>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <tfoot> HTML element.
 */
class TFoot extends Node {
	
	/**
	 * Constructor for the TFoot element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <tfoot> element.
	 *
	 * @return string The HTML representation of the <tfoot> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<tfoot'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</tfoot>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <tr> HTML element.
 */
class TRow extends Node {
	
	/**
	 * Constructor for the TRow element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <tr> element.
	 *
	 * @return string The HTML representation of the <tr> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<tr'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</tr>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <td> HTML element (table data cell).
 */
class TCell extends Node {
	protected ?int $colspan		= null;	// Number of columns to span
	protected ?int $rowspan		= null;	// Number of rows to span
	protected ?string $headers	= null;	// Space-separated list of header IDs
	
	/**
	 * Constructor for the TCell element.
	 */
	public function __construct() {
		
	}
	
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
	 * @param string $headerids Space-separated header cell IDs.
	 * @return void
	 */
	public function setHeaders(string $headerids): void {
		$this->headers = $headerids;
	}
	
	/**
	 * Generate the HTML representation of the <td> element.
	 *
	 * @return string The HTML representation of the <td> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<td'
			. ($this->hasValue($this->colspan)	? ' colspan="' . $this->colspan . '"'	: '')
			. ($this->hasValue($this->rowspan)	? ' rowspan="' . $this->rowspan . '"'	: '')
			. ($this->hasValue($this->headers)	? ' headers="' . $this->headers . '"'	: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. '</td>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <th> HTML element (table header cell).
 */
class THeader extends Node {
	protected ?int $colspan		= null;	// Number of columns to span
	protected ?int $rowspan		= null;	// Number of rows to span
	protected ?string $scope	= null;	// Scope of the header
	protected ?string $abbr		= null;	// Abbreviated label
	
	/**
	 * Constructor for the THeader element.
	 */
	public function __construct() {
		
	}
	
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
	
	/**
	 * Generate the HTML representation of the <th> element.
	 *
	 * @return string The HTML representation of the <th> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<th'
			. ($this->hasValue($this->colspan)	? ' colspan="' . $this->colspan . '"'	: '')
			. ($this->hasValue($this->rowspan)	? ' rowspan="' . $this->rowspan . '"'	: '')
			. ($this->hasValue($this->scope)	? ' scope="' . $this->scope . '"'		: '')
			. ($this->hasValue($this->abbr)		? ' abbr="' . $this->abbr . '"'			: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. '</th>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <colgroup> HTML element.
 */
class ColGroup extends Node {
	protected ?int $span = null;	// Number of columns this group covers
	
	/**
	 * Constructor for the ColGroup element.
	 *
	 * @param int|null $span Optional span count when no Col children are used.
	 */
	public function __construct(?int $span = null) {
		$this->span = $span;
	}
	
	/**
	 * Generate the HTML representation of the <colgroup> element.
	 *
	 * @return string The HTML representation of the <colgroup> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<colgroup'
			. ($this->hasValue($this->span)	? ' span="' . $this->span . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</colgroup>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <col> HTML element.
 */
class Col extends Node {
	protected ?int $span = null;	// Number of columns this element covers
	
	/**
	 * Constructor for the Col element.
	 *
	 * @param int|null $span Optional number of columns to span.
	 */
	public function __construct(?int $span = null) {
		$this->span = $span;
	}
	
	/**
	 * Generate the HTML representation of the <col> element.
	 *
	 * @return string The HTML representation of the <col> element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<col'
			. ($this->hasValue($this->span)	? ' span="' . $this->span . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ' />';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for table header scope values.
 */
class th_scope {
	public const ROW		= 'row';
	public const COL		= 'col';
	public const ROWGROUP	= 'rowgroup';
	public const COLGROUP	= 'colgroup';
	public const AUTO		= 'auto';
}

?>