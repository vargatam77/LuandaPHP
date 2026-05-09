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
		
		$_indent = str_repeat(self::$indentString, $this->level);
		
		$_html = self::$newlineString
			. $_indent . '<figure'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. self::$newlineString
			. $_indent . '</figure>';
			
		return $_html;
	}
}

?>
