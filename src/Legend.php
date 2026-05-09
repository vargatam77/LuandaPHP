<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <legend> HTML element.
 */
class Legend extends Node {
	
	/**
	 * Constructor for the Legend element.
	 */
	public function __construct() {

	}
	
	/**
	 * Generate the HTML representation of the <legend> element.
	 *
	 * @return string The HTML representation of the <legend> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<legend'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</legend>';
			
		return $_html;
	}
}

?>