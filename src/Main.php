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
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<main'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</main>';
			
		return $_html;
	}
}

?>