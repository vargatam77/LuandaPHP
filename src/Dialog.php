<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <dialog> HTML element.
 * A native HTML modal/popup element. Can be shown without JavaScript.
 * Supports a native backdrop and can contain any block-level content.
 */
class Dialog extends Node {
	protected bool $open = false;
	
	/**
	 * Constructor for the Dialog element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Show the dialog open by default.
	 *
	 * @return void
	 */
	public function Open(): void {
		$this->open = true;
	}
	
	/**
	 * Generate the HTML representation of the <dialog> element.
	 *
	 * @return string The HTML representation of the <dialog> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
		. $_indent . '<dialog'
			. ($this->open ? ' open="open"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</dialog>';
			
		return $_html;
	}
}

?>
