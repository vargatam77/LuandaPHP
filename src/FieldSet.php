<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <fieldset> HTML element.
 */
class FieldSet extends Node {
	protected ?string $parent = null;
	
	/**
	 * Constructor for the FieldSet element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Associate this fieldset with a form by its ID.
	 *
	 * @param string $formid The ID of the parent form.
	 * @return void
	 */
	public function setParent(string $formid): void {
		$this->parent = $formid;
	}
	
	/**
	 * Generate the HTML representation of the <fieldset> element.
	 * Note: Disable() maps to the HTML disabled attribute here, not inert,
	 * which disables all form elements inside the fieldset.
	 *
	 * @return string The HTML representation of the <fieldset> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<fieldset'
			. ($this->hasValue($this->parent) ? ' form="' . $this->parent . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</fieldset>';
			
		return $_html;
	}
}

?>