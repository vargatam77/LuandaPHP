<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Class to handle HTML global attributes, extending the global event class.
 */
abstract class GlobalAttr extends GlobalEvent {
    protected ?string $id = null;				// ID attribute
    protected ?string $title = null;			// Title attribute
    protected array $classes = [];				// CSS classes
    protected ?bool $hidden = null;				// Hidden flag
    protected ?bool $autofocus = null;			// Autofocus flag
    protected ?int $tabindex = null;			// Tab index
    protected ?string $accesskey = null;		// Access key
    protected ?bool $draggable = null;			// Draggable flag
    protected ?bool $inert = null;				// Inert flag
    protected ?bool $contenteditable = null;	// Editable flag
    protected ?string $lang = null;				// Language
    protected ?string $popover = null;			// Popover state
    protected ?string $translate = null;		// Translate attribute
    protected ?bool $spellcheck = null;			// Spellcheck flag
    protected ?string $dir = null;				// Text direction
    protected ?bool $disabled = null;			// Disabled flag
    protected array $attributes = [];			// Custom attributes

    protected ?string $name = null;				// Name attribute
    protected ?string $contextmenu = null;		// ID of associated context menu
    protected ?string $style = null;			// Inline CSS style
    
    /**
     * Sets the ID attribute.
     *
     * @param string $id The ID to set.
     * @return void
     */
    public function setId(string $id): void {
        $this->id = $id;
    }
    
    /**
     * Gets the ID attribute.
     *
     * @return string|null The current ID.
     */
    public function getId(): ?string {
        return $this->id;
    }
    
    /**
     * Adds a custom attribute.
     *
     * @param string $name The name of the attribute.
     * @param string $value The value of the attribute.
     * @return void
     */
    public function addAttr(string $name, string $value): void {
        $this->attributes[$name] = $value;
    }
    
    /**
     * Sets the title attribute.
     *
     * @param string $title The title to set.
     * @return void
     */
    public function setTitle(string $title): void {
        $this->title = $this->safeHtml($title);
    }
    
    /**
     * Hides the element by setting the hidden attribute.
     *
     * @return void
     */
    public function Hide(): void {
        $this->hidden = true;
    }
    
    /**
     * Checks if the element is hidden.
     *
     * @return bool|null True if the element is hidden, false otherwise.
     */
    public function isHidden(): ?bool {
        return $this->hidden;
    }
    
    /**
     * Sets the autofocus attribute.
     *
     * @return void
     */
    public function setAutoFocus(): void {
        $this->autofocus = true;
    }

    /**
     * Sets the inert attribute.
     *
     * @return void
     */
    public function setInert(): void {
        $this->inert = true;
    }
    
    /**
     * Disables the element
     *
     * @return void
     */
    public function Disable(): void {
    	$this->disabled = true;
    }

    /**
     * Sets the tabindex attribute.
     *
     * @param int $tabindex The tabindex to set.
     * @return void
     */
    public function setTabindex(int $tabindex): void {
        $this->tabindex = $tabindex;
    }
    
    /**
     * Sets the name attribute.
     *
     * @param string $name The name to set.
     * @return void
     */
    public function setName(string $name): void {
        $this->name = $name;
    }
    
    /**
     * Sets the accesskey attribute.
     *
     * @param string $accesskey The access key to set.
     * @return void
     */
    public function setAccesskey(string $accesskey): void {
        $this->accesskey = $accesskey;
    }
    
    /**
     * Makes the element draggable.
     *
     * @return void
     */
    public function setDraggable(): void {
        $this->draggable = true;
    }
    
    /**
     * Sets the contenteditable attribute.
     *
     * @return void
     */
    public function toEditable(): void {
        $this->contenteditable = true;
    }
    
    /**
     * Sets the lang attribute.
     *
     * @param string $language The language code to set.
     * @return void
     */
    public function setLanguage(string $language): void {
        $this->lang = $language;
    }
    
    /**
     * Sets the translate attribute.
     *
     * @param string $translate Whether to translate content, yes or no, default no.
     * @return void
     */
    public function toTranslate(string $translate = translate::YES): void {
        $this->translate = $translate;
    }
    
    /**
     * Sets the spellcheck attribute.
     *
     * @return void
     */
    public function toSpellcheck(): void {
        $this->spellcheck = true;
    }
    
    /**
     * Adds a CSS class to the element.
     *
     * @param string $classes The class to add.
     * @return void
     */
    public function addClass(string $classes): void {
    	foreach (explode(' ', $classes) as $_class)
    		$this->classes[$_class] = $_class;
    }
    
    /**
     * Sets the contextmenu attribute.
     *
     * @param string $menuId The ID of the associated menu element.
     * @return void
     */
    public function setContextmenu(string $menuId): void {
        $this->contextmenu = $menuId;
    }
    
    /**
     * Sets the inline style attribute.
     *
     * @param string $css The CSS declarations to set.
     * @return void
     */
    public function setStyle(string $style): void {
        $this->style = $style;
    }

