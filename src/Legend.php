<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <legend> HTML element.
 */
class Legend extends Node {
	
	/**
	 * Constructor for the Legend element.
	 */
	public function __construct() {

	}
	
	/**
	 * Generate the HTML representation of the <legend> element.
	 *
	 * @return string The HTML representation of the <legend> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<legend'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</legend>';
			
		return $_html;
	}
}

?>