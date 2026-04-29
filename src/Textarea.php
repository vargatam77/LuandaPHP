<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <textarea> HTML element.
 */
class Textarea extends Node {
	protected ?string $parent		= null;	// Form ID attribute TODO consistent bool parsing in every file
	protected ?string $value		= null;	// Initial value TODO remove hasvalue checks for every file where nullable
	protected ?bool $readOnly		= null;	// Readonly flag
	protected ?bool $required		= null;	// Required flag
	protected ?int $minLen			= null;	// Minimum length attribute
	protected ?int $maxLen			= null;	// Maximum length attribute
	protected ?int $rows			= null;	// Rows attribute
	protected ?int $cols			= null;	// Columns attribute
	protected ?string $placeHolder	= null;	// Placeholder attribute
	protected ?string $wrapMode		= null;	// Wrap mode attribute
	
	/**
	 * Constructor for the Textarea element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Sets the parent form ID attribute.
	 *
	 * @param string $formid The ID of the parent form.
	 * @return void
	 */
	public function setParent(string $formid): void {
		$this->parent = $formid;
	}
	
	/**
	 * Sets the initial value of the textarea.
	 *
	 * @param string $value The initial text content.
	 * @return void
	 */
	public function setValue(string $value): void {
		$this->value = $this->safeHtml($value);
	}
	
	/**
	 * Sets the readonly attribute.
	 *
	 * @return void
	 */
	public function toReadonly(): void {
		$this->readOnly = true;
	}
	
	/**
	 * Sets the required attribute.
	 *
	 * @return void
	 */
	public function toRequired(): void {
		$this->required = true;
	}
	
	/**
	 * Sets the size of the textarea.
	 *
	 * @param int $cols The number of columns.
	 * @param int $rows The number of rows.
	 * @return void
	 */
	public function setSize(int $cols, int $rows): void {
		$this->cols = $cols;
		$this->rows = $rows;
	}
	
	/**
	 * Sets the minimum and maximum length attributes.
	 *
	 * @param int|null $minlen The minimum length.
	 * @param int|null $maxlen The maximum length.
	 * @return void
	 */
	public function setMinMaxLen(?int $minlen = null, ?int $maxlen = null): void {
		$this->minLen = $minlen;
		$this->maxLen = $maxlen;
	}
	
	/**
	 * Sets the placeholder attribute.
	 *
	 * @param string $placeholder The placeholder text.
	 * @return void
	 */
	public function setPlaceholder(string $placeholder): void {
		$this->placeHolder = $this->safeHtml($placeholder);
	}
	
	/**
	* Sets the wrap mode attribute.
	*
	* @param string $wrap Use textarea_wrapmode constants.
	* @return void
	*/
	public function setWrap(string $wrapmode): void {
		$this->wrapMode = $wrapmode;
	}
	
	/**
	 * Generate the HTML representation of the <textarea> element.
	 *
	 * @return string The HTML representation of the <textarea> element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<textarea'
			. ($this->hasValue($this->parent)		? ' form="' . $this->parent . '"'				: '')
			. ($this->hasValue($this->readOnly)		? ' readonly="readonly"'						: '')
			. ($this->hasValue($this->required)		? ' required="required"'						: '')
			. ($this->hasValue($this->minLen)		? ' minlength="' . $this->minLen . '"'			: '')
			. ($this->hasValue($this->maxLen)		? ' maxlength="' . $this->maxLen . '"'			: '')
			. ($this->hasValue($this->rows)			? ' rows="' . $this->rows . '"'					: '')
			. ($this->hasValue($this->cols)			? ' cols="' . $this->cols . '"'					: '')
			. ($this->hasValue($this->placeHolder)	? ' placeholder="' . $this->placeHolder . '"'	: '')
			. ($this->hasValue($this->wrapMode)		? ' wrap="' . $this->wrap. '"'					: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. ($this->hasValue($this->value) ? $this->value : '')
			. '</textarea>';
			
		return $_html;
	}
}

?>