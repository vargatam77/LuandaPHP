<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

use TamasVarga\LuandaPHP\Misc\EncodedImg;

/**
 * Represents an HTML image element.
 */
class Image extends Node {
    protected ?string $url = null; // URL of the image
    protected ?string $alt = null; // Alternate text for the image
    protected ?string $width = null; // Width of the image
    protected ?string $height = null; // Height of the image
    
    /**
     * Constructor for the image element.
     *
     * @param string|null $url URL of the image
     * @param string|null $alt Alternate text for the image
     */
    public function __construct(?string $url = null, ?string $alt = null) {
        $this->setUrl($url);
        $this->setAlt($alt);
    }
    
    /**
     * Set the URL of the image.
     *
     * @param string|null $url URL of the image
     * @return void
     */
    public function setUrl(?string $url): void {
        if ($url) $this->url = $this->safeUrl($url);
    }
    
    /**
     * Set the alternate text for the image.
     *
     * @param string|null $alt Alternate text for the image
     * @return void
     */
    public function setAlt(?string $alt): void {
        if ($alt) $this->alt = $this->safeHtml($alt);
    }
    
    /**
     * Load the image from a local path and convert to Base64.
     *
     * @param string $path Local file path to the image
     * @return void
     */
    public function loadBase64(?string $path = null): void {
        $encoder = new EncodedImg($path);
        $this->url = $encoder->loadToBase64();
    }
    
    /**
     * Generate HTML representation of the image element.
     *
     * @return string The HTML representation of the image element
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        if (!$this->url || !file_exists($this->url)) $this->loadBase64();
        
        $html = "\n" . $space . '<img src="' . $this->url . '"'
            . ($this->alt ? ' alt="' . $this->alt . '"' : ' alt=""')
            . ($this->width ? ' width="' . $this->width . '"' : '')
            . ($this->height ? ' height="' . $this->height . '"' : '')
            . $this->getAttributes()
            . ' />';
            
        return $html;
    }
}

?>