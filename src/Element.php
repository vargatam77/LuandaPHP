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

namespace TamasVarga\LuandaPHP;

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

namespace TamasVarga\LuandaPHP;

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

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for media type values.
 */
class media_type {
	public const ALL	= 'all';
	public const SCREEN	= 'screen';
	public const PRINT	= 'print';
	public const SPEECH	= 'speech';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for media orientation values.
 */
class media_orientation {
	public const PORTRAIT	= 'portrait';
	public const LANDSCAPE	= 'landscape';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for media color scheme values.
 */
class media_colorscheme {
	public const LIGHT	= 'light';
	public const DARK	= 'dark';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for media reduced motion values.
 */
class media_reducedmotion {
	public const REDUCE			= 'reduce';
	public const NO_PREFERENCE	= 'no-preference';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for media hover values.
 */
class media_hover {
	public const HOVER	= 'hover';
	public const NONE	= 'none';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for area shape values.
 */
class map_area_shape {
	public const RECT		= 'rect';
	public const CIRCLE		= 'circle';
	public const POLY		= 'poly';
	public const DEFAULT	= 'default';
}

//-------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

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

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Constants representing different types of Font Awesome icons.
 */
class icon_type {
	public const SOLID			= 'fa-solid';
	public const REGULAR		= 'fa-regular';
	public const LIGHT			= 'fa-light';
	public const DUO			= 'fa-duotone';
	public const THIN			= 'fa-thin';
	public const BRAND			= 'fa-brands';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Constants representing different animations for Font Awesome icons.
 */
class icon_anim {
	public const BEAT			= 'fa-beat';
	public const BEATFADE		= 'fa-beat-fade';
	public const BOUNCE			= 'fa-bounce';
	public const FADE			= 'fa-fade';
	public const FLIP			= 'fa-flip';
	public const SHAKE			= 'fa-shake';
	public const SPIN			= 'fa-spin';
	public const REVERSE		= 'fa-spin fa-spin-reverse';
	public const PULSE			= 'fa-spin fa-spin-pulse';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Constants representing different rotations for Font Awesome icons.
 */
class icon_rotation {
	public const ROT90			= 'fa-rotate-90';
	public const ROT180			= 'fa-rotate-180';
	public const ROT270			= 'fa-rotate-270';
	public const HFLIP			= 'fa-flip-horizontal';
	public const VFLIP			= 'fa-flip-vertical';
	public const HVFLIP			= 'fa-flip-both';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Constants representing different sizes for Font Awesome icons.
 */
class icon_size {
	public const XXS			= 'fa-2xs';
	public const XS				= 'fa-xs';
	public const SM				= 'fa-sm';
	public const LG				= 'fa-lg';
	public const XL				= 'fa-xl';
	public const XXL			= 'fa-2xl';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for translation states.
 */
class translate {
	public const YES			= "yes";
	public const NO				= "no";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for popover states.
 */
class popover_state {
	public const AUTO			= "auto";
	public const HINT			= "hint";
	public const MANUAL			= "manual";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for popover actions.
 */
class popover_action {
	public const HIDE			= "hide";
	public const SHOW			= "show";
	public const TOGGLE			= "toggle";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for text direction values.
 */
class text_direction {
	public const LEFT			= "ltr";
	public const RIGHT			= "rtl";
	public const AUTO			= "auto";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define bitmask constants for inline text formatting.
 */
class text_format {
	public const STRONG		= 1 << 0;	// <strong> important text
	public const EM			= 1 << 1;	// <em> emphasis
	public const MARK		= 1 << 2;	// <mark> highlighted
	public const B			= 1 << 3;	// <b> stylistic bold
	public const I			= 1 << 4;	// <i> stylistic italic
	public const U			= 1 << 5;	// <u> underline annotation
	public const S			= 1 << 6;	// <s> strikethrough
	public const DEL		= 1 << 7;	// <del> deleted text
	public const INS		= 1 << 8;	// <ins> inserted text
	public const SMALL		= 1 << 9;	// <small> side comment
	public const SUB		= 1 << 10;	// <sub> subscript
	public const SUP		= 1 << 11;	// <sup> superscript
	public const KBD		= 1 << 12;	// <kbd> keyboard input
	public const SAMP		= 1 << 13;	// <samp> sample output
	public const VAR		= 1 << 14;	// <var> variable
	public const DFN		= 1 << 15;	// <dfn> definition term
	public const Q			= 1 << 16;	// <q> inline quotation
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for character set values.
 */
class charset {
	public const UTF8			= "UTF-8";
	public const UTF16			= "UTF-16";
	public const WIN1252		= "Windows-1252";
	public const ISO8859		= "ISO-8859";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for link target values.
 */
class anchor_target {
	public const NEWPAGE		= "_blank";
	public const SAMEPAGE		= "_self";
	public const PARENTPAGE		= "_parent";
	public const TOP			= "_top";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Constants for the anchor rel attribute values.
 */
class anchor_relation {
	public const ALTERNATE		= 'alternate';
	public const AUTHOR			= 'author';
	public const BOOKMARK		= 'bookmark';
	public const EXTERNAL		= 'external';
	public const HELP			= 'help';
	public const LICENSE		= 'license';
	public const ME				= 'me';
	public const NEXT			= 'next';
	public const NOFOLLOW		= 'nofollow';
	public const NOOPENER		= 'noopener';
	public const NOREFERRER		= 'noreferrer';
	public const OPENER			= 'opener';
	public const PREV			= 'prev';
	public const SEARCH			= 'search';
	public const TAG			= 'tag';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Constants for the referrerpolicy attribute.
 */
class anchor_refpolicy {
	public const NO_REFERRER						= 'no-referrer';
	public const NONE_WHEN_DONWGRADE				= 'no-referrer-when-downgrade';
	public const ORIGIN_ONLY						= 'origin';
	public const ORIGIN_WHEN_CROSSORIGIN			= 'origin-when-cross-origin';
	public const SAME_ORIGIN						= 'same-origin';
	public const STRICT_ORIGIN						= 'strict-origin';
	public const STRICT_ORIGIN_WHEN_CROSSORIGIN		= 'strict-origin-when-cross-origin';
	public const UNSAFE								= 'unsafe-url';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for form autocomplete values.
 */
class form_autocomplete {
	public const ON				= "on";
	public const OFF			= "off";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for form method values.
 */
class form_method {
	public const GET			= "get";
	public const POST			= "post";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for form relation values.
 */
class form_relation {
	public const EXT			= "external";
	public const HELP			= "help";
	public const LICENSE		= "license";
	public const NEXT			= "next";
	public const NOFOLLOW		= "nofollow";
	public const NOOPENER		= "noopener";
	public const NOREF			= "noreferrer";
	public const PREV			= "prev";
	public const SEARCH			= "search";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for form encoding type values.
 */
class form_enctype {
	public const URL			= "application/x-www-form-urlencoded";
	public const FILE			= "multipart/form-data";
	public const TEXT			= "text/plain";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for form input type values.
 */
class input_type {
	public const BTN			= "button";
	public const CHKBOX			= "checkbox";
	public const COLORPICKER	= "color";
	public const DATE			= "date";
	public const LCLDATE		= "datetime-local";
	public const EMAIL			= "email";
	public const FILE			= "file";
	public const HIDDEN			= "hidden";
	public const IMG			= "image";
	public const MONTH			= "month";
	public const NUM			= "number";
	public const PWD			= "password";
	public const RADIOBTN		= "radio";
	public const RANGE			= "range";
	public const RESET			= "reset";
	public const SEARCH			= "search";
	public const SUBMIT			= "submit";
	public const TEL			= "tel";
	public const TEXT			= "text";
	public const TIME			= "time";
	public const URL			= "url";
	public const WEEK			= "week";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for form button type values.
 */
class button_type {
	public const BTN			= "button";
	public const RESET			= "reset";
	public const SUBMIT			= "submit";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for form file format values.
 */
class file_format {
	public const ANY			= ".*";
	public const AUDIO			= "audio/*";
	public const VIDEO			= "video/*";
	public const IMAGE			= "image/*";
	public const PDF			= ".pdf, application/pdf";
	public const MSDOC			= ".doc, .docx, application/msword";
	public const XML			= ".xml, text/xml, application/xml";
	public const HTML			= ".htm, .html, text/html";
	public const SQL			= ".sql";
	public const ZIP			= ".zip, application/zip";
	public const JSON			= ".json, text/json, application/json";
	public const JSCRIPT		= ".js, text/javascript, text/jscript";
	public const CAMERA			= "capture=camera";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for script type values.
 */
class script_type {
	public const HEADLINK		= 0;
	public const BODYLINK		= 1;
	public const RUNCMD			= 2;
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for textarea wrap mode values.
 */
class textarea_wrapmode {
	public const SOFT			= "soft";
	public const HARD			= "hard";
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for list style values.
 */
class list_style {
	public const UNORDERED		= 'ul';
	public const ORDERED		= 'ol';
	public const DESCRIPTION	= 'dl';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for listitem types.
 */
class listitem_type {
	public const ITEM			= 'li';
	public const TERM			= 'dt';
	public const DATA			= 'dd';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define constants for table header scope values.
 */
class table_header_scope {
	public const ROW		= 'row';
	public const COL		= 'col';
	public const ROWGROUP	= 'rowgroup';
	public const COLGROUP	= 'colgroup';
	public const AUTO		= 'auto';
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Class to define mime types.
 */
class image_mime_type {
	// Standard Vector Format
	public const SVG = 'image/svg+xml';
	
