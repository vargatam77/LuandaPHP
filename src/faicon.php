<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a Font Awesome icon with various options.
 */
class Faicon extends Node {
    protected ?string $anim = null; // Animation class for the icon
    protected ?string $rotation = null; // Rotation class for the icon
    protected ?string $size = null; // Size class for the icon
    protected string $type = 'fa-solid'; // Type of Font Awesome icon
    protected string $icon; // Icon class
    
    /**
     * Constructor for the Faicon class.
     *
     * @param string $icon The name of the Font Awesome icon
     */
    public function __construct(string $icon) {
        $this->icon = 'fa-' . $icon;
    }
    
    /**
     * Set the rotation class for the icon.
     *
     * @param string $icon_rotation The rotation class
     * @return void
     */
    public function setRotation(string $icon_rotation): void {
        $this->rotation = $icon_rotation;
    }
    
    /**
     * Set the size class for the icon.
     *
     * @param string $icon_size The size class
     * @return void
     */
    public function setSize(string $icon_size): void {
        $this->size = $icon_size;
    }
    
    /**
     * Set the type of the Font Awesome icon.
     *
     * @param string $icon_type The type of icon
     * @return void
     */
    public function setType(string $icon_type): void {
        $this->type = $icon_type;
    }
    
    /**
     * Set the animation class for the icon.
     *
     * @param string $icon_anim The animation class
     * @return void
     */
    public function setAnim(string $icon_anim): void {
        $this->anim = $icon_anim;
    }
    
    /**
     * Generate the HTML representation of the Font Awesome icon.
     *
     * @return string The HTML representation of the icon
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $faicon = $this->type
            . ' ' . $this->icon
            . ($this->rotation ? ' ' . $this->rotation : '')
            . ($this->anim ? ' ' . $this->anim : '')
            . ($this->size ? ' ' . $this->size : '');
        
        array_unshift($this->classes, $faicon); //insert faicon classes
            
        $html = "\n" . $space . '<i'
            . $this->getAttributes()
            . '></i>';
            
        array_shift($this->classes); //remove faicon classes
        
        return $html;
    }
}

/**
 * Constants representing different types of Font Awesome icons.
 */
class icon_type {
    public const SOLID = 'fa-solid';
    public const REGULAR = 'fa-regular';
    public const LIGHT = 'fa-light';
    public const DUO = 'fa-duotone';
    public const THIN = 'fa-thin';
    public const BRAND = 'fa-brands';
}

/**
 * Constants representing different animations for Font Awesome icons.
 */
class icon_anim {
    public const BEAT = 'fa-beat';
    public const BEATFADE = 'fa-beat-fade';
    public const BOUNCE = 'fa-bounce';
    public const FADE = 'fa-fade';
    public const FLIP = 'fa-flip';
    public const SHAKE = 'fa-shake';
    public const SPIN = 'fa-spin';
    public const REVERSE = 'fa-spin fa-spin-reverse';
    public const PULSE = 'fa-spin fa-spin-pulse';
}

/**
 * Constants representing different rotations for Font Awesome icons.
 */
class icon_rotation {
    public const ROT90 = 'fa-rotate-90';
    public const ROT180 = 'fa-rotate-180';
    public const ROT270 = 'fa-rotate-270';
    public const HFLIP = 'fa-flip-horizontal';
    public const VFLIP = 'fa-flip-vertical';
    public const HVFLIP = 'fa-flip-both';
}

/**
 * Constants representing different sizes for Font Awesome icons.
 */
class icon_size {
    public const XXS = 'fa-2xs';
    public const XS = 'fa-xs';
    public const SM = 'fa-sm';
    public const LG = 'fa-lg';
    public const XL = 'fa-xl';
    public const XXL = 'fa-2xl';
}

?>