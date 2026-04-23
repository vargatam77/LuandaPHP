<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an <embed> HTML element.
 */
class Embed extends Node {
    protected string $src;          // URL of the embedded resource
    protected ?string $mediatype = null; // MIME type of the resource
    protected ?int $width = null;   // Width in pixels
    protected ?int $height = null;  // Height in pixels

    /**
     * Constructor for the Embed element.
     *
     * @param string $src The URL of the resource to embed.
     */
    public function __construct(string $src) {
        $this->src = $this->safeUrl($src);
    }

    /**
     * Set the MIME type of the embedded resource.
     *
     * @param string $type MIME type string.
     * @return void
     */
    public function setMediatype(string $type): void {
        $this->mediatype = $type;
    }

    /**
     * Set the display dimensions.
     *
     * @param int $width  Width in pixels.
     * @param int $height Height in pixels.
     * @return void
     */
    public function setSize(int $width, int $height): void {
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * Generate the HTML representation of the <embed> element.
     *
     * @return string The HTML representation of the <embed> element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<embed src="' . $this->src . '"'
            . ($this->mediatype ? ' type="'   . $this->mediatype . '"' : '')
            . ($this->width     ? ' width="'  . $this->width     . '"' : '')
            . ($this->height    ? ' height="' . $this->height    . '"' : '')
            . $this->getAttributes()
            . ' />';

        return $html;
    }
}

?>
