<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a media query string builder.
 */
class Media {
    protected ?string $id = null; // ID of the media query
    protected string $mediaType; // Media type of the query (e.g., screen, print)
    protected int|float|null $minWidth = null; // Minimum width for the media query
    protected int|float|null $maxWidth = null; // Maximum width for the media query
    protected int|float|null $minHeight = null; // Minimum height for the media query
    protected int|float|null $maxHeight = null; // Maximum height for the media query
    
    /**
     * Constructor for the media query.
     *
     * @param string $id ID of the media query
     * @param string $media Media type
     */
    public function __construct(string $id, string $media_type) {
        $this->id = $id;
        $this->mediaType = $media_type;
    }
    
    /**
     * Get the ID of the media query.
     *
     * @return string|null ID of the media query
     */
    public function getId(): ?string {
        return $this->id;
    }
    
    /**
     * Set the minimum width for the media query.
     *
     * @param int|float $min_width Minimum width in pixels
     * @return void
     */
    public function setMinWidth(int|float $min_width): void {
        $this->minWidth = $min_width;
    }
    
    /**
     * Set the maximum width for the media query.
     *
     * @param int|float $max_width Maximum width in pixels
     * @return void
     */
    public function setMaxWidth(int|float $max_width): void {
        $this->maxWidth = $max_width;
    }
    
    /**
     * Set the minimum height for the media query.
     *
     * @param int|float $min_height Minimum height in pixels
     * @return void
     */
    public function setMinHeight(int|float $min_height): void {
        $this->minHeight = $min_height;
    }
    
    /**
     * Set the maximum height for the media query.
     *
     * @param int|float $max_height Maximum height in pixels
     * @return void
     */
    public function setMaxHeight(int|float $max_height): void {
        $this->maxHeight = $max_height;
    }
    
    /**
     * Get the complete media query string.
     *
     * @return string Complete media query string
     */
    public function getMedia(): string {
        $parts = [];
        if ($this->mediaType !== '') {
            $parts[] = $this->mediaType;
        }
        
        if ($this->minWidth !== null) {
            $parts[] = '(min-width:' . (string)$this->minWidth . 'px)';
        }
        if ($this->maxWidth !== null) {
            $parts[] = '(max-width:' . (string)$this->maxWidth . 'px)';
        }
        if ($this->minHeight !== null) {
            $parts[] = '(min-height:' . (string)$this->minHeight . 'px)';
        }
        if ($this->maxHeight !== null) {
            $parts[] = '(max-height:' . (string)$this->maxHeight . 'px)';
        }
        
        return implode(' and ', $parts);
    }
}

?>