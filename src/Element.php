<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Foundation logic for all LuandaPHP components.
 *
 * Provides global output formatting control and core escaping helpers
 * shared across all child elements.
 *
 * Output mode is controlled statically and applies to all components:
 * - Call Element::Beautify() for readable, indented output
 * - Call Element::Minify() for compact, whitespace-free output
 * - Call Element::setIndentType() to set a custom indentation style
 *
 * @see indent_type
 * @see special_chars
 */
abstract class Element {
	private static string $indentString = indent_type::TAB;
	private static string $newlineString = special_chars::NEWLINE;

	/**
	 * Sets output to human-readable format with indentation and newlines.
	 *
	 * Uses TAB indentation and NEWLINE line breaks globally across all components.
	 */
	public static function Beautify(): void {
		Element::getIndentString() = indent_type::TAB;
		Element::getNewlineString() = special_chars::NEWLINE;
	}

	/**
	 * Sets output to minified format with no whitespace or newlines.
	 *
	 * Strips all indentation and line breaks globally across all components.
	 */
	public static function Minify(): void {
		Element::getIndentString() = indent_type::NONE;
		Element::getNewlineString() = indent_type::NONE;
	}

	/**
	 * Sets a custom indentation style globally across all components.
	 *
	 * @param string $indenttype An indent_type:: constant
	 */
	public static function setIndentType($indenttype): void {
		Element::getIndentString() = $indenttype;
	}
	
	/**
	 * gets indentation style globally across all components.
	 *
	 * @return string The globally set indentation string \t by default
	 */
	protected static function getIndentString(): string {
		return Element::getIndentString();
	}
	
	/**
	 * Gets newline style globally across all components.
	 *
	 * @return string The globally set newline string \n by default
	 */
	protected static function getNewlineString(): string {
		return Element::getNewlineString();
	}

	/**
	 * Checks whether a value is considered non-empty.
	 * Handles null, strings, and arrays.
	 *
	 * @param mixed $value
	 * @return bool
	 */
	protected function hasValue(mixed $value): bool {
		return match(true) {
			is_array($value) => !empty($value),
			default          => isset($value) && $value !== null
		};
	}

	/**
	 * Safely escapes a string for HTML output (Content & Attributes).
	 *
	 * @param string $text
	 * @return string
	 */
	protected function safeHtml(string $text): string {
		return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE, 'UTF-8');
	}

	/**
	 * Specifically for URLs (href, src, action).
	 *
	 * Supports SPA javascript: calls.
	 *
	 * @param string $url
	 * @return string
	 */
	protected function safeUrl(string $url): string {
		return $this->safeHtml($url);
	}
}

?>