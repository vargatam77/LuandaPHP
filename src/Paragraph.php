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
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<p'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</p>';
			
		return $_html;
	}
}

?>