<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

use TamasVarga\LuandaPHP\Misc\IncidentReporter;

/**
 * Class to handle HTML global event attributes.
 */
abstract class GlobalEvent extends Element {
	protected ?string $onafterprint					= null; // Fires after the document has been printed
	protected ?string $onbeforeprint				= null; // Fires before the document is printed
	protected ?string $onbeforeunload				= null; // Fires before the window unloads
	protected ?string $onerror						= null; // Fires on error
	protected ?string $onhashchange					= null; // Fires when the URL hash changes
	protected ?string $onload						= null; // Fires when the document finishes loading
	protected ?string $onmessage					= null; // Fires on receiving a message event
	protected ?string $onmessageerror				= null; // Fires when message event fails
	protected ?string $onoffline					= null; // Fires when browser goes offline
	protected ?string $ononline						= null; // Fires when browser goes online
	protected ?string $onpagehide					= null; // Fires when page is hidden
	protected ?string $onpageshow					= null; // Fires when page is shown
	protected ?string $onpageswap					= null; // Custom / experimental page swap event
	protected ?string $onpagereveal					= null; // Custom / experimental page reveal
	protected ?string $onpopstate					= null; // Fires when history state changes
	protected ?string $onlanguagechange				= null; // Fires when system language changes
	protected ?string $onresize						= null; // Fires when window is resized
	protected ?string $onstorage					= null; // Fires on localStorage/sessionStorage changes
	protected ?string $onunload						= null; // Fires when window is unloaded
	protected ?string $onrejectionhandled			= null; // Fires on rejected promise handled
	protected ?string $onunhandledrejection			= null; // Fires on unhandled promise rejection
	
	protected ?string $onchange						= null; // Fires when element value changes
	protected ?string $oncontextmenu				= null; // Fires on right-click context menu
	protected ?string $onfocus						= null; // Fires when element receives focus
	protected ?string $onblur						= null; // Fires when element loses focus
	protected ?string $onfocusin					= null; // Fires when element receives focus and bubles
	protected ?string $onfocusout					= null; // Fires when element loses focus and bubles
	protected ?string $oninput						= null; // Fires on user input
	protected ?string $onbeforeinput				= null; // Fires before input changes
	protected ?string $oninvalid					= null; // Fires when form element is invalid
	protected ?string $onreset						= null; // Fires when form is reset
	protected ?string $onformdata					= null; // Fires on form data event
	protected ?string $onsearch						= null; // Fires on search input
	protected ?string $onselect						= null; // Fires when text is selected
	protected ?string $onsubmit						= null; // Fires on form submit
	
	protected ?string $onkeydown					= null; // Fires on key press down
	protected ?string $onkeypress					= null; // Fires on key press
	protected ?string $onkeyup						= null; // Fires on key release
	
	protected ?string $onclick						= null; // Fires on mouse click
	protected ?string $ondblclick					= null; // Fires on mouse double click
	protected ?string $onmousedown					= null; // Fires when mouse button pressed
	protected ?string $onmousemove					= null; // Fires when mouse moves
	protected ?string $onmouseout					= null; // Fires when mouse leaves element
	protected ?string $onmouseover					= null; // Fires when mouse enters element
	protected ?string $onmouseup					= null; // Fires when mouse button released
	protected ?string $onmouseenter					= null; // Fires when mouse enters element, no bubbling
	protected ?string $onmouseleave					= null; // Fires when mouse leaves element, no bubbling
	protected ?string $onauxclick					= null; // Fires on auxiliary button click
	protected ?string $onwheel						= null; // Fires on mouse wheel (standard)
	protected ?string $onmousewheel					= null; // Fires on mouse wheel (deprecated)
	protected ?string $ondrag						= null; // Fires during drag operation
	protected ?string $ondragend					= null; // Fires when drag ends
	protected ?string $ondragenter					= null; // Fires when dragged item enters element
	protected ?string $ondragleave					= null; // Fires when dragged item leaves element
	protected ?string $ondragover					= null; // Fires when dragged item is over element
	protected ?string $ondragstart					= null; // Fires when drag starts
	protected ?string $ondrop						= null; // Fires when item is dropped
	protected ?string $onscroll						= null; // Fires on scrolling
	protected ?string $onscrollend					= null; // Fires when scrolling ends
	
