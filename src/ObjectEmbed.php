<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an <object> HTML element for embedding external resources.
 */
class ObjectEmbed extends Node {
	protected ?string $data				= null;	// URL of the resource
	protected ?string $mediaType		= null;	// MIME type of the resource
	protected ?int $width				= null;	// Width in pixels
	protected ?int $height				= null;	// Height in pixels
	
	/**
	 * Constructor for the ObjectEmbed element.
	 *
	 * @param string $url The URL of the resource to embed.
	 */
	public function __construct(string $url) {
		$this->data = $this->safeUrl($url);
	}
	
	/**
	 * Set the MIME type of the embedded resource.
	 *
	 * @param string $mediatype MIME type string.
	 * @return void
	 */
	public function setMediaType(string $mediatype): void {
		$this->mediaType = $mediatype;
	}
	
	/**
	 * Set the display dimensions.
	 *
	 * @param int $width  Width in pixels.
	 * @param int $height Height in pixels.
	 * @return void
	 */
	public function setSize(int $width, int $height): void {
		$this->width = $width;
		$this->height = $height;
	}
	
	/**
	 * Generate the HTML representation of the <object> element.
	 *
	 * @return string The HTML representation of the <object> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<object'
			. ($this->hasValue($this->data)			? ' data="' . $this->data . '"'			: '')
			. ($this->hasValue($this->mediaType)	? ' type="' . $this->mediaType . '"'	: '')
			. ($this->hasValue($this->width)		? ' width="' . $this->width . '"'		: '')
			. ($this->hasValue($this->height)		? ' height="' . $this->height . '"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</object>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <param> HTML element used inside an <object>.
 */
class Param extends Node {
	protected ?string $name		= null;	// Parameter name
	protected ?string $value	= null;	// Parameter value
	
	/**
	 * Constructor for the Param element.
	 *
	 * @param string $name  The parameter name.
	 * @param string $value The parameter value.
	 */
	public function __construct(string $name, string $value) {
		$this->name = $this->safeHtml($name);
		$this->value = $this->safeHtml($value);
	}
	
	/**
	 * Generate the HTML representation of the <param> element.
	 *
	 * @return string The HTML representation of the <param> element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<param'
			. ($this->hasValue($this->name)		? ' name="' . $this->name . '"'		: '')
			. ($this->hasValue($this->value)	? ' value="' . $this->value . '"'	: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ' />';
			
		return $_html;
	}
}

?>