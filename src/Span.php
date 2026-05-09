<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <span> HTML element.
 */
class Span extends Node {
	
	/**
	 * Constructor for the Span element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <span> element.
	 *
	 * @return string The HTML representation of the <span> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(self::$indentString, $this->level);
		
		$_html = self::$newlineString
			. $_indent . '<span'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. self::$newlineString
			. $_indent . '</span>';
			
		return $_html;
	}
}

?>