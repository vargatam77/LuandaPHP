<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <link> tag for stylesheets or icons in the head section.
 */
class Resource extends Node {
	protected ?string $rel		= null;	// Relationship attribute of the link
	protected ?string $href		= null;	// Href attribute of the link
	protected ?Media $media		= null;	// Media query object for the link
	
	/**
	 * Constructor for the Resource element.
	 *
	 * @param string $rel       The relationship attribute value
	 * @param string $href      The href attribute value
	 * @param string|null $media The media type or query string
	 */
	public function __construct(string $rel, string $href, ?string $media = null) {
		$this->rel = $this->safeHtml($rel);
		$this->href = $this->safeUrl($href);
		if ($this->hasValue($media)) $this->media = new Media($media);
	}
	
	/**
	 * Sets the media attribute of the link.
	 *
	 * @param string $media The media type or query string
	 * @return void
	 */
	public function setMedia(string $media): void {
		$this->media = new Media($media);
	}
	
	/**
	 * Generates the HTML representation of the link tag.
	 *
	 * @return string The HTML representation of the link tag
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<link'
			. ($this->hasValue($this->rel)		? ' rel="' . $this->rel . '"'					: '')
			. ($this->hasValue($this->href)		? ' href="' . $this->href . '"'					: '')
			. ($this->hasValue($this->media)	? ' media="' . $this->media->getMedia() . '"'	: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ' />';
			
		return $_html;
	}
}

?>