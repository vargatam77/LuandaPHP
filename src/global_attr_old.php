<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class to handle HTML global attributes, extending the global_event class.
 */
class global_attr_old extends global_event {
    // Properties for storing various global HTML attributes
    protected $id = null;
    protected $title = null;
    protected $classes = array();
    protected $hidden = null;
    protected $tabindex = null;
    protected $accesskey = null;
    protected $draggable = null;
    protected $contenteditable = null;
    protected $lang = null;
    protected $translate = null;
    protected $spellcheck = null;
    protected $dir = null;
    protected $attributes = array();
    protected $name = null;
    
    /**
     * Sets the ID attribute.
     *
     * @param string $id The ID to set.
     */
    function setId($id) {
        $this->id = $id;
    }
    
    /**
     * Gets the ID attribute.
     *
     * @return string|null The current ID.
     */
    function getId() {
        return $this->id;
    }
    
    /**
     * Adds a custom attribute.
     *
     * @param string $name The name of the attribute.
     * @param string $value The value of the attribute.
     */
    function addAttr($name, $value) {
        $this->attributes[$name] = $value;
    }
    
    /**
     * Sets the title attribute.
     *
     * @param string $title The title to set.
     */
    function setTitle($title) {
        $this->title = $title;
    }
    
    /**
     * Hides the element by setting the hidden attribute.
     */
    function hide() {
        $this->hidden = true;
    }
    
    /**
     * Checks if the element is hidden.
     *
     * @return bool True if the element is hidden, false otherwise.
     */
    function isHidden() {
        return $this->hidden;
    }
    
    /**
     * Sets the tabindex attribute.
     *
     * @param int $tabindex The tabindex to set.
     */
    function setTabindex($tabindex) {
        $this->tabindex = $tabindex;
    }
    
    /**
     * Sets the name attribute.
     *
     * @param string $name The name to set.
     */
    function setName($name) {
        $this->name = $name;
    }
    
    /**
     * Sets the accesskey attribute.
     *
     * @param string $accesskey The access key to set.
     */
    function setAccesskey($accesskey) {
        $this->accesskey = $accesskey;
    }
    
    /**
     * Makes the element draggable by setting the draggable attribute.
     */
    function setDraggable() {
        $this->draggable = true;
    }
    
    /**
     * Sets the contenteditable attribute.
     *
     * @param bool $editable Whether the element should be editable. Defaults to true.
     */
    function setEditable($editable = true) {
        $this->contenteditable = $editable;
    }
    
    /**
     * Sets the lang attribute.
     *
     * @param string $language The language code to set.
     */
    function setLanguage($language) {
        $this->lang = $language;
    }
    
    /**
     * Sets the translate attribute.
     *
     * @param string $translate The value for the translate attribute. Defaults to "yes".
     */
    function toTranslate($translate = "yes") {
        $this->translate = $translate;
    }
    
    /**
     * Sets the spellcheck attribute.
     *
     * @param bool $spellcheck Whether spellcheck should be enabled. Defaults to true.
     */
    function toSpellcheck($spellcheck = true) {
        $this->spellcheck = $spellcheck;
    }
    
    /**
     * Adds a CSS class to the element.
     *
     * @param string $class The class to add.
     */
    function addClass($class) {
        array_push($this->classes, $class);
    }
    
    /**
     * Gets the CSS classes as a space-separated string.
     *
     * @return string The classes as a single string.
     */
    function getClasses() {
        return implode(' ', $this->classes);
    }
    
    /**
     * Gets all the attributes as a formatted string for use in HTML tags.
     *
     * @return string A string containing all attributes.
     */
    function getAttributes() {
        $attributes =
        (($this->id) ? " id='" . $this->id . "'" : "")
        . (($this->title) ? " title='" . $this->title . "'" : "")
        . (($this->hidden) ? " hidden='hidden'" : "")
        . (($this->tabindex) ? " tabindex='" . $this->tabindex . "'" : "")
        . (($this->name) ? " name='" . $this->name . "'" : "")
        . (($this->accesskey) ? " accesskey='" . $this->accesskey . "'" : "")
        . (($this->draggable) ? " draggable='" . $this->draggable . "'" : "")
        . (($this->contenteditable) ? " contenteditable='" . $this->contenteditable . "'" : "")
        . (($this->lang) ? " lang='" . $this->lang . "'" : "")
        . (($this->translate) ? " translate='" . $this->translate . "'" : "")
        . (($this->spellcheck) ? " spellcheck='" . $this->spellcheck . "'" : "")
        . (($this->dir) ? " dir='" . $this->dir . "'" : "");
        
        if ($this->attributes) {
            foreach ($this->attributes as $name => $value) {
                $attributes .= " " . $name
                . (($value) ? "='" . $value . "'" : "");
            }
        }
        
        if ($this->classes) {
            $attributes .= " class='" . $this->getClasses() . "'";
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
    public static function getClone($object) {
        return unserialize(serialize($object));
    }
}
?>