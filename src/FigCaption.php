<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <figcaption> HTML element.
 */
class FigCaption extends Node {
	
	/**
	 * Constructor for the FigCaption element.
	 *
	 * @param string $text The caption text.
	 */
	public function __construct() {
	
	}
	
	/**
	 * Generate the HTML representation of the <figcaption> element.
	 *
	 * @return string The HTML representation of the <figcaption> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
		. $_indent . '<figcaption'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</figcaption>';
			
		return $_html;
	}
}

?>