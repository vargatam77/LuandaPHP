<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <template> HTML element.
 * Content inside is inert and not rendered until activated by JavaScript.
 */
class Template extends Node {
	
	/**
	 * Constructor for the Template element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <template> element.
	 *
	 * @return string The HTML representation of the <template> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<template'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</template>';
			
		return $_html;
	}
}

?>