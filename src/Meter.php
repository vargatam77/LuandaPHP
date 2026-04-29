<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <meter> HTML element for displaying a scalar value within a range.
 */
class Meter extends Node {
	protected int|float $value			= 0;	// Current value
	protected int|float|null $min		= null;	// Minimum value
	protected int|float|null $max		= null;	// Maximum value
	protected int|float|null $low		= null;	// Low threshold
	protected int|float|null $high		= null;	// High threshold
	protected int|float|null $optimum	= null;	// Optimum value

	/**
	 * Constructor for the Meter element.
	 *
	 * @param int|float $value The current value.
	 */
	public function __construct(int|float $value = 0) {
		$this->addContent(new Text('Your browser does not support the HTML5 meter tag.'));
		$this->value = $value;
	}
	
	/**
	 * Set the low and high thresholds.
	 *
	 * @param int|float $value Sets the current value.
	 * @return void
	 */
	public function setValue(int|float $value): void {
		$this->value = $value;
	}

	/**
	 * Set the low and high thresholds.
	 *
	 * @param int|float $low Minimum value.
	 * @param int|float $high Maximum value.
	 * @return void
	 */
	public function setThresholds(int|float $low, int|float $high): void {
		$this->low	= $low;
		$this->high	= $high;
	}

	/**
	 * Set the optimum value.
	 *
	 * @param int|float $optimum The optimal value.
	 * @return void
	 */
	public function setOptimum(int|float $optimum): void {
		$this->optimum = $optimum;
	}

	/**
	 * Generate the HTML representation of the <meter> element.
	 *
	 * @return string The HTML representation of the <meter> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);

		$_indent = str_repeat(indent_type::TAB, $this->level);

		$_html = special_chars::NEWLINE
			. $_indent . '<meter'
			. ' value="' . $this->value . '"'
			. ($this->hasValue($this->min)		? ' min="'		. $this->min		. '"' : '')
			. ($this->hasValue($this->max)		? ' max="'		. $this->max		. '"' : '')
			. ($this->hasValue($this->low)		? ' low="'		. $this->low		. '"' : '')
			. ($this->hasValue($this->high)		? ' high="'		. $this->high		. '"' : '')
			. ($this->hasValue($this->optimum)	? ' optimum="'	. $this->optimum	. '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</meter>';

		return $_html;
	}
}

?>