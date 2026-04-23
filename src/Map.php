<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <map> HTML element used for image maps.
 */
class Map extends Node {
    protected string $mapName; // Name used to associate with an image

    /**
     * Constructor for the Map element.
     *
     * @param string $mapName The name to associate with an image via usemap.
     */
    public function __construct(string $mapName) {
        $this->mapName = $mapName;
    }

    /**
     * Generate the HTML representation of the <map> element.
     *
     * @return string The HTML representation of the <map> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<map name="' . $this->safeHtml($this->mapName) . '"'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</map>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents an <area> HTML element inside a map.
 */
class Area extends Node {
    protected ?string $href = null;     // Link URL for the area
    protected ?string $alt = null;      // Alternative text
    protected ?string $shape = null;    // Shape of the area
    protected ?string $coords = null;   // Coordinates for the shape
    protected ?string $target = null;   // Link target
    protected ?string $rel = null;      // Relationship hint
    protected ?string $download = null; // Suggested download filename

    /**
     * Constructor for the Area element.
     *
     * @param string $shape  Use area_shape constants.
     * @param string $coords Comma-separated coordinate string.
     */
    public function __construct(string $shape, string $coords) {
        $this->shape  = $shape;
        $this->coords = $coords;
    }

    /**
     * Set the link and its alternative text.
     *
     * @param string $href The destination URL.
     * @param string $alt  Alternative text description.
     * @return void
     */
    public function setLink(string $href, string $alt): void {
        $this->href = $this->safeUrl($href);
        $this->alt  = $this->safeHtml($alt);
    }

    /**
     * Set the link target.
     *
     * @param string $target Use link_target constants.
     * @return void
     */
    public function setTarget(string $target): void {
        $this->target = $target;
    }

    /**
     * Set the rel attribute.
     *
     * @param string $rel Use form_rel constants.
     * @return void
     */
    public function setRel(string $rel): void {
        $this->rel = $rel;
    }

    /**
     * Make the link trigger a file download.
     *
     * @param string|null $filename Optional suggested filename.
     * @return void
     */
    public function setDownload(?string $filename = null): void {
        $this->download = $filename ?? '';
    }

    /**
     * Generate the HTML representation of the <area> element.
     *
     * @return string The HTML representation of the <area> element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<area'
            . ($this->shape    ? ' shape="'  . $this->shape  . '"' : '')
            . ($this->coords   ? ' coords="' . $this->coords . '"' : '')
            . ($this->href     ? ' href="'   . $this->href   . '"' : '')
            . ($this->alt      ? ' alt="'    . $this->alt    . '"' : '')
            . ($this->target   ? ' target="' . $this->target . '"' : '')
            . ($this->rel      ? ' rel="'    . $this->rel    . '"' : '')
            . ($this->download !== null ? ' download' . ($this->download !== '' ? '="' . $this->safeHtml($this->download) . '"' : '') : '')
            . $this->getAttributes()
            . ' />';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for area shape values.
 */
class area_shape {
    public const RECT    = 'rect';
    public const CIRCLE  = 'circle';
    public const POLY    = 'poly';
    public const DEFAULT = 'default';
}

?>
