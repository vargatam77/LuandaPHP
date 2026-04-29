<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an <embed> HTML element.
 * Void element — takes no children.
 */
class Embed extends Node {
	protected ?string $src			= null;
	protected ?string $mediatype	= null;
	protected ?int $width			= null;
	protected ?int $height			= null;
	
	/**
	 * Constructor for the Embed element.
	 *
	 * @param string $src The URL of the resource to embed.
	 */
	public function __construct(?string $src = null) {
		if($this->hasValue($src))
			$this->setSrc($src);
	}
	
	/**
	 * Sets the URL of the embedded resource.
	 *
	 * @param string $src The URL to set.
	 * @return void
	 */
	public function setSrc(string $src): void {
		$this->src = $this->safeUrl($src);
	}
	
	/**
	 * Set the MIME type of the embedded resource.
	 *
	 * @param string $type MIME type string.
	 * @return void
	 */
	public function setMediatype(string $type): void {
		$this->mediatype = $type;
	}
	
	/**
	 * Set the display dimensions.
	 *
	 * @param int $width  Width in pixels.
	 * @param int $height Height in pixels.
	 * @return void
	 */
	public function setSize(int $width, int $height): void {
		$this->width  = $width;
		$this->height = $height;
	}
	
	/**
	 * Generate the HTML representation of the <embed> element.
	 *
	 * @return string The HTML representation of the <embed> element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<embed'
			. ($this->hasValue($this->src)			? ' src="' . $this->src . '"'			: '')
			. ($this->hasValue($this->mediatype)	? ' type="' . $this->mediatype . '"'	: '')
			. ($this->hasValue($this->width)		? ' width="' . $this->width . '"'		: '')
			. ($this->hasValue($this->height)		? ' height="' . $this->height . '"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ' />';
			
		return $_html;
	}
}

?>