    /**
     * Sets the text direction attribute.
     *
     * @param string $dir The text direction (ltr, rtl, auto).
     * @return void
     */
    public function setDirection(string $dir): void {
        $this->dir = $dir;
    }
    
    /**
     * Sets the popover attribute.
     *
     * @param string $state The popover state to set ('auto' or 'manual'). Defaults to 'auto'.
     * @return void
     */
    public function setPopover(string $state): void {
        $this->popover = $state;
    }
     
    /**
     * Gets the CSS classes as a space-separated string.
     *
     * @return string The class attribute as a single string.
     */
    public function getClasses(): string {
    	return $this->hasValue($this->classes) ? ' class="' . implode(' ', $this->classes) . '"' : '';
    }
    
    /**
     * Gets all attributes as a string for HTML.
     *
     * @return string Formatted attributes for HTML output.
     */
    public function getAttributes(): string {
    	$_attr = ($this->hasValue($this->id)			? ' id="' . $this->id . '"'						: '')
    		. ($this->hasValue($this->name)				? ' name="' . $this->name . '"'					: '')
			. ($this->hasValue($this->title)			? ' title="' . $this->title . '"'				: '')
	        . ($this->hasValue($this->hidden)			? ' hidden="hidden"'							: '')
	        . ($this->hasValue($this->autofocus)		? ' autofocus="autofocus"'						: '')
	        . ($this->hasValue($this->tabindex)			? ' tabindex="' . $this->tabindex . '"'			: '')
	        . ($this->hasValue($this->accesskey)		? ' accesskey="' . $this->accesskey . '"'		: '')
	        . ($this->hasValue($this->draggable)		? ' draggable="true"'							: '')
	        . ($this->hasValue($this->disabled)			? ' disabled="disabled"'						: '')
	        . ($this->hasValue($this->inert)			? ' inert="inert"'								: '')
	        . ($this->hasValue($this->contenteditable)	? ' contenteditable="true"'						: '')
	        . ($this->hasValue($this->lang)				? ' lang="' . $this->lang . '"'					: '')
	        . ($this->hasValue($this->popover)			? ' popover="' . $this->popover . '"'			: '')
	        . ($this->hasValue($this->translate)		? ' translate="' . $this->translate . '"'		: '')
	        . ($this->hasValue($this->spellcheck)		? ' spellcheck="true"'							: '')
	        . ($this->hasValue($this->dir)				? ' dir="' . $this->dir . '"'					: '')
	        . ($this->hasValue($this->contextmenu)		? ' contextmenu="' . $this->contextmenu . '"'	: '')
	        . ($this->hasValue($this->style)			? ' style="' . $this->style . '"'				: '');

        foreach ($this->attributes as $_name => $_value) {
        	$_attr .= ' ' . $_name . ($_value ? '="' . $_value . '"' : '');
        }
        
        return $_attr;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for translation states.
 */
class translate {
    public const YES			= "yes";
    public const NO				= "no";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for popover states.
 */
class popover {
    public const AUTO			= "auto";
    public const MANUAL			= "manual";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for text direction values.
 */
class text_direction {
    public const LEFT			= "ltr";
    public const RIGHT			= "rtl";
    public const AUTO			= "auto";
}

//--------------------------------------------------------------------------------------------------------------------------------

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
	public const CODE		= 1 << 17;	// <code> inline code
}

//--------------------------------------------------------------------------------------------------------------------------------

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

/**
 * Class to define constants for form autocomplete values.
 */
class form_autocomplete {
	public const ON				= "on";
	public const OFF			= "off";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form method values.
 */
class form_method {
    public const GET			= "get";
    public const POST			= "post";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form relation values.
 */
class form_rel {
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

/**
 * Class to define constants for form encoding type values.
 */
class form_enctype {
    public const URL			= "application/x-www-form-urlencoded";
    public const FILE			= "multipart/form-data";
    public const TEXT			= "text/plain";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form input type values.
 */
class form_input_type {
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

/**
 * Class to define constants for form button type values.
 */
class form_button_type {
    public const BTN			= "button";
    public const RESET			= "reset";
    public const SUBMIT			= "submit";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form file format values.
 */
class form_file_format {
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

/**
 * Class to define constants for script type values.
 */
class script_type {    
    public const HEADLINK		= 0;
    public const BODYLINK		= 1;
    public const RUNCMD			= 2;
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for textarea wrap mode values.
 */
class textarea_wrapmode {
    public const SOFT			= "soft";
    public const HARD			= "hard";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for list style values.
 */
class list_style {
    public const UNORDERED		= 'ul';
    public const ORDERED		= 'ol';
    public const DESCRIPTION	= 'dl';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for listitem types.
 */
class listitem_type {
    public const ITEM			= 'li';
    public const TERM			= 'dt';
    public const DATA			= 'dd';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for indentation type values.
 */
class indent_type {
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

//--------------------------------------------------------------------------------------------------------------------------------

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