	// Modern Web Formats
	public const WEBP = 'image/webp';
	public const AVIF = 'image/avif';
	public const HEIC = 'image/heic';
	public const HEIF = 'image/heif';
	
	// Ubiquitous Web Formats
	public const JPEG = 'image/jpeg';
	public const PNG  = 'image/png';
	public const GIF  = 'image/gif';
	
	// Professional & Editing Formats
	public const TIFF = 'image/tiff';
	public const PSD  = 'image/vnd.adobe.photoshop';
	public const AI   = 'application/postscript'; // Often delivered as EPS/PostScript
	public const EPS  = 'image/x-eps';
	
	// Common Legacy / OS-Specific Formats
	public const BMP  = 'image/bmp';
	public const ICO  = 'image/x-icon';
	public const TGA  = 'image/x-targa';
	
	// Major Camera RAW Formats
	public const DNG  = 'image/x-adobe-dng';       // Adobe Digital Negative
	public const CR2  = 'image/x-canon-cr2';       // Canon CR2
	public const CR3  = 'image/x-canon-cr3';       // Canon CR3
	public const NEF  = 'image/x-nikon-nef';       // Nikon
	public const ARW  = 'image/x-sony-arw';        // Sony
	public const ORF  = 'image/x-olympus-orf';     // Olympus
	public const RW2  = 'image/x-panasonic-rw2';   // Panasonic
}

//--------------------------------------------------------------------------------------------------------------------------------

namespace TamasVarga\LuandaPHP;

/**
 * Utility class to clone objects.
 */
abstract class deep_cloner {
	/**
	 * Clones the given object.
	 *
	 * @param object $object The object to clone.
	 * @return object The cloned object.
	 */
	public static function getClone(object $object): object {
		return unserialize(serialize($object));
	}
}

?>