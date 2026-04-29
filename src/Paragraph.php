<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <p> HTML element.
 */
class Paragraph extends Node {
	
	/**
	 * Constructor for the Paragraph element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate HTML representation of the paragraph element.
	 *
	 * @return string The HTML representation of the paragraph element
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<p'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</p>';
			
		return $_html;
	}
}

?>