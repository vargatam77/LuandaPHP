<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML horizontal rule (HR) element.
 * Void element — takes no children.
 */
class Hr extends Node {
	
	/**
	 * Constructor for the Hr element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the hr element.
	 *
	 * @return string The HTML representation of the hr element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<hr'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ' />';
			
		return $_html;
	}
}
?>