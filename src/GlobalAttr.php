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
     * @param string $state The popover state to set, use popover_state:: constants
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

?>