<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Class Anchor
 *
 * Represents a hyperlink (<a>) element with various attributes.
 */
class Anchor extends Node {
	protected ?string $url = null;    // URL attribute
	protected ?string $target = null; // Target attribute
	protected ?string $rel = null;    // Relationship attribute
	protected ?string $type = null;   // Type attribute
	
	/**
	 * Constructor for the Anchor element.
	 *
	 * @param string|null $url Optional URL
	 */
	public function __construct(?string $url = null) {
		if ($url) $this->setUrl($url);
	}
	
	/**
	 * Sets the href URL of the hyperlink.
	 *
	 * @param string $url The URL to set.
	 * @return void
	 */
	public function setUrl(string $url): void {
		$this->url = $this->safeUrl($url);
	}
	
	/**
	 * Sets the target attribute of the hyperlink.
	 *
	 * @param string $target The target attribute value.
	 * @return void
	 */
	public function setTarget(string $target): void {
		$this->target = $target;
	}
	
	/**
	 * Sets the rel (relationship) attribute of the hyperlink.
	 *
	 * @param string $rel The rel attribute value.
	 * @return void
	 */
	public function setRelation(string $rel): void {
		$this->rel = $rel;
	}
	
	/**
	 * Sets the type attribute of the hyperlink.
	 *
	 * @param string $type The type attribute value.
	 * @return void
	 */
	public function setType(string $type): void {
		$this->type = $type;
	}
	
	/**
	 * Generates the HTML representation of the hyperlink.
	 *
	 * @return string The HTML representation of the hyperlink.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<a'
			. ($this->hasValue($this->url) ? ' href="' . $this->url . '"' : '')
			. ($this->hasValue($this->target) ? ' target="' . $this->target . '"' : '')
			. ($this->hasValue($this->type) ? ' type="' . $this->type . '"' : '')
			. ($this->hasValue($this->rel) ? ' rel="' . $this->rel . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</a>';
			
		return $_html;
	}
}

?>