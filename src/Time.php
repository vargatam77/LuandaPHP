<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <time> HTML element.
 */
class Time extends Node {
	protected ?string $datetime = null;	// Machine-readable date/time value
	
	/**
	 * Constructor for the Time element.
	 *
	 * @param string|null $datetime Optional machine-readable datetime string.
	 */
	public function __construct(?string $datetime = null) {
		if ($this->hasValue($datetime))
			$this->datetime = $this->safeHtml($datetime);
	}
	
	/**
	 * Set the machine-readable datetime value.
	 *
	 * @param string $datetime Valid datetime string (e.g. '2025-03-17' or '14:30').
	 * @return void
	 */
	public function setDatetime(string $datetime): void {
		$this->datetime = $this->safeHtml($datetime);
	}
	
	/**
	 * Generate the HTML representation of the <time> element.
	 *
	 * @return string The HTML representation of the <time> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<time'
			. ($this->hasValue($this->datetime)	? ' datetime="' . $this->datetime . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. '</time>';
			
		return $_html;
	}
}

?>
