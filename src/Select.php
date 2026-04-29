<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <select> HTML element.
 */
class Select extends Node {
	protected ?string $parent	= null;	// Form ID
	protected ?int $size		= null;	// Size attribute
	protected ?bool $required	= null;	// Required attribute
	protected ?bool $multiple	= null;	// Multiple attribute
	protected array $options	= [];	// Array of options
	
	/**
	 * Constructor for the Select element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Sets the parent form ID.
	 *
	 * @param string $formid The ID of the parent form.
	 * @return void
	 */
	public function setParent(string $formid): void {
		$this->parent = $formid;
	}
	
	/**
	 * Sets the size attribute.
	 *
	 * @param int $size The size attribute value.
	 * @return void
	 */
	public function setSize(int $size): void {
		$this->size = $size;
	}
	
	/**
	 * Enables the multiple attribute.
	 *
	 * @return void
	 */
	public function setMultiple(): void {
		$this->multiple = true;
	}
	
	/**
	 * Sets the required attribute.
	 *
	 * @return void
	 */
	public function setRequired(): void {
		$this->required = true;
	}
	
	/**
	 * Adds an option to the select element.
	 *
	 * @param Option $element The option element to add.
	 * @return void
	 */
	public function addOption(Option $element): void {
		$this->options[] = $element;
	}
	
	/**
	 * Retrieves the index of the selected option.
	 *
	 * @return int|null The index of the selected option.
	 */
	public function getSelected(): ?int {
		$result = null;
		
		foreach ($this->options as $index => $option)
			if ($option->isSelected()) $result = $index;
		
		return $result;
	}
	
	/**
	 * Retrieves the indices of all selected options.
	 *
	 * @return array List of indices of all selected options.
	 */
	public function getSelectedAll(): array {
		$result = [];
		
		foreach ($this->options as $index => $option)
			if ($option->isSelected()) $result[] = $index;
		
		return $result;
	}
	
	/**
	 * Generate the HTML representation of the <select> element.
	 *
	 * @return string The HTML representation of the <select> element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<select'
			. ($this->hasValue($this->parent)	? ' form="' . $this->parent . '"'	: '')
			. ($this->hasValue($this->required)	? ' required="required"'			: '')
			. ($this->hasValue($this->multiple)	? ' multiple="multiple"'			: '')
			. ($this->hasValue($this->size)		? ' size="' . $this->size . '"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>';
			
		foreach ($this->options as $_option) {
			$_option->setLevel($this->level + 1);
			$_html .= $_option->getHtml();
		}
		
		$_html .= special_chars::NEWLINE
			. $_indent . '</select>';
		
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents an <option> HTML element.
 */
class Option extends Node {
	protected ?string $value	= null;	// Value attribute
	protected ?string $text		= null;	// Text content
	protected ?bool $selected	= null;	// Selected attribute
	
	/**
	 * Constructor for the Option element.
	 *
	 * @param string $value The value attribute.
	 * @param string $text  The text content.
	 */
	public function __construct(string $value, string $text) {
		$this->value = $this->safeHtml($value);
		$this->text = $this->safeHtml($text);
	}
	
	/**
	 * Selects the option.
	 *
	 * @return void
	 */
	public function Select(): void {
		$this->selected = true;
	}
	
	/**
	 * Deselects the option.
	 *
	 * @return void
	 */
	public function Deselect(): void {
		$this->selected = false;
	}
	
	/**
	 * Checks if the option is selected.
	 *
	 * @return bool True if selected.
	 */
	public function isSelected(): bool {
		return $this->selected ?? false;
	}
	
	/**
	 * Generate the HTML representation of the <option> element.
	 *
	 * @return string The HTML representation of the <option> element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<option value="' . $this->value . '"'
			. ($this->hasValue($this->selected)	? ' selected="selected"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>' . $this->text . '</option>';
			
		return $_html;
	}
}

?>