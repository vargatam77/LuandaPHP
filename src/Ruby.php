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
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
		. $_indent . '<ruby'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</ruby>';
			
		return $_html;
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
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
		. $_indent . '<rt'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</rt>';
			
		return $_html;
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
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<rp'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</rp>';
			
		return $_html;
	}
}

?>
