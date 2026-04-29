<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <progress> HTML element.
 */
class Progress extends Node {
	protected int|float|null $value		= null;	// Current progress value
	protected int|float|null $max		= null;	// Maximum value
	
	/**
	 * Constructor for the Progress element.
	 *
	 * @param int|float|null $value Current progress value. Omit for indeterminate.
	 * @param int|float|null $max   Maximum value (default 1.0 in browser).
	 */
	public function __construct(int|float|null $value = null, int|float|null $max = null) {
		$this->addContent(new Text('Your browser does not support the HTML5 progress tag.'));
		if ($this->hasValue($value)) $this->value = $value;
		if ($this->hasValue($max)) $this->max = $max;
	}
	
	/**
	 * Generate the HTML representation of the <progress> element.
	 *
	 * @return string The HTML representation of the <progress> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<progress'
			. ($this->hasValue($this->value)	? ' value="' . $this->value	. '"'	: '')
			. ($this->hasValue($this->max)		? ' max="' . $this->max	. '"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. '</progress>';
			
		return $_html;
	}
}

?>