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
		
		$_indent = str_repeat(self::$indentString, $this->level);
		
		$_html = self::$newlineString
			. $_indent . '<legend'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. self::$newlineString
			. $_indent . '</legend>';
			
		return $_html;
	}
}

?>