<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a heading HTML element.
 */
class Heading extends Node {
	protected ?int $headingLevel = null;
	
	/**
	 * Constructor to initialize heading with a specified level.
	 *
	 * @param int $headingLevel The level of the heading, use heading_level:: constants.
	 */
	public function __construct(int $headingLevel) {
		$this->setHeadingLevel($headingLevel);
	}
	
	/**
	 * Set the level of the heading.
	 *
	 * @param int $headingLevel The level of the heading, use heading_level:: constants.
	 * @return void
	 */
	public function setHeadingLevel(int $headingLevel): void {
		$this->headingLevel = max(1, min(6, $headingLevel));
	}
	
	/**
	 * Generate HTML representation of the heading.
	 *
	 * @return string The HTML representation of the heading.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<h' . $this->headingLevel
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</h' . $this->headingLevel . '>';
		
		return $_html;
	}
}

//-------------------------------------------------------------------------------------------------

/**
 * Constants for heading levels H1-H6.
 */
class heading_level {
	public const H1 = 1;
	public const H2 = 2;
	public const H3 = 3;
	public const H4 = 4;
	public const H5 = 5;
	public const H6 = 6;
}

?>