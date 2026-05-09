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
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<datalist'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</datalist>';
			
		return $_html;
	}
}

?>