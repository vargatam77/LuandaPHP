<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a line break (<br>) HTML element.
 * Void element — takes no children. no classes, attributes or events
 */
class Br extends Node {
	
	/**
	 * Constructor method for the br class.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the br element.
	 *
	 * @return string The HTML representation of the br element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<br'
			//. $this->getClasses()		//unused
			//. $this->getAttributes()	//unused
			//. $this->getEvents()		//unused
			. ' />';
			
		return $_html;
	}
}

?>