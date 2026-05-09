<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <cite> element.
 */
class Cite extends Node {
	
	/**
	 * Constructor for the cite element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the cite element.
	 *
	 * @return string The HTML representation of the cite element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<cite'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</cite>';
			
		return $_html;
	}
}

?>