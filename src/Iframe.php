<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML iframe element.
 */
class Iframe extends Node {
	protected ?string $src = null; // URL of the content to embed
	
	/**
	 * Constructor for the iframe element.
	 *
	 * @param string $src URL of the content to embed
	 */
	public function __construct(?string $url = null) {
		if ($this->hasValue($url))
			$this->setUrl($url);
	}
	
	/**
	 * Set the URL of the content to embed.
	 *
	 * @param string $src URL of the content to embed.
	 * @return void
	 */
	public function setUrl(string $url): void {
		$this->src = $this->safeUrl($url);
	}
	
	/**
	 * Generate HTML representation of the iframe element.
	 *
	 * @return string The HTML representation of the iframe element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<iframe'
			. ($this->hasValue($this->src) ? ' src="' . $this->src . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</iframe>';
			
		return $_html;
	}
}

?>