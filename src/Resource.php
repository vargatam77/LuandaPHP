<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <link> tag for stylesheets or icons in the head section.
 */
class Resource extends Node {
	protected ?string $rel		= null;	// Relationship attribute of the link
	protected ?string $href		= null;	// Href attribute of the link
	protected ?string $type		= null; // Image format
	protected ?Media $media		= null;	// Media query object for the link
	
	/**
	 * Constructor for the Resource element.
	 *
	 * @param string $rel			The relationship attribute value
	 * @param string $url			The href attribute value
	 * @param string|null $type		The image format
	 * @param string|null $media	The media type or query string
	 */
	public function __construct(string $rel, string $url, ?string $type = null, ?string $media = null) {
		$this->rel = $this->safeHtml($rel);
		$this->href = $this->safeUrl($url);
		$this->type = $type;
		if ($this->hasValue($media)) $this->media = new Media($media);
	}
		
	/**
	* Sets the image format of the link/icon.
	*
	* @param string $type The image format
	* @return void
	*/
	public function setType(string $type): void {
		$this->type = $type;
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
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<link'
			. ($this->hasValue($this->rel)		? ' rel="' . $this->rel . '"'					: '')
			. ($this->hasValue($this->href)		? ' href="' . $this->href . '"'					: '')
			. ($this->hasValue($this->type)		? ' href="' . $this->type . '"'					: '')
			. ($this->hasValue($this->media)	? ' media="' . $this->media->getMedia() . '"'	: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ' />';
			
		return $_html;
	}
}

?>