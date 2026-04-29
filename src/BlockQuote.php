<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <blockquote> element.
 */
class BlockQuote extends Node {
	protected ?string $citeUrl = null; // URL for the source of the quote
	
	/**
	 * Constructor for the blockquote.
	 *
	 * @param string|null $citeUrl Optional URL source.
	 */
	public function __construct(?string $citeUrl = null) {
		if ($this->hasValue($citeUrl))
			$this->setCiteUrl($citeUrl);
	}
	
	/**
	 * Sets the cite URL for the blockquote source.
	 *
	 * @param string $citeUrl The URL of the quote source.
	 * @return void
	 */
	public function setCiteUrl(string $citeUrl): void {
		$this->citeUrl = $this->safeUrl($citeUrl);
	}
	
	/**
	 * Generate the HTML representation of the blockquote element.
	 *
	 * @return string The HTML representation of the blockquote element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<blockquote'
			. ($this->hasValue($this->citeUrl) ? ' cite="' . $this->citeUrl . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</blockquote>';
			
		return $_html;
	}
}

?>