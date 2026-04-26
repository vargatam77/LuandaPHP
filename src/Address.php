<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an address HTML element.
 */
class Address extends Node {
	
	/**
	 * Constructor for the Address element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the address element.
	 *
	 * @return string The HTML representation of the address element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<address'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</address>';
				
		return $_html;
	}
}

?>