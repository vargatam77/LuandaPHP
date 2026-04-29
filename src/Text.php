<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a text node with optional inline semantic formatting.
 */
class Text extends Node {
	protected ?string $text		= null;	// Text content
	protected int $format		= 0;	// Bitmask of text_format flags
	
	/**
	 * Constructor for the Text element.
	 *
	 * @param string $text   The initial text content.
	 * @param int    $format Optional bitmask of text_format flags.
	 */
	public function __construct(?string $text = null, int $format = 0) {
		if ($this->hasValue($text)) $this->setText($text);
		$this->format = $format;
	}
	
	/**
	 * Sets the text content.
	 *
	 * @param string $text The text content to set.
	 * @return void
	 */
	public function setText(string $text): void {
		$this->text = $this->safeHtml($text);
	}
	
	/**
	 * Appends text to the existing content.
	 *
	 * @param string $text The text content to append.
	 * @return void
	 */
	public function addText(string $text): void {
		$this->text .= $this->safeHtml($text);
	}
	
	/**
	 * Retrieves the current text content.
	 *
	 * @return string The text content.
	 */
	public function getText(): string {
		return $this->text;
	}
	
	/**
	 * Fetches content from a URL and sets it as the text content.
	 *
	 * @param string $url The URL to fetch content from.
	 * @return void
	 */
	public function getFromUrl(string $url): void {
		$this->text = $this->safeHtml(file_get_contents($url));
	}
	
	/**
	 * Replaces the current format bitmask.
	 *
	 * @param int $format Bitmask of text_format flags.
	 * @return void
	 */
	public function setFormat(int $format): void {
		$this->format = $format;
	}
	
	/**
	 * Adds flags to the current format bitmask.
	 *
	 * @param int $format Bitmask of text_format flags to add.
	 * @return void
	 */
	public function addFormat(int $format): void {
		$this->format |= $format;
	}
	
	/**
	 * Generate the HTML representation of the text element.
	 *
	 * @return string The HTML representation of the text element.
	 */
	public function getHtml(): string {
		$_html = ($this->format & text_format::STRONG	? '<strong>'	: '')
		. ($this->format & text_format::EM			? '<em>'		: '')
		. ($this->format & text_format::MARK		? '<mark>'		: '')
		. ($this->format & text_format::B			? '<b>'			: '')
		. ($this->format & text_format::I			? '<i>'			: '')
		. ($this->format & text_format::U			? '<u>'			: '')
		. ($this->format & text_format::S			? '<s>'			: '')
		. ($this->format & text_format::DEL			? '<del>'		: '')
		. ($this->format & text_format::INS			? '<ins>'		: '')
		. ($this->format & text_format::SMALL		? '<small>'		: '')
		. ($this->format & text_format::SUB			? '<sub>'		: '')
		. ($this->format & text_format::SUP			? '<sup>'		: '')
		. ($this->format & text_format::KBD			? '<kbd>'		: '')
		. ($this->format & text_format::SAMP		? '<samp>'		: '')
		. ($this->format & text_format::VAR			? '<var>'		: '')
		. ($this->format & text_format::DFN			? '<dfn>'		: '')
		. ($this->format & text_format::Q			? '<q>'			: '')
		. ($this->format & text_format::CODE		? '<code>'		: '')
		. $this->text
		. ($this->format & text_format::CODE		? '</code>'		: '')
		. ($this->format & text_format::Q			? '</q>'		: '')
		. ($this->format & text_format::DFN			? '</dfn>'		: '')
		. ($this->format & text_format::VAR			? '</var>'		: '')
		. ($this->format & text_format::SAMP		? '</samp>'		: '')
		. ($this->format & text_format::KBD			? '</kbd>'		: '')
		. ($this->format & text_format::SUP			? '</sup>'		: '')
		. ($this->format & text_format::SUB			? '</sub>'		: '')
		. ($this->format & text_format::SMALL		? '</small>'	: '')
		. ($this->format & text_format::INS			? '</ins>'		: '')
		. ($this->format & text_format::DEL			? '</del>'		: '')
		. ($this->format & text_format::S			? '</s>'		: '')
		. ($this->format & text_format::U			? '</u>'		: '')
		. ($this->format & text_format::I			? '</i>'		: '')
		. ($this->format & text_format::B			? '</b>'		: '')
		. ($this->format & text_format::MARK		? '</mark>'		: '')
		. ($this->format & text_format::EM			? '</em>'		: '')
		. ($this->format & text_format::STRONG		? '</strong>'	: '');
		
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <bdi> HTML element for bidirectional text isolation.
 */
class Bdi extends Node {
	protected ?string $dir = null;	// Text direction, use text_direction constants
	
	/**
	 * Constructor for the Bdi element.
	 *
	 * @param string|null $dir Text direction, use text_direction constants.
	 */
	public function __construct(?string $dir = null) {
		if ($this->hasValue($dir)) $this->setDir($dir);
	}
	
	/**
	 * Sets the text direction.
	 *
	 * @param string $dir Use text_direction constants.
	 * @return void
	 */
	public function setDir(string $dir): void {
		$this->dir = $dir;
	}
	
	/**
	 * Generate the HTML representation of the <bdi> element.
	 *
	 * @return string The HTML representation of the <bdi> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<bdi'
			. ($this->hasValue($this->dir)	? ' dir="' . $this->dir . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. '</bdi>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <bdo> HTML element for bidirectional text override.
 */
class Bdo extends Node {
	protected string $dir = text_direction::LEFT;	// Text direction, use text_direction constants
	
	/**
	 * Constructor for the Bdo element.
	 *
	 * @param string $dir Text direction, use text_direction constants.
	 */
	public function __construct(string $dir = text_direction::LEFT) {
		$this->setDir($dir);
	}
	
	/**
	 * Sets the text direction.
	 *
	 * @param string $dir Use text_direction constants.
	 * @return void
	 */
	public function setDir(string $dir): void {
		$this->dir = $dir;
	}
	
	/**
	 * Generate the HTML representation of the <bdo> element.
	 *
	 * @return string The HTML representation of the <bdo> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<bdo'
			. ' dir="' . $this->dir . '"'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. '</bdo>';
			
		return $_html;
	}
}

/**
 * Represents a <pre> HTML element for preformatted text.
 */
class Pre extends Node {
	
	/**
	 * Constructor for the Pre element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Generate the HTML representation of the <pre> element.
	 *
	 * @return string The HTML representation of the <pre> element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
		. $_indent . '<pre'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
				. $this->content?->getHtml()
				. '</pre>';
				
				return $_html;
	}
}

?>