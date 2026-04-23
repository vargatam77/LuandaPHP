<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

/**
 * Represents an encoded image (<img>) element with various attributes.
 */
class EncodedImg {
    protected ?string $src = null; // Source attribute
    
    /**
     * Constructor for the EncodedImg element.
     *
     * @param string|null $src The source path of the image
     */
    public function __construct(?string $src = null) {
        if ($src) $this->src = $src;
    }
    
    /**
     * Formats a raw string or file into a safe Base64 Data URI.
     *
     * @param string $data The raw binary data or file path
     * @param string $mime_type The image type (e.g., 'image/png')
     * @return string The formatted Data URI
     */
    private function encodeBase64(string $data, string $mime_type = 'image/png'): string {
        $base64 = base64_encode($data);
        $uri = 'data:' . $mime_type . ';base64,' . $base64;
        
        return $uri;
    }
    
    /**
     * Loads a local file and converts it to a safe Base64 Data URI.
     *
     * @return string Safe Data URI or default placeholder on failure
     */
    public function loadToBase64(): string {
        if ($this->src && file_exists($this->src)) {
            $data = file_get_contents($this->src);
            $mime = mime_content_type($this->src) ?: 'image/png';
        } else {
            $default_img = new Svg();
            $data = $default_img->createDefaultImage();
            $mime = 'image/svg+xml';
        }
        
        return $this->encodeBase64($data, $mime);
    }
}

?>