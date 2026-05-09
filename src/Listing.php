<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a list HTML element (ul, ol, or dl).
 */
class Listing extends Node {
	protected string $listStyle = list_style::UNORDERED;	// Style of the list
	
	/**
	 * Constructor for the Listing element.
	 *
	 * @param string $liststyle Style from list_style helper
	 */
	public function __construct(string $liststyle) {
		$this->listStyle = $liststyle;
	}
	
	/**
	 * Generate HTML representation of the list element.
	 *
	 * @return string The HTML representation of the list
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(self::$indentString, $this->level);
		
		$_html = self::$newlineString
			. $_indent . '<' . $this->listStyle
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. self::$newlineString
			. $_indent . '</' . $this->listStyle
			. '>';
		
		return $_html;
	}
}

?>