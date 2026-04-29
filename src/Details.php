<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <details> HTML element. TODO create template
 */
class Details extends Node {
	protected bool $open = false;
	
	/**
	 * Constructor for the Details element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Expand the details block by default.
	 *
	 * @return void
	 */
	public function Expand(): void {
		$this->open = true;
	}
	
	/**
	 * Generate the HTML representation of the <details> element.
	 *
	 * @return string The HTML representation of the <details> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<details'
			. ($this->open ? ' open="open"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</details>';
			
		return $_html;
	}
}

?>
