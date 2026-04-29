<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML comment.
 * Note: Comments always render at level 0 regardless of nesting.
 */
class Comment extends Element {
	protected int $level			= 0;
	protected ?string $comment		= null;
	protected ?string $dashChar		= null;
	protected ?int $dashCount		= null;
	
	/**
	 * Constructor for the comment class.
	 *
	 * @param string $comment The text content of the comment.
	 * @param int $dashCount The number of dashes surrounding the comment. Odd numbers are floored to even.
	 * @param string $dashChar The character used for dashes, only the first character is used.
	 */
	public function __construct(string $comment = 'comment', int $dashCount = 0, string $dashChar = ' ') {
		$this->comment		= $comment;
		$this->dashCount	= $dashCount;
		$this->dashChar		= $dashChar[0];
	}
	
	/**
	 * Compatibility stub for HtmlContent level propagation.
	 * Comments always render at level 0 — this method intentionally does nothing.
	 *
	 * @param int $level Ignored.
	 * @return void
	 */
	public function setLevel(int $level): void {}
	
	/**
	 * Set the character used for dashes in the comment.
	 * Only the first character of the given string is used.
	 *
	 * @param string $dashChar The character to set.
	 * @return void
	 */
	public function setDashChar(string $dashChar): void {
		$this->dashChar = $dashChar[0];
	}
	
	/**
	 * Generate the HTML representation of the comment.
	 *
	 * @return string The HTML representation of the comment.
	 */
	public function getHtml(): string {
		$_dashes = str_repeat($this->dashChar, intdiv($this->dashCount, 2));
		
		$_html = special_chars::NEWLINE . special_chars::NEWLINE
			. '<!-- ' . $_dashes . ' ' . $this->comment . ' ' . $_dashes . ' -->'
			. special_chars::NEWLINE;
			
		return $_html;
	}
}

?>