<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a label HTML element.
 */
class Label extends Node {
	protected ?string $input	= null;		// Associated input element ID
	protected ?string $parent	= null;		// Parent form ID for the label
	
	/**
	 * Constructor for the label element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Set the associated input element ID for the label.
	 *
	 * @param string $inputid ID of the associated input element
	 * @return void
	 */
	public function setInput(string $inputid): void {
		$this->input = $inputid;
	}
	
	/**
	 * Set the parent form ID for the label.
	 *
	 * @param string $formid Parent form ID for the label
	 * @return void
	 */
	public function setParent(string $formid): void {
		$this->parent = $formid;
	}
	
	/**
	 * Generate HTML representation of the label element.
	 *
	 * @return string The HTML representation of the label
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
		. $_indent . '<label'
			. ($this->hasValue($this->parent)	? ' form="' . $this->parent . '"'	: '')
			. ($this->hasValue($this->input)	? ' for="' . $this->input . '"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</label>';
			
		return $_html;
	}
}

?>