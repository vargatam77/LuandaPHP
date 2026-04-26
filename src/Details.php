<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <details> HTML element. TODO create template
 */
class Details extends Node {
	protected bool $open = false;
	protected ?Summary $summary = null;
	
	/**
	 * Constructor for the Details element.
	 *
	 * @param string|null $summaryText Optional visible label text.
	 */
	public function __construct(Summary $summary) {
		$this->summary = $summary;
	}
	
	/**
	 * Expand the details block by default.
	 *
	 * @return void
	 */
	public function Expand(): void {
		$this->open = true;
	}
	
	/**
	 * Set a Summary element explicitly.
	 *
	 * @param Summary $summary The summary element.
	 * @return void
	 */
	public function setSummary(Summary $summary): void {
		$this->summary = $summary;
	}
	
	/**
	 * Generate the HTML representation of the <details> element.
	 *
	 * @return string The HTML representation of the <details> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		$this->summary?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<details'
			. ($this->open ? ' open="open"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->summary?->getHtml()
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</details>';
			
		return $_html;
	}
}

?>
