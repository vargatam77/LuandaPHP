<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <link> tag for stylesheets or icons in the head section.
 */
class Resource extends Node {
    protected ?string $rel = null; // Relationship attribute of the link
    protected ?string $href = null; // Href attribute of the link
    protected ?Media $media = null; // Media attribute of the link
    
    /**
     * Constructor for the Resource element.
     *
     * @param string $rel The relationship attribute value
     * @param string $href The href attribute value
     * @param string|null $media The media type or query ID
     */
    public function __construct(string $rel, string $href, ?string $media = null) {
        $this->rel = $rel;
        $this->href = $href;
        if ($media) $this->media = new Media($media, $media);
    }
    
    /**
     * Sets the media attribute of the link.
     *
     * @param string $media The media attribute value
     * @return void
     */
    public function setMedia(string $media): void {
        $this->media = new Media($media, $media);
    }
    
    /**
     * Generates the HTML representation of the link tag.
     *
     * @return string The HTML representation of the link tag
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<link rel="' . $this->rel . '" href="' . $this->href . '"'
            . ($this->rel === 'icon' ? ' type="image/gif"' : '')
            . ($this->media ? ' media="' . $this->media->getMedia() . '"' : '')
            . $this->getAttributes()
            . ' />';
            
        return $html;
    }
}

?>