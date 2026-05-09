<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <header> HTML element.
 */
class Header extends Node {
	
	/**
	 * Constructor for the Header element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <header> element.
	 *
	 * @return string The HTML representation of the <header> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<header'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</header>';
			
		return $_html;
	}
}

?>