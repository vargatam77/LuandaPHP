<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an article HTML element.
 */
class Article extends Node {
	
	/**
	 * Constructor for the Article element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the article element.
	 *
	 * @return string The HTML representation of the article element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(self::$indentString, $this->level);
		
		$_html = self::$newlineString
			. $_indent . '<article'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. self::$newlineString
			. $_indent . '</article>';
			
		return $_html;
	}
}

?>