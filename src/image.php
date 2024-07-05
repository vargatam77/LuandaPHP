<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML image element.
 */
class image extends global_attr {
    protected ?string $url = null; // URL of the image
    protected ?string $alt = null; // Alternate text for the image
    protected int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the image element.
     *
     * @param string|null $url URL of the image (default: null)
     * @param string|null $alt Alternate text for the image (default: null)
     */
    public function __construct(?string $url = null, ?string $alt = null) {
        $this->setUrl($url);
        $this->setAlt($alt);
    }
    
    /**
     * Set the URL of the image.
     *
     * @param string|null $url URL of the image.
     */
    public function setUrl(?string $url): void {
        $this->url = $url;
    }
    
    /**
     * Set the alternate text for the image.
     *
     * @param string|null $alt Alternate text for the image.
     */
    public function setAlt(?string $alt): void {
        $this->alt = $alt;
    }
    
    /**
     * Load the image from a base64 encoded string.
     *
     * @param string $image Base64 encoded image string.
     */
    public function loadBase64(string $image): void {
        $this->url = "data:image/gif;base64," . base64_encode(file_get_contents($image));
    }
    
    /**
     * Generate HTML representation of the image element.
     *
     * @return string The HTML string representing the image element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $image = "\n" . $space . "<img src='" . $this->url . "'"
            . $this->getAttributes()
            . (($this->alt) ? " alt='" . $this->alt . "'" : "")
            . " />";
            
        return $image;
    }
}

?>