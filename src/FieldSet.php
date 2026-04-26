<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <fieldset> HTML element.
 */
class FieldSet extends Node {
	protected ?string $parent = null;
	protected ?Legend $legend = null;
	
	/**
	 * Constructor for the FieldSet element.
	 *
	 * @param Legend $legend The legend element.
	 */
	public function __construct(Legend $legend) {
		$this->legend = $legend;
	}
	
	/**
	 * Associate this fieldset with a form by its ID.
	 *
	 * @param string $formId The ID of the parent form.
	 * @return void
	 */
	public function setParent(string $formId): void {
		$this->parent = $formId;
	}
	
	/**
	 * Set a Legend element explicitly.
	 *
	 * @param Legend $legend The legend element.
	 * @return void
	 */
	public function setLegend(Legend $legend): void {
		$this->legend = $legend;
	}
	
	/**
	 * Generate the HTML representation of the <fieldset> element.
	 * Note: Disable() maps to the HTML disabled attribute here, not inert,
	 * which disables all form elements inside the fieldset.
	 *
	 * @return string The HTML representation of the <fieldset> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		$this->legend?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<fieldset'
			. ($this->hasValue($this->parent) ? ' form="' . $this->parent . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->legend?->getHtml()
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</fieldset>';
			
		return $_html;
	}
}

?>