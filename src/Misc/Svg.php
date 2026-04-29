<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

/**
 * A minimal, standalone SVG builder class.
 */
class Svg {
	protected array $elements = [];		// Array to store SVG shape strings
	protected int|float $top;			// Viewbox Y offset
	protected int|float $left;			// Viewbox X offset
	protected int|float $width;			// Numeric width
	protected int|float $height;		// Numeric height
	
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
	 * @param string $strokecolor Stroke color
	 * @param int|float $strokewidth Stroke width
	 * @param string $fillcolor Fill color
	 * @return void
	 */
	public function addRect(int|float $left, int|float $top, int|float $width, int|float $height, string $strokecolor = '#000000', int|float $strokewidth = 1, string $fillcolor = 'none'): void {
		$this->elements[] = '<rect x="' . (string)$left
		. '" y="' . (string)$top
		. '" width="' . (string)$width
		. '" height="' . (string)$height
		. '" stroke="' . $strokecolor
		. '" stroke-width="' . (string)$strokewidth
		. '" fill="' . $fillcolor
		. '"/>';
	}
	
	/**
	 * Returns the width of the SVG.
	 *
	 * @return int|float
	 */
	public function getWidth(): int|float {
		return $this->width;
	}
	
	/**
	 * Returns the height of the SVG.
	 *
	 * @return int|float
	 */
	public function getHeight(): int|float {
		return $this->height;
	}
	
	/**
	 * Adds a circle to the SVG.
	 *
	 * @param int|float $centrex Center X
	 * @param int|float $centrey Center Y
	 * @param int|float $radius Radius
	 * @param string $strokecolor Stroke color
	 * @param int|float $strokewidth Stroke width
	 * @param string $fillcolor Fill color
	 * @return void
	 */
	public function addCircle(int|float $centrex, int|float $centrey, int|float $radius, string $strokecolor = '#000000', int|float $strokewidth = 1, string $fillcolor = 'none'): void {
		$this->elements[] = '<circle cx="' . (string)$centrex
		. '" cy="' . (string)$centrey
		. '" r="' . (string)$radius
		. '" stroke="' . $strokecolor
		. '" stroke-width="' . (string)$strokewidth
		. '" fill="' . $fillcolor
		. '"/>';
	}
	
	/**
	 * Adds a path to the SVG.
	 *
	 * @param string $pathdata Path data
	 * @param string $strokecolor Stroke color
	 * @param int|float $strokewidth Stroke width
	 * @return void
	 */
	public function addPath(string $pathdata, string $strokecolor = '#000000', int|float $strokewidth = 1): void {
		$this->elements[] = '<path d="' . $pathdata
		. '" stroke="' . $strokecolor
		. '" stroke-width="' . (string)$strokewidth
		. '" stroke-linecap="round"/>';
	}
	
	/**
	 * Returns a default "no image" placeholder SVG.
	 *
	 * @return string Raw SVG markup
	 */
	public function createDefaultImage(): string {
		$this->addRect(0, 0, 100, 100, '#e0e0e0');
		$this->addCircle(50, 50, 30, '#a0a0a0', 6);
		$this->addPath('M20 20L80 80', '#a0a0a0', 6);

		return $this->getXml();
	}
	
	/**
	 * Generates the raw SVG XML string.
	 *
	 * @return string The SVG markup
	 */
	public function getXml(): string {
		$_xml = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="'
			. (string)$this->top . ' '
			. (string)$this->left . ' '
			. (string)$this->width . ' '
			. (string)$this->height . '">';
			
		foreach ($this->elements as $_element)
			$_xml .= $_element;
			
		$_xml .= '</svg>';
			
		return $_xml;
	}
}

?>