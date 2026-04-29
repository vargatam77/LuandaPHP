<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <section> HTML element.
 */
class Section extends Node {
	
	/**
	 * Constructor for the Section element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <section> element.
	 *
	 * @return string The HTML representation of the <section> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<section'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</section>';
			
		return $_html;
	}
}

?>