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
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<article'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</article>';
			
		return $_html;
	}
}

?>