<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an aside HTML element.
 */
class Aside extends Node {
	
	/**
	 * Constructor for the Aside element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the aside element.
	 *
	 * @return string The HTML representation of the aside element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<aside'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</aside>';
			
		return $_html;
	}
}

?>