<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an <option> HTML element.
 */
class SelectOption extends Node {
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
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
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