<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a Font Awesome icon with various options.
 */
class Faicon extends Node {
	protected ?string $anim			= null;
	protected ?string $rotation		= null;
	protected ?string $size			= null;
	protected string $type			= icon_type::SOLID;
	protected string $icon			= 'info';
	
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
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$this->addClass($this->type . ' ' . 'fa-' . $this->icon
			. ($this->hasValue($this->rotation)		? ' ' . $this->rotation		: '')
			. ($this->hasValue($this->anim)			? ' ' . $this->anim			: '')
			. ($this->hasValue($this->size)			? ' ' . $this->size			: ''));
		
		$_html = Element::getNewlineString()
			. $_indent . '<i'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '></i>';
			
		return $_html;
	}
}

?>