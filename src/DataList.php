<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <datalist> element.
 */
class DataList extends Node {
	
	/**
	 * Constructor for the DataList element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate HTML representation of the datalist element.
	 *
	 * @return string The HTML representation of the datalist.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<datalist'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</datalist>';
			
		return $_html;
	}
}

?>