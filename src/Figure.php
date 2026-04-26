<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <figure> HTML element.
 * Caption can appear before or after the content per HTML5 spec.
 */
class Figure extends Node {
	protected ?FigCaption $caption = null;
	protected bool $captionPosition = caption_position::FIRST;
	
	/**
	 * Constructor for the Figure element.
	 *
	 * @param FigCaption $caption The caption element.
	 * @param bool $captionpositioon Sets whether the caption
	 * appears ahead of after the content
	 */
	public function __construct(FigCaption $caption, bool $captionposition = caption_position::FIRST) {
		$this->caption = $caption;
		$this->captionPosition = $captionposition;
	}
	
	/**
	 * Set a FigCaption element explicitly.
	 *
	 * @param FigCaption $caption The caption element.
	 * @return void
	 */
	public function setCaption(FigCaption $caption): void {
		$this->caption = $caption;
	}
	
	/**
	 * Generate the HTML representation of the <figure> element.
	 *
	 * @return string The HTML representation of the <figure> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level + 1);
		$this->caption?->setLevel($this->level + 1);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
		. $_indent . '<figure'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. ($this->captionPosition === caption_position::FIRST) ? $this->caption?->getHtml() : ''
			. $this->content?->getHtml()
			. ($this->captionPosition === caption_position::LAST) ? $this->caption?->getHtml() : ''
			. special_chars::NEWLINE
			. $_indent . '</figure>';
			
		return $_html;
	}
}

//------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for caption position
 */
class caption_position {
	public const bool FIRST = true;
	public const bool LAST = false;
}

?>
