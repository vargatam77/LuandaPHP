<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <nav> HTML element.
 */
class Nav extends Node {
	
	/**
	 * Constructor for the Nav element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate HTML representation of the nav element.
	 *
	 * @return string The HTML representation of the nav element
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<nav'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</nav>';
			
		return $_html;
	}
}

?>