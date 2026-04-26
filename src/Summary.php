<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <summary> HTML element.
 */
class Summary extends Node {
	
	/**
	 * Constructor for the Summary element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <summary> element.
	 *
	 * @return string The HTML representation of the <summary> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<summary'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</summary>';
			
		return $_html;
	}
}

?>