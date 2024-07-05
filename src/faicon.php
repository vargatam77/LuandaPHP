<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a Font Awesome icon with various options.
 */
class faicon extends global_attr {
    protected int $level = 0; // Level of indentation for HTML output
    protected ?string $anim = null; // Animation class for the icon
    protected ?string $rotation = null; // Rotation class for the icon
    protected ?string $size = null; // Size class for the icon
    protected string $type = "fa-solid"; // Type of Font Awesome icon (solid by default)
    protected string $icon; // Icon class
    
    /**
     * Constructor method for faicon class.
     *
     * @param string $icon The name of the Font Awesome icon.
     */
    public function __construct(string $icon) {
        $this->icon = "fa-" . $icon;
    }
    
    /**
     * Set the rotation class for the icon.
     *
     * @param string $icon_rotation The rotation class.
     */
    public function setRotation(string $icon_rotation): void {
        $this->rotation = $icon_rotation;
    }
    
    /**
     * Set the size class for the icon.
     *
     * @param string $icon_size The size class.
     */
    public function setSize(string $icon_size): void {
        $this->size = $icon_size;
    }
    
    /**
     * Set the type of the Font Awesome icon.
     *
     * @param string $icon_type The type of icon (solid, regular, etc.).
     */
    public function setType(string $icon_type): void {
        $this->type = $icon_type;
    }
    
    /**
     * Set the animation class for the icon.
     *
     * @param string $icon_anim The animation class.
     */
    public function setAnim(string $icon_anim): void {
        $this->anim = $icon_anim;
    }
    
    /**
     * Set the level of indentation for HTML output.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Generate the HTML representation of the Font Awesome icon.
     *
     * @return string The HTML representation of the icon.
     */
    public function getHtml(): string {
        // Generate indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the icon
        $faicon = "\n" . $space . "<i class='"
            . $this->type
            . " " . $this->icon
            . (($this->rotation) ? " " . $this->rotation : "")
            . (($this->anim) ? " " . $this->anim : "")
            . (($this->size) ? " " . $this->size : "")
            . $this->getClasses()
            . "'"
            . $this->getAttributes()
            . $this->getEvents()
            . "></i>";
                
        return $faicon;
    }
}

/**
 * Constants representing different types of Font Awesome icons.
 */
class icon_type {
    public const SOLID = "fa-solid";
    public const REGULAR = "fa-regular";
    public const LIGHT = "fa-light";
    public const DUO = "fa-duotone";
    public const THIN = "fa-thin";
    public const BRAND = "fa-brands";
}

/**
 * Constants representing different animations for Font Awesome icons.
 */
class icon_anim {
    public const BEAT = "fa-beat";
    public const BEATFADE = "fa-beat-fade";
    public const BOUNCE = "fa-bounce";
    public const FADE = "fa-fade";
    public const FLIP = "fa-flip";
    public const SHAKE = "fa-shake";
    public const SPIN = "fa-spin";
    public const REVERSE = "fa-spin fa-spin-reverse";
    public const PULSE = "fa-spin fa-spin-pulse";
}

/**
 * Constants representing different rotations for Font Awesome icons.
 */
class icon_rotation {
    public const ROT90 = "fa-rotate-90";
    public const ROT180 = "fa-rotate-180";
    public const ROT270 = "fa-rotate-270";
    public const HFLIP = "fa-flip-horizontal";
    public const VFLIP = "fa-flip-vertical";
    public const HVFLIP = "fa-flip-both";
}

/**
 * Constants representing different sizes for Font Awesome icons.
 */
class icon_size {
    public const XXS = "fa-2xs";
    public const XS = "fa-xs";
    public const SM = "fa-sm";
    public const LG = "fa-lg";
    public const XL = "fa-xl";
    public const XXL = "fa-2xl";
}

?>