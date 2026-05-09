<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <footer> HTML element.
 */
class Footer extends Node {
	
	/**
	 * Constructor for the Footer element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <footer> element.
	 *
	 * @return string The HTML representation of the <footer> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(self::$indentString, $this->level);
		
		$_html = self::$newlineString
			. $_indent . '<footer'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. self::$newlineString
			. $_indent . '</footer>';
		
		return $_html;
	}
}

?>