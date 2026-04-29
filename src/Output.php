<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <output> element.
 */
class Output extends Node {
	public string|int|float|null $value	= null;	// Current value of the output
	protected ?string $input			= null;	// Associated input element ID
	protected ?string $parent			= null;	// Parent form ID
	
	/**
	 * Constructor for the Output element.
	 *
	 * @param string|null $id    The ID of the element
	 * @param string|int|float|null $value Initial value
	 */
	public function __construct(?string $id = null, string|int|float|null $value = null) {
		if ($this->hasValue($id)) $this->setId($id);
		if ($this->hasValue($value)) $this->setValue($value);
	}
	
	/**
	 * Set the value of the output with safe HTML encoding.
	 *
	 * @param string|int|float $value Value of the output
	 * @return void
	 */
	public function setValue(string|int|float $value): void {
		$this->value = $this->safeHtml((string)$value);
	}
	
	/**
	 * Set the associated input element ID for the output.
	 *
	 * @param string $inputid ID of the associated input element
	 * @return void
	 */
	public function setInput(string $inputid): void {
		$this->input = $inputid;
	}
	
	/**
	 * Set the parent form ID for the output.
	 *
	 * @param string $formid Parent form ID
	 * @return void
	 */
	public function setParent(string $formid): void {
		$this->parent = $formid;
	}
	
	/**
	 * Generate the HTML representation of the output element.
	 *
	 * @return string The HTML representation of the output element
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<output'
			. ($this->hasValue($this->parent)	? ' form="' . $this->parent . '"'	: '')
			. ($this->hasValue($this->input)	? ' for="' . $this->input . '"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. ($this->hasValue($this->value)	? (string)$this->value				: '')
			. '</output>';
			
		return $_html;
	}
}

?>