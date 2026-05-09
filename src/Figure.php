<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <figure> HTML element.
 */
class Figure extends Node {
	
	/**
	 * Constructor for the Figure element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <figure> element.
	 *
	 * @return string The HTML representation of the <figure> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<figure'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</figure>';
			
		return $_html;
	}
}

?>
