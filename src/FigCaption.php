<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <figcaption> HTML element.
 */
class FigCaption extends Node {
	
	/**
	 * Constructor for the FigCaption element.
	 *
	 * @param string $text The caption text.
	 */
	public function __construct() {
	
	}
	
	/**
	 * Generate the HTML representation of the <figcaption> element.
	 *
	 * @return string The HTML representation of the <figcaption> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<figcaption'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</figcaption>';
			
		return $_html;
	}
}

?>