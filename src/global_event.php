<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class to handle HTML global event attributes.
 */
class global_event {
    protected ?string $onafterprint = null;
    protected ?string $onbeforeprint = null;
    protected ?string $onbeforeunload = null;
    protected ?string $onerror = null;
    protected ?string $onhashchange = null;
    protected ?string $onload = null;
    protected ?string $onmessage = null;
    protected ?string $onoffline = null;
    protected ?string $ononline = null;
    protected ?string $onpagehide = null;
    protected ?string $onpageshow = null;
    protected ?string $onpopstate = null;
    protected ?string $onresize = null;
    protected ?string $onstorage = null;
    protected ?string $onunload = null;
    protected ?string $onblur = null;
    protected ?string $onchange = null;
    protected ?string $oncontextmenu = null;
    protected ?string $onfocus = null;
    protected ?string $oninput = null;
    protected ?string $oninvalid = null;
    protected ?string $onreset = null;
    protected ?string $onsearch = null;
    protected ?string $onselect = null;
    protected ?string $onsubmit = null;
    protected ?string $onkeydown = null;
    protected ?string $onkeypress = null;
    protected ?string $onkeyup = null;
    protected ?string $onclick = null;
    protected ?string $ondblclick = null;
    protected ?string $onmousedown = null;
    protected ?string $onmousemove = null;
    protected ?string $onmouseout = null;
    protected ?string $onmouseover = null;
    protected ?string $onmouseup = null;
    protected ?string $onmousewheel = null;
    protected ?string $ondrag = null;
    protected ?string $ondragend = null;
    protected ?string $ondragenter = null;
    protected ?string $ondragleave = null;
    protected ?string $ondragover = null;
    protected ?string $ondragstart = null;
    protected ?string $ondrop = null;
    protected ?string $onscroll = null;
    protected ?string $oncopy = null;
    protected ?string $oncut = null;
    protected ?string $onpaste = null;
    protected ?string $ondurationchange = null;
    protected ?string $onemptied = null;
    protected ?string $onended = null;
    protected ?string $onloadeddata = null;
    protected ?string $onloadedmetadata = null;
    protected ?string $onloadstart = null;
    protected ?string $onpause = null;
    protected ?string $onplay = null;
    protected ?string $onplaying = null;
    protected ?string $onprogress = null;
    protected ?string $onratechange = null;
    protected ?string $onseeked = null;
    protected ?string $onseeking = null;
    protected ?string $onstalled = null;
    protected ?string $onsuspend = null;
    protected ?string $ontimeupdate = null;
    protected ?string $onvolumechange = null;
    protected ?string $onwaiting = null;
    
    /**
     * Sets the specified event attribute.
     *
     * @param string $event The name of the event attribute.
     * for example form_events::CHANGE or mouse_events::CLICK
     * @param string $script The JavaScript code to assign to the event.
     */
    public function addEvent(string $event, string $script): void {
        if (property_exists($this, $event)) {
            $this->$event = $script;
        } else {
            throw new \InvalidArgumentException("Event $event does not exist.");
        }
    }
    
    /**
     * Gets all the event attributes as a formatted string for use in HTML tags.
     *
     * @return string A string containing all event attributes.
     */
    public function getEvents(): string {
        $events = "";
        $classVars = array_keys(get_class_vars(static::class));
        
        foreach ($classVars as $property) {
            if (strpos($property, 'on') === 0 && $this->$property !== null) {
                $events .= " $property=\"{$this->$property}\"";
            }
        }
        
        return $events;
    }
}

/**
 * Class to define constants for various window events.
 */
class window_events {
    public const AFTERPRINT = "onafterprint";
    public const BEFOREPRINT = "onbeforeprint";
    public const BEFOREUNLOAD = "onbeforeunload";
    public const ERROR = "onerror";
    public const HASHCHG = "onhashchange";
    public const LOAD = "onload";
    public const MSG = "onmessage";
    public const OFFLINE = "onoffline";
    public const ONLINE = "ononline";
    public const HIDE = "onpagehide";
    public const SHOW = "onpageshow";
    public const POPSTATE = "onpopstate";
    public const RESIZE = "onresize";
    public const STORAGE = "onstorage";
    public const UNLOAD = "onunload";
}

/**
 * Class to define constants for various form events.
 */
class form_events {
    public const BLUR = "onblur";
    public const CHANGE = "onchange";
    public const CONTEXT = "oncontextmenu";
    public const FOCUS = "onfocus";
    public const INPUT = "oninput";
    public const INVALID = "oninvalid";
    public const RESET = "onreset";
    public const SEARCH = "onsearch";
    public const SELECT = "onselect";
    public const SUBMIT = "onsubmit";
}

/**
 * Class to define constants for various keyboard events.
 */
class kb_events {
    public const DOWN = "onkeydown";
    public const PRESS = "onkeypress";
    public const UP = "onkeyup";
}

/**
 * Class to define constants for various mouse events.
 */
class mouse_events {
    public const CLICK = "onclick";
    public const DBLCLICK = "ondblclick";
    public const BTNDOWN = "onmousedown";
    public const MOVE = "onmousemove";
    public const OUT = "onmouseout";
    public const OVER = "onmouseover";
    public const BTNUP = "onmouseup";
    public const WHEEL = "onwheel";
}

/**
 * Class to define constants for various drag events.
 */
class drag_events {
    public const DRAG = "ondrag";
    public const END = "ondragend";
    public const ENTER = "ondragenter";
    public const LEAVE = "ondragleave";
    public const OVER = "ondragover";
    public const START = "ondragstart";
    public const DROP = "ondrop";
    public const SCROLL = "onscroll";
}

/**
 * Class to define constants for various clipboard events.
 */
class clipbrd_events {
    public const COPY = "oncopy";
    public const CUT = "oncut";
    public const PASTE = "onpaste";
}

/**
 * Class to define constants for various media events.
 */
class media_events {
    public const ABORT = "onabort";
    public const CANPLAY = "oncanplay";
    public const CANPLYTHRG = "oncanplaythrough";
    public const CUECHNG = "oncuechange";
    public const DURCHNG = "ondurationchange";
    public const EMPTIED = "onemptied";
    public const ENDED = "onended";
    public const ERROR = "onerror";
    public const LOADED = "onloadeddata";
    public const META = "onloadedmetadata";
    public const LOADSTART = "onloadstart";
    public const PAUSE = "onpause";
    public const PLAY = "onplay";
    public const PLAYING = "onplaying";
    public const PROGRESS = "onprogress";
    public const RATECHNG = "onratechange";
    public const SEEKEND = "onseeked";
    public const SEEKING = "onseeking";
    public const STALLED = "onstalled";
    public const SUSPEND = "onsuspend";
    public const UPDATE = "ontimeupdate";
    public const VOLUME = "onvolumechange";
    public const WAITING = "onwaiting";
}

/**
 * Class to define constants for miscellaneous events.
 */
class misc_events {
    public const TOGGLE = "ontoggle";
}
?>