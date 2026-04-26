<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a Font Awesome icon with various options.
 */
class Faicon extends Node {
	protected ?string $anim = null;
	protected ?string $rotation = null;
	protected ?string $size = null;
	protected string $type = icon_type::SOLID;
	protected string $icon = 'info';
	
	/**
	 * Constructor for the Faicon class.
	 *
	 * @param string $icon The name of the Font Awesome icon, without the fa- prefix.
	 * @param string $icontype The type of the Font Awesome icon, use icon_type:: constants.
	 */
	public function __construct(string $icon, string $icontype = icon_type::SOLID) {
		$this->icon = $icon;
		$this->type = $icontype;
	}
	
	/**
	 * Set the rotation class for the icon.
	 *
	 * @param string $iconRotation The rotation class, use icon_rotation:: constants.
	 * @return void
	 */
	public function setRotation(string $iconRotation): void {
		$this->rotation = $iconRotation;
	}
	
	/**
	 * Set the size class for the icon.
	 *
	 * @param string $iconSize The size class, use icon_size:: constants.
	 * @return void
	 */
	public function setSize(string $iconSize): void {
		$this->size = $iconSize;
	}
	
	/**
	 * Set the type of the Font Awesome icon.
	 *
	 * @param string $iconType The type of icon, use icon_type:: constants.
	 * @return void
	 */
	public function setType(string $iconType): void {
		$this->type = $iconType;
	}
	
	/**
	 * Set the animation class for the icon.
	 *
	 * @param string $iconAnim The animation class, use icon_anim:: constants.
	 * @return void
	 */
	public function setAnim(string $iconAnim): void {
		$this->anim = $iconAnim;
	}
	
	/**
	 * Generate the HTML representation of the Font Awesome icon.
	 *
	 * @return string The HTML representation of the icon.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$this->addClass($this->type . ' ' . 'fa-' . $this->icon
			. ($this->hasValue($this->rotation) ? ' ' . $this->rotation : '')
			. ($this->hasValue($this->anim)     ? ' ' . $this->anim     : '')
			. ($this->hasValue($this->size)     ? ' ' . $this->size     : ''));
		
		$_html = special_chars::NEWLINE
			. $_indent . '<i'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '></i>';
			
		return $_html;
	}
}

/**
 * Constants representing different types of Font Awesome icons.
 */
class icon_type {
	public const SOLID   = 'fa-solid';
	public const REGULAR = 'fa-regular';
	public const LIGHT   = 'fa-light';
	public const DUO     = 'fa-duotone';
	public const THIN    = 'fa-thin';
	public const BRAND   = 'fa-brands';
}

/**
 * Constants representing different animations for Font Awesome icons.
 */
class icon_anim {
	public const BEAT      = 'fa-beat';
	public const BEATFADE  = 'fa-beat-fade';
	public const BOUNCE    = 'fa-bounce';
	public const FADE      = 'fa-fade';
	public const FLIP      = 'fa-flip';
	public const SHAKE     = 'fa-shake';
	public const SPIN      = 'fa-spin';
	public const REVERSE   = 'fa-spin fa-spin-reverse';
	public const PULSE     = 'fa-spin fa-spin-pulse';
}

/**
 * Constants representing different rotations for Font Awesome icons.
 */
class icon_rotation {
	public const ROT90  = 'fa-rotate-90';
	public const ROT180 = 'fa-rotate-180';
	public const ROT270 = 'fa-rotate-270';
	public const HFLIP  = 'fa-flip-horizontal';
	public const VFLIP  = 'fa-flip-vertical';
	public const HVFLIP = 'fa-flip-both';
}

/**
 * Constants representing different sizes for Font Awesome icons.
 */
class icon_size {
	public const XXS = 'fa-2xs';
	public const XS  = 'fa-xs';
	public const SM  = 'fa-sm';
	public const LG  = 'fa-lg';
	public const XL  = 'fa-xl';
	public const XXL = 'fa-2xl';
}

?>