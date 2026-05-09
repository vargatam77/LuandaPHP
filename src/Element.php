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
		self::$indentString = indent_type::TAB;
		self::$newlineString = special_chars::NEWLINE;
	}

	/**
	 * Sets output to minified format with no whitespace or newlines.
	 *
	 * Strips all indentation and line breaks globally across all components.
	 */
	public static function Minify(): void {
		self::$indentString = indent_type::NONE;
		self::$newlineString = indent_type::NONE;
	}

	/**
	 * Sets a custom indentation style globally across all components.
	 *
	 * @param string $indenttype An indent_type:: constant
	 */
	public static function setIndentType($indenttype): void {
		self::$indentString = $indenttype;
	}
	
	/**
	 * gets indentation style globally across all components.
	 *
	 * @return string The globally set indentation string \t by default
	 */
	protected static function getIndentString(): string {
		return self::$indentString;
	}
	
	/**
	 * Gets newline style globally across all components.
	 *
	 * @return string The globally set newline string \n by default
	 */
	protected static function getNewlineString(): string {
		return self::$newlineString;
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

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for indentation type values.
 */
class indent_type {
	public const NONE			= "";
	public const TAB			= "\u{0009}";
	public const SPACE			= "\u{0020}";
	public const DBLSPACE		= self::SPACE . self::SPACE;
	public const QUADSPACE		= self::DBLSPACE . self::DBLSPACE;
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define commonly used Unicode characters for safe text rendering.
 */
class special_chars {
	// --- Newline ---
	public const NEWLINE		= "\u{000A}";
	
	// --- Whitespace ---
	public const NBSP			= "\u{00A0}"; // non-breaking space
	public const THIN_SPACE		= "\u{2009}"; // thin space
	public const HAIR_SPACE		= "\u{200A}"; // very thin space
	public const ZWSP			= "\u{200B}"; // zero-width space (line break hint)
	
	// --- Dashes ---
	public const NDASH			= "\u{2013}"; // –
	public const MDASH			= "\u{2014}"; // —
	
	// --- Ellipsis ---
	public const HELLIP			= "\u{2026}"; // …
	
	// --- Quotes ---
	public const LQUOTE			= "\u{201C}"; // “
	public const RQUOTE			= "\u{201D}"; // ”
	public const LSQUOTE		= "\u{2018}"; // ‘
	public const RSQUOTE		= "\u{2019}"; // ’
	
	// --- Common symbols ---
	public const COPY			= "\u{00A9}"; // ©
	public const REG			= "\u{00AE}"; // ®
	public const TRADE			= "\u{2122}"; // ™
	
	// --- Optional useful extras ---
	public const DEGREE			= "\u{00B0}"; // °
	public const PLUS_MINUS		= "\u{00B1}"; // ±
}

?>