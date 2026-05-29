<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

use TamasVarga\LuandaPHP\GlobalEvent;
use TamasVarga\LuandaPHP\translate;

/**
 * Class to handle HTML global attributes, extending the global event class.
 */
abstract class SvgAttr extends GlobalEvent {
	protected array $classes				= []; // CSS classes
	protected array $attributes				= []; // Custom attributes
	protected ?string $id					= null; // ID attribute
	protected ?int $tabindex				= null; // Tab index
	protected ?bool $draggable				= null; // Draggable flag
	protected ?string $lang					= null; // Language
	protected ?string $translate			= null; // Translate attribute
	protected ?string $dir					= null; // Text direction
	protected bool $pointerevents			= true; // Catching pointer events
	protected ?string $style				= null; // Inline CSS style
	protected ?string $width				= null;
	protected ?string $height				= null;
	protected ?string $preserveAspectRatio	= null;
	protected ?string $top					= null;
	protected ?string $left					= null;
	protected ?string $display				= null;
	protected ?string $visibility			= null;
	protected ?string $opacity				= null;
	protected ?string $overflow				= null;
	protected ?string $title				= null;
	protected ?string $desc					= null;
	
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
	 * Sets the title.
	 *
	 * @param string $title The title to set.
	 * @return void
	 */
	public function setTitle(string $title): void {
		$this->title = $this->safeHtml($title);
	}
	
	/**
	 * Sets the description.
	 *
	 * @param string $desc The description of the svg
	 * @return void
	 */
	public function setDescription(string $desc): void {
		$this->desc = $this->safeHtml($desc);
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
	 * Makes the element draggable.
	 *
	 * @return void
	 */
	public function setDraggable(): void {
		$this->draggable = true;
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
		$_attr = ($this->hasValue($this->id)		? ' id="' . $this->id . '"'						: '')
		. ($this->hasValue($this->tabindex)			? ' tabindex="' . $this->tabindex . '"'			: '')
		. ($this->hasValue($this->draggable)		? ' draggable="true"'							: '')
		. ($this->hasValue($this->lang)				? ' lang="' . $this->lang . '"'					: '')
		. ($this->hasValue($this->translate)		? ' translate="' . $this->translate . '"'		: '')
		. ($this->hasValue($this->dir)				? ' dir="' . $this->dir . '"'					: '')
		. ($this->hasValue($this->style)			? ' style="' . $this->style . '"'				: '');
		
		foreach ($this->attributes as $_name => $_value) {
			$_attr .= ' ' . $_name . ($_value ? '="' . $_value . '"' : '');
		}
		
		return $_attr;
	}
}

?>