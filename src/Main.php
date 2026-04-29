<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a main HTML element.
 */
class Main extends Node {
	
	/**
	 * Constructor for the Main element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate HTML representation of the main element.
	 *
	 * @return string The HTML representation of the main element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<main'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</main>';
			
		return $_html;
	}
}

?>