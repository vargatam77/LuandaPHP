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
		
		$_indent = str_repeat(self::$indentString, $this->level);
		
		$_html = self::$newlineString
			. $_indent . '<datalist'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. self::$newlineString
			. $_indent . '</datalist>';
			
		return $_html;
	}
}

?>