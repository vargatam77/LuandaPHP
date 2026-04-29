<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

use TamasVarga\LuandaPHP\Misc\EncodedImg;
use TamasVarga\LuandaPHP\Misc\Svg;

/**
 * Represents an HTML image element.
 */
class Image extends Node {
	protected ?string $url = null;		// URL of the image
	protected ?string $alt = null;		// Alternate text for the image
	protected ?int $width = null;		// Width of the image in pixels
	protected ?int $height = null;		// Height of the image in pixels
	
	/**
	 * Constructor for the image element.
	 *
	 * @param string|null $url URL of the image
	 * @param string|null $alt Alternate text for the image
	 */
	public function __construct(?string $url = null, ?string $alt = null) {
		if ($this->hasValue($url)) $this->setUrl($url);
		if ($this->hasValue($alt)) $this->setAlt($alt);
	}
	
	/**
	 * Set the URL of the image.
	 *
	 * @param string $url URL of the image
	 * @return void
	 */
	public function setUrl(string $url): void {
		$this->url = $this->safeUrl($url);
	}
	
	/**
	 * Set the alternate text for the image.
	 *
	 * @param string $alt Alternate text for the image
	 * @return void
	 */
	public function setAlt(string $alt): void {
		$this->alt = $this->safeHtml($alt);
	}
	
	/**
	 * Set the width and height of the image in pixels.
	 *
	 * @param int|null $width  Width in pixels
	 * @param int|null $height Height in pixels
	 * @return void
	 */
	public function setSize(?int $width = null, ?int $height = null): void {
		if ($this->hasValue($width)) $this->width = $width;
		if ($this->hasValue($height)) $this->height = $height;
	}
	
	/**
	 * Load the image from a local path and convert to Base64.
	 * If no path is provided or the path does not exist, a default
	 * no-image placeholder SVG is loaded instead.
	 *
	 * @param string|null $path Local file path to the image
	 * @return void
	 */
	public function loadBase64(?string $path = null): void {
		$_encoder = new EncodedImg($path);
		$this->url = $_encoder->loadToBase64();
	}
	
	/**
	 * Load the image from an svg and convert to Base64.
	 *
	 * @param Svg|string $svg An Svg object or string containing svg code
	 * @return void
	 */
	public function loadSvgBase64(Svg|string $svg): void {
		$_encoder = new EncodedImg();
		$this->url = $_encoder->createFromSvg($svg);
	}
	
	/**
	 * Generate HTML representation of the image element.
	 * If no URL is set or the URL points to a local path that does not exist,
	 * a default no-image placeholder is loaded via loadBase64().
	 *
	 * @return string The HTML representation of the image element
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		if (!$this->hasValue($this->url) || (!file_exists($this->url) && !str_contains($this->url, 'base64')))
			$this->loadBase64();
			
		$_html = special_chars::NEWLINE
			. $_indent . '<img'
			. ($this->hasValue($this->url)		? ' src="' . $this->url . '"'			: '')
			. ($this->hasValue($this->alt)		? ' alt="' . $this->alt . '"'			: ' alt=""')
			. ($this->hasValue($this->width)	? ' width="' . $this->width . '"'		: '')
			. ($this->hasValue($this->height)	? ' height="' . $this->height . '"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ' />';
			
		return $_html;
	}
}