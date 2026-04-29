<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <map> HTML element used for image maps.
 */
class Map extends Node {
	
	/**
	 * Constructor for the Map element.
	 *
	 * @param string $mapname The name to associate with an image via usemap.
	 */
	public function __construct(string $mapname) {
		$this->name = $this->safeHtml($mapname);
	}
	
	/**
	 * Generate the HTML representation of the <map> element.
	 *
	 * @return string The HTML representation of the <map> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<map'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</map>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents an <area> HTML element inside a map.
 */
class Area extends Node {
	protected ?string $href			= null;		// Link URL for the area
	protected ?string $alt			= null;		// Alternative text
	protected ?string $shape		= null;		// Shape of the area
	protected ?string $coords		= null;		// Coordinates for the shape
	protected ?string $target		= null;		// Link target
	protected ?string $rel			= null;		// Relationship hint
	protected ?string $download		= null;		// Suggested download filename
	
	/**
	 * Constructor for the Area element.
	 *
	 * @param string $shape  Use area_shape constants.
	 * @param string|null $coords Comma-separated coordinate string.
	 */
	public function __construct(string $shape = area_shape::DEFAULT, ?string $coords = null) {
		$this->shape = $shape;
		if ($this->hasValue($coords)) $this->coords = $coords;
	}
	
	/**
	 * Set the link and its alternative text.
	 *
	 * @param string $href The destination URL.
	 * @param string $alt  Alternative text description.
	 * @return void
	 */
	public function setLink(string $url, string $alt): void {
		$this->href = $this->safeUrl($url);
		$this->alt = $this->safeHtml($alt);
	}
	
	/**
	 * Set the link target.
	 *
	 * @param string $target Use link_target constants.
	 * @return void
	 */
	public function setTarget(string $target): void {
		$this->target = $target;
	}
	
	/**
	 * Set the rel attribute.
	 *
	 * @param string $rel Use form_rel constants.
	 * @return void
	 */
	public function setRel(string $rel): void {
		$this->rel = $rel;
	}
	
	/**
	 * Make the link trigger a file download.
	 *
	 * @param string $filename Optional suggested filename.
	 * @return void
	 */
	public function setDownload(string $filename = ''): void {
		$this->download = $this->safeHtml($filename);
	}
	
	/**
	 * Generate the HTML representation of the <area> element.
	 *
	 * @return string The HTML representation of the <area> element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<area'
			. ($this->hasValue($this->shape)	? ' shape="' . $this->shape	. '"'												: '')
			. ($this->hasValue($this->coords)	? ' coords="' . $this->coords . '"'												: '')
			. ($this->hasValue($this->href)		? ' href="' . $this->href . '"'													: '')
			. ($this->hasValue($this->alt)		? ' alt="' . $this->alt	. '"'													: '')
			. ($this->hasValue($this->target)	? ' target="' . $this->target . '"'												: '')
			. ($this->hasValue($this->rel)		? ' rel="' . $this->rel	. '"'													: '')
			. ($this->hasValue($this->download)	? ' download' . ($this->download !== '' ? '="' . $this->download . '"' : '')	: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ' />';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for area shape values.
 */
class area_shape {
	public const RECT		= 'rect';
	public const CIRCLE		= 'circle';
	public const POLY		= 'poly';
	public const DEFAULT	= 'default';
}

?>