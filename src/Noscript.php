<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <noscript> HTML element.
 */
class Noscript extends Node {
	
	/**
	 * Constructor for the Noscript element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate HTML representation of the noscript element.
	 *
	 * @return string The HTML representation of the noscript element
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<noscript'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</noscript>';
			
		return $_html;
	}
}

?>