<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an address HTML element.
 */
class Address extends Node {
	
	/**
	 * Constructor for the Address element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the address element.
	 *
	 * @return string The HTML representation of the address element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(self::$indentString, $this->level);
		
		$_html = self::$newlineString
			. $_indent . '<address'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. self::$newlineString
			. $_indent . '</address>';
				
		return $_html;
	}
}

?>