	protected ?string $oncopy						= null; // Fires on copy
	protected ?string $oncut						= null; // Fires on cut
	protected ?string $onpaste						= null; // Fires on paste
	
	protected ?string $ondurationchange				= null; // Media duration changed
	protected ?string $onemptied					= null; // Media emptied
	protected ?string $onended						= null; // Media ended
	protected ?string $onloadeddata					= null; // Media data loaded
	protected ?string $onloadedmetadata				= null; // Media metadata loaded
	protected ?string $onloadstart					= null; // Media load started
	protected ?string $onpause						= null; // Media paused
	protected ?string $onplay						= null; // Media started playing
	protected ?string $onplaying					= null; // Media playing
	protected ?string $onprogress					= null; // Media progress
	protected ?string $onratechange					= null; // Media rate changed
	protected ?string $onseeked						= null; // Media seeked
	protected ?string $onseeking					= null; // Media seeking
	protected ?string $onstalled					= null; // Media stalled
	protected ?string $onsuspend					= null; // Media suspended
	protected ?string $ontimeupdate					= null; // Media time updated
	protected ?string $onvolumechange				= null; // Media volume changed
	protected ?string $onwaiting					= null; // Media waiting
	protected ?string $onabort						= null; // Media aborted
	protected ?string $oncanplay					= null; // Media can play
	protected ?string $oncanplaythrough				= null; // Media can play through
	protected ?string $oncuechange					= null; // Media cue change
	
	protected ?string $ontoggle						= null; // Misc toggle event
	protected ?string $onbeforematch				= null; // Misc before match event
	protected ?string $onbeforetoggle				= null; // Misc before toggle event
	protected ?string $oncancel						= null; // Misc cancel event
	protected ?string $onclose						= null; // Misc close event
	protected ?string $oncommand					= null; // Misc command event
	protected ?string $oncontextlost				= null; // Misc context lost
	protected ?string $oncontextrestored			= null; // Misc context restored
	protected ?string $onreadystatechange			= null; // Misc ready state change
	protected ?string $onsecuritypolicyviolation	= null; // Misc security policy violation
	protected ?string $onslotchange					= null; // Misc slot change
	protected ?string $onvisibilitychange			= null; // Misc visibility change
	
	protected ?string $onwebkitanimationend			= null; // WebKit animation end
	protected ?string $onwebkitanimationiteration	= null; // WebKit animation iteration
	protected ?string $onwebkitanimationstart		= null; // WebKit animation start
	protected ?string $onwebkittransitionend		= null; // WebKit transition end
	
	protected ?string $onpointerover				= null; // Fires when pointer is over element
	protected ?string $onpointerenter				= null; // Fires when pointer enters element
	protected ?string $onpointerdown				= null; // Fires when pointer button is pressed
	protected ?string $onpointermove				= null; // Fires when pointer moves
	protected ?string $onpointerup					= null; // Fires when pointer button is released
	protected ?string $onpointercancel				= null; // Fires when pointer event is canceled
	protected ?string $onpointerout					= null; // Fires when pointer leaves element
	protected ?string $onpointerleave				= null; // Fires when pointer leaves element, no bubbling
	protected ?string $ongotpointercapture			= null; // Fires when element set as pointer capture
	protected ?string $onlostpointercapture			= null; // Fires when pointer capture is released
	
	protected ?string $ontouchstart					= null; // Fires when touch starts
	protected ?string $ontouchend					= null; // Fires when touch ends
	protected ?string $ontouchmove					= null; // Fires when touch moves
	protected ?string $ontouchcancel				= null; // Fires when touch is interrupted
	
	protected ?string $onanimationcancel			= null; // Fired when an animation is canceled
	protected ?string $onanimationstart				= null; // Fired when an animation starts
	protected ?string $onanimationend				= null; // Fired when an animation ends
	protected ?string $onanimationiteration			= null; // Fired when an animation iteration completes
	
