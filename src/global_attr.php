<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class to handle HTML global attributes, extending the global_event class.
 */
class global_attr extends global_event {
    protected ?string $id = null;
    protected ?string $title = null;
    protected array $classes = [];
    protected ?bool $hidden = null;
    protected ?int $tabindex = null;
    protected ?string $accesskey = null;
    protected ?bool $draggable = null;
    protected ?bool $contenteditable = null;
    protected ?string $lang = null;
    protected ?string $translate = null;
    protected ?bool $spellcheck = null;
    protected ?string $dir = null;
    protected array $attributes = [];
    protected ?string $name = null;

    /**
     * Sets the ID attribute.
     *
     * @param string $id The ID to set.
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
     */
    public function addAttr(string $name, string $value): void {
        $this->attributes[$name] = $value;
    }

    /**
     * Sets the title attribute.
     *
     * @param string $title The title to set.
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Hides the element by setting the hidden attribute.
     */
    public function hide(): void {
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
     * Sets the tabindex attribute.
     *
     * @param int $tabindex The tabindex to set.
     */
    public function setTabindex(int $tabindex): void {
        $this->tabindex = $tabindex;
    }

    /**
     * Sets the name attribute.
     *
     * @param string $name The name to set.
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * Sets the accesskey attribute.
     *
     * @param string $accesskey The access key to set.
     */
    public function setAccesskey(string $accesskey): void {
        $this->accesskey = $accesskey;
    }

    /**
     * Makes the element draggable by setting the draggable attribute.
     */
    public function setDraggable(): void {
        $this->draggable = true;
    }

    /**
     * Sets the contenteditable attribute.
     *
     * @param bool $editable Whether the element should be editable. Defaults to true.
     */
    public function setEditable(bool $editable = true): void {
        $this->contenteditable = $editable;
    }

    /**
     * Sets the lang attribute.
     *
     * @param string $language The language code to set.
     */
    public function setLanguage(string $language): void {
        $this->lang = $language;
    }

    /**
     * Sets the translate attribute.
     *
     * @param string $translate The value for the translate attribute. Defaults to "yes".
     */
    public function toTranslate(string $translate = "yes"): void {
        $this->translate = $translate;
    }

    /**
     * Sets the spellcheck attribute.
     *
     * @param bool $spellcheck Whether spellcheck should be enabled. Defaults to true.
     */
    public function toSpellcheck(bool $spellcheck = true): void {
        $this->spellcheck = $spellcheck;
    }

    /**
     * Adds a CSS class to the element.
     *
     * @param string $class The class to add.
     */
    public function addClass(string $class): void {
        $this->classes[] = $class;
    }

    /**
     * Gets the CSS classes as a space-separated string.
     *
     * @return string The classes as a single string.
     */
    public function getClasses(): string {
        return " " . implode(' ', $this->classes);
    }

    /**
     * Gets all the attributes as a formatted string for use in HTML tags.
     *
     * @return string A string containing all attributes.
     */
    public function getAttributes(): string {
        $attributes = 
            ($this->id ? " id='{$this->id}'" : "")
            . ($this->title ? " title='{$this->title}'" : "")
            . ($this->hidden ? " hidden='hidden'" : "")
            . ($this->tabindex ? " tabindex='{$this->tabindex}'" : "")
            . ($this->name ? " name='{$this->name}'" : "")
            . ($this->accesskey ? " accesskey='{$this->accesskey}'" : "")
            . ($this->draggable ? " draggable='{$this->draggable}'" : "")
            . ($this->contenteditable ? " contenteditable='{$this->contenteditable}'" : "")
            . ($this->lang ? " lang='{$this->lang}'" : "")
            . ($this->translate ? " translate='{$this->translate}'" : "")
            . ($this->spellcheck ? " spellcheck='{$this->spellcheck}'" : "")
            . ($this->dir ? " dir='{$this->dir}'" : "");

        foreach ($this->attributes as $name => $value) {
            $attributes .= " $name" . ($value ? "='$value'" : "");
        }

        if ($this->classes) {
            $attributes .= " class='{$this->getClasses()}'";
        }

        $attributes .= $this->getEvents();

        return $attributes;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for link target values.
 */
class link_target {
    public const NEWPAGE = "_blank";
    public const SAMEPAGE = "_self";
    public const PARENTPAGE = "_parent";
    public const TOP = "_top";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for character set values.
 */
class charset {
    public const UTF8 = "UTF-8";
    public const UTF16 = "UTF-16";
    public const WIN1252 = "Windows-1252";
    public const ISO8859 = "ISO-8859";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form method values.
 */
class form_method {
    public const GET = "get";
    public const POST = "post";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form relation values.
 */
class form_rel {
    public const EXT = "external";
    public const HELP = "help";
    public const LICENSE = "license";
    public const NEXT = "next";
    public const NOFOLLOW = "nofollow";
    public const NOOPENER = "noopener";
    public const NOREF = "noreferrer";
    public const PREV = "prev";
    public const SEARCH = "search";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form encoding type values.
 */
class form_enctype {
    public const URL = "application/x-www-form-urlencoded";
    public const FILE = "multipart/form-data";
    public const TEXT = "text/plain";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form input type values.
 */
class form_input_type {
    public const BTN = "button";
    public const CHKBOX = "checkbox";
    public const COLORPICKER = "color";
    public const DATE = "date";
    public const LCLDATE = "datetime-local";
    public const EMAIL = "email";
    public const FILE = "file";
    public const HIDDEN = "hidden";
    public const IMG = "image";
    public const MONTH = "month";
    public const NUM = "number";
    public const PWD = "password";
    public const RADIOBTN = "radio";
    public const RANGE = "range";
    public const RESET = "reset";
    public const SEARCH = "search";
    public const SUBMIT = "submit";
    public const TEL = "tel";
    public const TEXT = "text";
    public const TIME = "time";
    public const URL = "url";
    public const WEEK = "week";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form button type values.
 */
class form_button_type {
    public const BTN = "button";
    public const RESET = "reset";
    public const SUBMIT = "submit";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for form file format values.
 */
class form_file_format {
    public const ANY = ".*";
    public const AUDIO = "audio/*";
    public const VIDEO = "video/*";
    public const IMAGE = "image/*";
    public const PDF = ".pdf, application/pdf";
    public const MSDOC = ".doc, .docx, application/msword";
    public const XML = ".xml, text/xml, application/xml";
    public const HTML = ".htm, .html, text/html";
    public const SQL = ".sql";
    public const ZIP = ".zip, application/zip";
    public const JSON = ".json, text/json, application/json";
    public const JSCRIPT = ".js, text/javascript, text/jscript";
    public const CAMERA = "capture=camera";
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for script type values.
 */
class script_type {    
    public const HEADLINK = 0;
    public const BODYLINK = 1;
    public const RUNCMD = 2;
}

/**
 * Class to define constants for textarea wrap mode values.
 */
class textarea_wrapmode {
    public const SOFT = "soft";
    public const HARD = "hard";
}

/**
 * Class to define constants for list style values.
 */
class list_style {
    public const UNORDERED = 0;
    public const ORDERED = 1;
    public const DESCRIPTION = 2;
}

/**
 * Class to define constants for indentation type values.
 */
class indent_type {
    public const TAB = "\t";
    public const SPACE = " ";
    public const DBLSPACE = "  ";
    public const TRISPACE = "   ";
    public const QUADSPACE = "    ";
}

/**
 * Utility class to clone objects.
 */
class Cloner {
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