<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a button HTML element.
 */
class Button extends Node {
	protected ?string $type			= null;
	protected ?string $parent		= null;
	protected ?string $value		= null;
	
	/**
	 * Constructor for the button element.
	 *
	 * @param string $type The type of the button, use button_type:: constants.
	 */
	public function __construct(string $type = form_button_type::BTN) {
		$this->type = $type;
	}
	
	/**
	 * Sets the value attribute of the button.
	 *
	 * @param string $value The value to set.
	 * @return void
	 */
	public function setValue(string $value): void {
		$this->value = $value;
	}
	
	/**
	 * Set the parent form ID for the button.
	 *
	 * @param string $formId The ID of the parent form.
	 * @return void
	 */
	public function setParent(string $formId): void {
		$this->parent = $formId;
	}
	
	/**
	 * Generate the HTML representation of the button element.
	 *
	 * @return string The HTML representation of the button element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<button'
			. ($this->hasValue($this->type)		? ' type="' . $this->type . '"'		: '')
			. ($this->hasValue($this->value)	? ' value="' . $this->value . '"'	: '')
			. ($this->hasValue($this->parent)	? ' form="' . $this->parent . '"'	: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</button>';
			
		return $_html;
	}
}

?>