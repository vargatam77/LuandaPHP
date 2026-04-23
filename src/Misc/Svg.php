<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

/**
 * A minimal, standalone SVG builder class.
 */
class Svg {
    protected array $elements = []; // Array to store SVG shape strings
    protected int|float $top;  // Viewbox Y offset
    protected int|float $left;  // Viewbox X offset
    protected int|float $width;    // Numeric width
    protected int|float $height;   // Numeric height
    
    /**
     * Constructor for the Svg builder.
     *
     * @param int|float $top Starting Y of viewbox
     * @param int|float $left Starting X of viewbox
     * @param int|float $width The width of the canvas
     * @param int|float $height The height of the canvas
     */
    public function __construct(int|float $top = 0, int|float $left = 0, int|float $width = 100, int|float $height = 100) {
        $this->top = $top;
        $this->left = $left;
        $this->width = $width;
        $this->height = $height;
    }
    
    /**
     * Adds a rectangle to the SVG.
     *
     * @param int|float $left X coordinate
     * @param int|float $top Y coordinate
     * @param int|float $width Width
     * @param int|float $height Height
     * @param string $stroke_color Stroke color
     * @param int|float $stroke_width Stroke width
     * @param string $fill_color Fill color
     * @return void
     */
    public function addRect(int|float $left, int|float $top, int|float $width, int|float $height, string $stroke_color = '#000000', int|float $stroke_width = 1, string $fill_color = 'none'): void {
        $this->elements[] = '<rect x="' . (string)$left
        . '" y="' . (string)$top
        . '" width="' . (string)$width
        . '" height="' . (string)$height
        . '" stroke="' . $stroke_color
        . '" stroke-width="' . (string)$stroke_width
        . '" fill="' . $fill_color
        . '"/>';
    }
    
    /**
     * Returns the width of the SVG.
     * @return int|float
     */
    public function getWidth(): int|float {
        return $this->width;
    }
    
    /**
     * Returns the height of the SVG.
     * @return int|float
     */
    public function getHeight(): int|float {
        return $this->height;
    }
    
    /**
     * Adds a circle to the SVG.
     *
     * @param int|float $centre_x Center X
     * @param int|float $centre_y Center Y
     * @param int|float $radius Radius
     * @param string $stroke_color Stroke color
     * @param int|float $stroke_width Stroke width
     * @param string $fill_color Fill color
     * @return void
     */
    public function addCircle(int|float $centre_x, int|float $centre_y, int|float $radius, string $stroke_color = '#000000', int|float $stroke_width = 1, string $fill_color = 'none'): void {
        $this->elements[] = '<circle cx="' . (string)$centre_x
        . '" cy="' . (string)$centre_y
        . '" r="' . (string)$radius
        . '" stroke="' . $stroke_color
        . '" stroke-width="' . (string)$stroke_width
        . '" fill="' . $fill_color
        . '"/>';
    }
    
    /**
     * Adds a path to the SVG.
     *
     * @param string $path_data Path data
     * @param string $stroke_color Stroke color
     * @param int|float $stroke_width Stroke width
     * @return void
     */
    public function addPath(string $path_data, string $stroke_color = '#000000', int|float $stroke_width = 1): void {
        $this->elements[] = '<path d="' . $path_data
        . '" stroke="' . $stroke_color
        . '" stroke-width="' . (string)$stroke_width
        . '" stroke-linecap="round"/>';
    }
    
    /**
     * Returns a default "no image" placeholder.
     *
     * @return string Safe Data URI
     */
    public function createDefaultImage(): string {
        $svg = new Svg();
        
        $svg->addRect(0, 0, 100, 100, '#e0e0e0');
        $svg->addCircle(50, 50, 30, '#a0a0a0', 6);
        $svg->addPath('M20 20L80 80', '#a0a0a0', 6);
        
        return $svg->getXml();
    }
    
    /**
     * Generates the raw SVG XML string.
     *
     * @return string The SVG markup.
     */
    public function getXml(): string {
        $xml = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="'
            . (string)$this->top . ' '
            . (string)$this->left . ' '
            . (string)$this->width . ' '
            . (string)$this->height . '">';
        
        foreach ($this->elements as $element) {
            $xml .= $element;
        }
        
        $xml .= '</svg>';
        
        return $xml;
    }
}

?>