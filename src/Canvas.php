<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a canvas HTML element.
 * Actual drawing is done via JavaScript using the canvas API.
 * Fallback content is shown in browsers that do not support canvas.
 */
class Canvas extends Node {
	protected ?int $width  = null;
	protected ?int $height = null;
	
	/**
	 * Constructor for the Canvas element.
	 * Sets default HTML5 fallback content.
	 */
	public function __construct() {
		$this->addContent(new Text('Your browser does not support the HTML5 canvas tag.'));
	}
	
	/**
	 * Set the display dimensions of the canvas.
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
	 * Generate the HTML representation of the canvas element.
	 *
	 * @return string The HTML representation of the canvas element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<canvas'
			. ($this->hasValue($this->width)	? ' width="' . $this->width . '"'		: '')
			. ($this->hasValue($this->height)	? ' height="' . $this->height . '"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</canvas>';
			
		return $_html;
	}
}

?>