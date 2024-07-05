<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a media query.
 */
class media {
    protected ?string $id = null; // ID of the media query
    protected string $media; // Media type of the query (e.g., screen, print)
    protected ?int $min_width = null; // Minimum width for the media query
    protected ?int $max_width = null; // Maximum width for the media query
    protected ?int $min_height = null; // Minimum height for the media query
    protected ?int $max_height = null; // Maximum height for the media query
    
    /**
     * Constructor for the media query.
     *
     * @param string $id ID of the media query.
     * @param string $media Media type (e.g., screen, print).
     */
    public function __construct(string $id, string $media) {
        $this->id = $id;
        $this->media = $media;
    }
    
    /**
     * Get the ID of the media query.
     *
     * @return string|null ID of the media query.
     */
    public function getId(): ?string {
        return $this->id;
    }
    
    /**
     * Set the minimum width for the media query.
     *
     * @param int $min_width Minimum width in pixels.
     */
    public function setMinWidth(int $min_width): void {
        $this->min_width = $min_width;
    }
    
    /**
     * Set the maximum width for the media query.
     *
     * @param int $max_width Maximum width in pixels.
     */
    public function setMaxWidth(int $max_width): void {
        $this->max_width = $max_width;
    }
    
    /**
     * Set the minimum height for the media query.
     *
     * @param int $min_height Minimum height in pixels.
     */
    public function setMinHeight(int $min_height): void {
        $this->min_height = $min_height;
    }
    
    /**
     * Set the maximum height for the media query.
     *
     * @param int $max_height Maximum height in pixels.
     */
    public function setMaxHeight(int $max_height): void {
        $this->max_height = $max_height;
    }
    
    /**
     * Get the complete media query string.
     *
     * @return string Complete media query string.
     */
    public function getMedia(): string {
        $media = $this->media
        . (($this->min_width) ? " and (min-width:" . $this->min_width . "px)" : "")
        . (($this->max_width) ? " and (max-width:" . $this->max_width . "px)" : "")
        . (($this->min_height) ? " and (min-height:" . $this->min_height . "px)" : "")
        . (($this->max_height) ? " and (max-height:" . $this->max_height . "px)" : "");
        return $media;
    }
}
?>