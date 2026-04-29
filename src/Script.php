<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <script> HTML element for external or inline JavaScript.
 */
class Script extends Node {
	protected ?string $src			= null;	// Src attribute of the script
	protected ?string $crossorigin	= null;	// Crossorigin attribute of the script
	
	/**
	 * Constructor for the Script element.
	 *
	 * @param string      $src         The src attribute or inline script code.
	 * @param string|null $crossorigin The crossorigin attribute value.
	 */
	public function __construct(string $url, ?string $crossorigin = null) {
		$this->src = $this->safeUrl($url);
		if ($this->hasValue($crossorigin))
			$this->crossorigin = $crossorigin;
	}
	
	/**
	 * Sets the crossorigin attribute.
	 *
	 * @param string $origin The crossorigin attribute value.
	 * @return void
	 */
	public function setOrigin(string $origin): void {
		$this->crossorigin = $origin;
	}
	
	/**
	 * Generate the HTML representation of an inline script.
	 *
	 * @return string The HTML representation of the inline script.
	 */
	public function runScript(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<script type="text/javascript">'
			. $this->src
			. '</script>';
			
		return $_html;
	}
	
	/**
	 * Generate the HTML representation of the <script> element.
	 *
	 * @return string The HTML representation of the <script> element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<script'
			. ($this->hasValue($this->crossorigin) ? '' : ' type="text/javascript"')
			. ' src="' . $this->src . '"'
			. ($this->hasValue($this->crossorigin) ? ' crossorigin="' . $this->crossorigin . '"' : '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '></script>';
			
		return $_html;
	}
}

?>