	/**
	 * Sets the specified event attribute.
	 *
	 * @param string $event The name of the event attribute, e.g., form_events::CHANGE
	 * @param string $script The JavaScript code to assign to the event
	 * @return void
	 */
	public function addEvent(string $event, string $script): void {
		if (property_exists($this, $event)) {
			$this->$event
			? (IncidentReporter::isAvailable() ? IncidentReporter::report('GlobalEvents', 'Duplicate event ' . $event . '!') : '')
			: $this->$event = $script;
		} else {
			IncidentReporter::isAvailable() ? IncidentReporter::report('GlobalEvents', 'Unavailable event ' . $event . '!') : '';
		}
	}
	
	/**
	 * Gets all the event attributes as a string for HTML.
	 *
	 * @return string Formatted event attributes for HTML output
	 */
	public function getEvents(): string {
		$_events = '';
		$_classVars = array_keys(get_class_vars(self::class));
		
		foreach ($_classVars as $_property)
			if ($this->hasValue($this->$_property))
				$_events .= ' ' . $_property . '="' . $this->$_property . '"';
				
		return $_events;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for focus-related events.
 * Covers focus state transitions on elements.
 */
class focus_events {
	public const FOCUS        = 'onfocus';
	public const BLUR         = 'onblur';
	public const FOCUSIN      = 'onfocusin';
	public const FOCUSOUT     = 'onfocusout';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for mouse events.
 * Covers physical mouse interactions and movement.
 */
class mouse_events {
	public const CLICK        = 'onclick';
	public const DBLCLICK     = 'ondblclick';
	public const DOWN         = 'onmousedown';
	public const UP           = 'onmouseup';
	public const MOVE         = 'onmousemove';
	public const ENTER        = 'onmouseenter';
	public const LEAVE        = 'onmouseleave';
	public const OVER         = 'onmouseover';
	public const OUT          = 'onmouseout';
	public const CONTEXT      = 'oncontextmenu';
	public const AUXCLICK     = 'onauxclick';
	public const WHEEL        = 'onwheel';
	public const SCROLL       = 'onscroll';
	public const SCROLLEND    = 'onscrollend';
	
	// legacy
	public const MOUSEWHEEL   = 'onmousewheel';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for pointer events.
 * Covers unified input handling (mouse, touch, pen).
 */
class pointer_events {
	public const DOWN         = 'onpointerdown';
	public const UP           = 'onpointerup';
	public const MOVE         = 'onpointermove';
	public const ENTER        = 'onpointerenter';
	public const LEAVE        = 'onpointerleave';
	public const OVER         = 'onpointerover';
	public const OUT          = 'onpointerout';
	public const CANCEL       = 'onpointercancel';
	public const GOTCAPTURE   = 'ongotpointercapture';
	public const LOSTCAPTURE  = 'onlostpointercapture';
	
	// convenience
	public const CLICK        = 'onclick';
	public const DBLCLICK     = 'ondblclick';
	public const CONTEXT      = 'oncontextmenu';
	public const SCROLL       = 'onscroll';
	public const SCROLLEND    = 'onscrollend';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for keyboard events.
 * Covers key press lifecycle.
 */
class keyboard_events {
	public const DOWN         = 'onkeydown';
	public const UP           = 'onkeyup';
	public const PRESS        = 'onkeypress'; // deprecated
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for input and form events.
 * Covers data entry and form lifecycle.
 */
class input_events {
	public const INPUT        = 'oninput';
	public const BEFOREINPUT  = 'onbeforeinput';
	public const CHANGE       = 'onchange';
	public const INVALID      = 'oninvalid';
	public const SUBMIT       = 'onsubmit';
	public const RESET        = 'onreset';
	public const SELECT       = 'onselect';
	public const SEARCH       = 'onsearch';
	public const FORMDATA     = 'onformdata';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for clipboard events.
 * Covers copy, cut, and paste operations.
 */
class clipboard_events {
	public const COPY         = 'oncopy';
	public const CUT          = 'oncut';
	public const PASTE        = 'onpaste';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for drag and drop events.
 * Covers drag lifecycle independent of mouse implementation.
 */
class drag_events {
	public const START        = 'ondragstart';
	public const DRAG         = 'ondrag';
	public const ENTER        = 'ondragenter';
	public const OVER         = 'ondragover';
	public const LEAVE        = 'ondragleave';
	public const DROP         = 'ondrop';
	public const END          = 'ondragend';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for touch events.
 * Covers touch interactions.
 */
class touch_events {
	public const START        = 'ontouchstart';
	public const END          = 'ontouchend';
	public const MOVE         = 'ontouchmove';
	public const CANCEL       = 'ontouchcancel';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for animation and transition events.
 * Covers CSS animation lifecycle.
 */
class animation_events {
	public const START        = 'onanimationstart';
	public const END          = 'onanimationend';
	public const ITERATION    = 'onanimationiteration';
	public const CANCEL       = 'onanimationcancel';
	
	// legacy WebKit
	public const WEBKIT_START = 'onwebkitanimationstart';
	public const WEBKIT_END   = 'onwebkitanimationend';
	public const WEBKIT_ITER  = 'onwebkitanimationiteration';
	public const WEBKIT_TRANS = 'onwebkittransitionend';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for window and document events.
 * Covers lifecycle, navigation, connectivity, and global state.
 */
class window_events {
	public const AFTERPRINT          = 'onafterprint';
	public const BEFOREPRINT         = 'onbeforeprint';
	public const BEFOREUNLOAD        = 'onbeforeunload';
	public const LOAD                = 'onload';
	public const UNLOAD              = 'onunload';
	
	public const PAGEHIDE            = 'onpagehide';
	public const PAGESHOW            = 'onpageshow';
	public const PAGESWAP            = 'onpageswap';
	public const PAGEREVEAL          = 'onpagereveal';
	
	public const RESIZE              = 'onresize';
	public const SCROLL              = 'onscroll';
	public const SCROLLEND           = 'onscrollend';
	
	public const HASHCHANGE          = 'onhashchange';
	public const POPSTATE            = 'onpopstate';
	
	public const ONLINE              = 'ononline';
	public const OFFLINE             = 'onoffline';
	
	public const ERROR               = 'onerror';
	
	public const MESSAGE             = 'onmessage';
	public const MESSAGEERROR        = 'onmessageerror';
	
	public const STORAGE             = 'onstorage';
	public const VISIBILITYCHANGE    = 'onvisibilitychange';
	public const LANGUAGECHANGE      = 'onlanguagechange';
	
	public const REJECTIONHANDLED    = 'onrejectionhandled';
	public const UNHANDLEDREJECTION  = 'onunhandledrejection';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for media events.
 * Covers playback lifecycle, buffering, and state changes.
 */
class media_events {
	public const ABORT            = 'onabort';
	public const CANPLAY          = 'oncanplay';
	public const CANPLAYTHROUGH   = 'oncanplaythrough';
	public const CUECHANGE        = 'oncuechange';
	public const DURATIONCHANGE   = 'ondurationchange';
	public const EMPTIED          = 'onemptied';
	public const ENDED            = 'onended';
	
	public const ERROR            = 'onerror';
	
	public const LOADEDDATA       = 'onloadeddata';
	public const LOADEDMETADATA   = 'onloadedmetadata';
	public const LOADSTART        = 'onloadstart';
	
	public const PAUSE            = 'onpause';
	public const PLAY             = 'onplay';
	public const PLAYING          = 'onplaying';
	
	public const PROGRESS         = 'onprogress';
	public const RATECHANGE       = 'onratechange';
	
	public const SEEKED           = 'onseeked';
	public const SEEKING          = 'onseeking';
	
	public const STALLED          = 'onstalled';
	public const SUSPEND          = 'onsuspend';
	
	public const TIMEUPDATE       = 'ontimeupdate';
	public const VOLUMECHANGE     = 'onvolumechange';
	public const WAITING          = 'onwaiting';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for miscellaneous DOM events.
 * Covers less common and experimental events.
 */
class misc_events {
	public const TOGGLE                       = 'ontoggle';
	public const BEFOREMATCH                  = 'onbeforematch';
	public const BEFORETOGGLE                 = 'onbeforetoggle';
	public const CANCEL                       = 'oncancel';
	public const CLOSE                        = 'onclose';
	public const COMMAND                      = 'oncommand';
	public const CONTEXTLOST                  = 'oncontextlost';
	public const CONTEXTRESTORED              = 'oncontextrestored';
	public const READYSTATE                   = 'onreadystatechange';
	public const SECPOLVIOL                   = 'onsecuritypolicyviolation';
	public const SLOTCHANGE                   = 'onslotchange';
	public const VISIBILITYCHANGE             = 'onvisibilitychange';
}

?>