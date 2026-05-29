<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

use TamasVarga\LuandaPHP\INodeInterface;
use TamasVarga\LuandaPHP\Element;

/**
 * A minimal, standalone SVG builder class by Claude Sonnet 4.6.
 *
 * Supports shapes, groups, defs (masks, gradients), inline styles,
 * raw injection, and parsing from an existing SVG string.
 *
 * All shape methods accept a unified $attrs array for full SVG attribute support.
 * Groups and masks use beginGroup/endGroup and beginMask/endMask pairs.
 *
 * @example
 *   $svg = new Svg(0, 0, 120, 120, ['class' => 'my-svg']);
 *   $svg->addLinearGradient('grad1', [
 *     ['offset' => '0%',   'stop-color' => '#fff'],
 *     ['offset' => '100%', 'stop-color' => '#000'],
 *   ]);
 *   $svg->beginGroup(['fill' => 'none', 'stroke' => '#000']);
 *     $svg->addRect(['x' => 10, 'y' => 10, 'width' => 80, 'height' => 80]);
 *   $svg->endGroup();
 *   echo $svg->getXml();
 */
class Svg extends Element implements INodeInterface {
	protected array     $defs       = [];   // Raw def strings (<mask>, <gradient>, etc.)
	protected array     $elements   = [];   // Top-level element strings
	protected array     $attrs      = [];   // Extra <svg> attributes (class, id, etc.)
	protected int|float $top        = 0;    // ViewBox min-x
	protected int|float $left       = 0;    // ViewBox min-y
	protected int|float $width      = 100;  // ViewBox / canvas width
	protected int|float $height     = 100;  // ViewBox / canvas height
	
	protected int $level			= 0;
	
	private array $groupStack = [];         // Stack for open beginGroup/beginMask calls
	
	/**
	 * @param int|float $top    ViewBox min-x offset
	 * @param int|float $left   ViewBox min-y offset
	 * @param int|float $width  Canvas width
	 * @param int|float $height Canvas height
	 * @param array     $attrs  Additional <svg> attributes (e.g. class, id)
	 */
	public function __construct(
		int|float $top    = 0,
		int|float $left   = 0,
		int|float $width  = 100,
		int|float $height = 100,
		array     $attrs  = []
		) {
			$this->top    = $top;
			$this->left   = $left;
			$this->width  = $width;
			$this->height = $height;
			$this->attrs  = $attrs;
	}
	
	public function setLevel(int $level): void {
		$this->level = $level;
	}
	
	// =========================================================================
	// Internal helpers
	// =========================================================================
	
	/**
	 * Builds an HTML attribute string from a key => value array.
	 */
	private function buildAttrs(array $attrs): string {
		$_result = '';
		foreach ($attrs as $_key => $_value)
			$_result .= ' ' . $_key . '="' . $_value . '"';
			return $_result;
	}
	
	/**
	 * Appends an element string to the current target
	 * (innermost open group, or top-level elements).
	 */
	private function append(string $element): void {
		if (!empty($this->groupStack))
			$this->groupStack[count($this->groupStack) - 1]['children'][] = $element;
			else
				$this->elements[] = $element;
	}
	
	// =========================================================================
	// Defs
	// =========================================================================
	
	/**
	 * Injects a raw string directly into <defs>.
	 * Use for anything not covered by the dedicated helpers.
	 *
	 * @param string $raw Raw SVG def markup
	 */
	public function addRawDef(string $raw): void {
		$this->defs[] = $raw;
	}
	
	/**
	 * Adds a <linearGradient> to <defs>.
	 *
	 * @param string $id    Gradient ID (referenced as url(#id))
	 * @param array  $stops Array of stop attribute arrays e.g. [['offset' => '0%', 'stop-color' => '#fff']]
	 * @param array  $attrs Additional gradient attributes (x1, y1, x2, y2, gradientUnits, etc.)
	 */
	public function addLinearGradient(string $id, array $stops, array $attrs = []): void {
		$_stops = '';
		foreach ($stops as $_stop)
			$_stops .= '<stop' . $this->buildAttrs($_stop) . '/>';
			$this->defs[] = '<linearGradient id="' . $id . '"' . $this->buildAttrs($attrs) . '>' . $_stops . '</linearGradient>';
	}
	
	/**
	 * Adds a <radialGradient> to <defs>.
	 *
	 * @param string $id    Gradient ID
	 * @param array  $stops Array of stop attribute arrays
	 * @param array  $attrs Additional gradient attributes (cx, cy, r, fx, fy, etc.)
	 */
	public function addRadialGradient(string $id, array $stops, array $attrs = []): void {
		$_stops = '';
		foreach ($stops as $_stop)
			$_stops .= '<stop' . $this->buildAttrs($_stop) . '/>';
			$this->defs[] = '<radialGradient id="' . $id . '"' . $this->buildAttrs($attrs) . '>' . $_stops . '</radialGradient>';
	}
	
	/**
	 * Opens a <mask> def. Subsequent appended elements go inside it.
	 * Must be closed with endMask().
	 *
	 * @param string $id    Mask ID (referenced as mask="url(#id)")
	 * @param array  $attrs Additional mask attributes
	 */
	public function beginMask(string $id, array $attrs = []): void {
		$this->groupStack[] = ['tag' => 'mask', 'attrs' => array_merge(['id' => $id], $attrs), 'children' => [], 'def' => true];
	}
	
	/**
	 * Closes the current <mask> and commits it to <defs>.
	 */
	public function endMask(): void {
		$this->closeStack(true);
	}
	
	// =========================================================================
	// Groups
	// =========================================================================
	
	/**
	 * Opens a <g> group. Subsequent appended elements go inside it.
	 * Must be closed with endGroup().
	 *
	 * @param array $attrs Group attributes (class, mask, opacity, fill, stroke, transform, etc.)
	 */
	public function beginGroup(array $attrs = []): void {
		$this->groupStack[] = ['tag' => 'g', 'attrs' => $attrs, 'children' => [], 'def' => false];
	}
	
	/**
	 * Closes the current <g> group and appends it to the parent target.
	 */
	public function endGroup(): void {
		$this->closeStack(false);
	}
	
	/**
	 * Closes the top of the group stack and routes it to defs or elements.
	 */
	private function closeStack(bool $intoDefs): void {
		if (empty($this->groupStack)) return;
		
		$_frame   = array_pop($this->groupStack);
		$_inner   = implode('', $_frame['children']);
		$_markup  = '<' . $_frame['tag'] . $this->buildAttrs($_frame['attrs']) . '>' . $_inner . '</' . $_frame['tag'] . '>';
		
		if ($intoDefs)
			$this->defs[] = $_markup;
			else
				$this->append($_markup);
	}
	
	// =========================================================================
	// Shapes & Elements
	// =========================================================================
	
	/**
	 * Adds a <rect> element.
	 *
	 * @param array $attrs SVG attributes: x, y, width, height, fill, stroke, stroke-width,
	 *                     rx, ry, opacity, class, mask, transform, etc.
	 */
	public function addRect(array $attrs): void {
		$this->append('<rect' . $this->buildAttrs($attrs) . '/>');
	}
	
	/**
	 * Adds a <circle> element.
	 *
	 * @param array $attrs SVG attributes: cx, cy, r, fill, stroke, stroke-width, opacity, class, etc.
	 */
	public function addCircle(array $attrs): void {
		$this->append('<circle' . $this->buildAttrs($attrs) . '/>');
	}
	
	/**
	 * Adds an <ellipse> element.
	 *
	 * @param array $attrs SVG attributes: cx, cy, rx, ry, fill, stroke, stroke-width, etc.
	 */
	public function addEllipse(array $attrs): void {
		$this->append('<ellipse' . $this->buildAttrs($attrs) . '/>');
	}
	
	/**
	 * Adds a <line> element.
	 *
	 * @param array $attrs SVG attributes: x1, y1, x2, y2, stroke, stroke-width, etc.
	 */
	public function addLine(array $attrs): void {
		$this->append('<line' . $this->buildAttrs($attrs) . '/>');
	}
	
	/**
	 * Adds a <polyline> element.
	 *
	 * @param array $attrs SVG attributes: points, fill, stroke, stroke-width, etc.
	 */
	public function addPolyline(array $attrs): void {
		$this->append('<polyline' . $this->buildAttrs($attrs) . '/>');
	}
	
	/**
	 * Adds a <polygon> element.
	 *
	 * @param array $attrs SVG attributes: points, fill, stroke, stroke-width, etc.
	 */
	public function addPolygon(array $attrs): void {
		$this->append('<polygon' . $this->buildAttrs($attrs) . '/>');
	}
	
	/**
	 * Adds a <path> element.
	 *
	 * @param array $attrs SVG attributes: d, fill, stroke, stroke-width,
	 *                     stroke-linecap, stroke-linejoin, opacity, class, etc.
	 */
	public function addPath(array $attrs): void {
		$this->append('<path' . $this->buildAttrs($attrs) . '/>');
	}
	
	/**
	 * Adds a <text> element.
	 *
	 * @param string $text  Text content
	 * @param array  $attrs SVG attributes: x, y, font-size, font-family, fill, text-anchor, etc.
	 */
	public function addText(string $text, array $attrs = []): void {
		$this->append('<text' . $this->buildAttrs($attrs) . '>' . $text . '</text>');
	}
	
	/**
	 * Adds an <image> element.
	 *
	 * @param array $attrs SVG attributes: href, x, y, width, height, preserveAspectRatio, etc.
	 */
	public function addImage(array $attrs): void {
		$this->append('<image' . $this->buildAttrs($attrs) . '/>');
	}
	
	/**
	 * Adds an inline <style> block.
	 * Useful for embedding CSS animations and class-based styles.
	 *
	 * @param string $css Raw CSS content
	 */
	public function addStyle(string $css): void {
		$this->append('<style>' . $css . '</style>');
	}
	
	/**
	 * Injects a raw SVG string directly into the current target.
	 * Use for anything not covered by the dedicated methods.
	 *
	 * @param string $raw Raw SVG markup
	 */
	public function addRaw(string $raw): void {
		$this->append($raw);
	}
	
	// =========================================================================
	// Parse
	// =========================================================================
	
	/**
	 * Parses an existing SVG string into a new Svg instance.
	 *
	 * Extracts viewBox dimensions and additional <svg> attributes.
	 * The inner content is preserved as-is — <defs> go into defs,
	 * everything else goes into elements.
	 *
	 * @param  string $svgString Raw SVG markup
	 * @return static
	 */
	public static function fromString(string $svgString): static {
		$_dom = new \DOMDocument();
		@$_dom->loadXML(trim($svgString));
		$_root = $_dom->documentElement;
		
		$_top = 0; $_left = 0; $_width = 100; $_height = 100;
		
		if ($_root->hasAttribute('viewBox')) {
			$_vb = preg_split('/[\s,]+/', trim($_root->getAttribute('viewBox')));
			if (count($_vb) === 4) {
				[$_top, $_left, $_width, $_height] = array_map('floatval', $_vb);
			}
		}
		
		$_attrs = [];
		foreach ($_root->attributes as $_attr)
			if (!in_array($_attr->name, ['viewBox', 'xmlns', 'width', 'height']))
				$_attrs[$_attr->name] = $_attr->value;
				
				$_instance = new static($_top, $_left, $_width, $_height, $_attrs);
				
				foreach ($_root->childNodes as $_child) {
					if ($_child->nodeType !== XML_ELEMENT_NODE) continue;
					
					if ($_child->nodeName === 'defs') {
						foreach ($_child->childNodes as $_def)
							if ($_def->nodeType === XML_ELEMENT_NODE)
								$_instance->defs[] = $_dom->saveXML($_def);
					} else {
						$_instance->elements[] = $_dom->saveXML($_child);
					}
				}
				
				return $_instance;
	}
	
	// =========================================================================
	// Output
	// =========================================================================
	
	/**
	 * Returns the width of the SVG canvas.
	 */
	public function getWidth(): int|float {
		return $this->width;
	}
	
	/**
	 * Returns the height of the SVG canvas.
	 */
	public function getHeight(): int|float {
		return $this->height;
	}
	
	/**
	 * Generates the SVG XML string.
	 *
	 * @return string The complete SVG markup
	 */
	public function getHtml(): string {
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<svg xmlns="http://www.w3.org/2000/svg" viewBox="'
			. $this->top . ' '
			. $this->left . ' '
			. $this->width . ' '
			. $this->height . '"'
			. $this->buildAttrs($this->attrs) . '>';
							
		if (!empty($this->defs))
			$_html .= Element::getNewlineString()
				. $_indent . Element::getIndentString() . '<defs>'
				. implode('', $this->defs)
				. '</defs>';
			
		$_html .= Element::getNewlineString()
			. $_indent . Element::getIndentString() . implode('', $this->elements)
			. Element::getNewlineString()
			. $_indent . '</svg>';
			
		return $_html;
	}
	
	/**
	 * Returns a default "no image" placeholder SVG.
	 *
	 * @return string Raw SVG markup
	 */
	public function createDefaultImage(): string {
		$this->addRect(['x' => 0, 'y' => 0, 'width' => 100, 'height' => 100, 'stroke' => '#e0e0e0', 'fill' => 'none']);
		$this->addCircle(['cx' => 50, 'cy' => 50, 'r' => 30, 'stroke' => '#a0a0a0', 'stroke-width' => 6, 'fill' => 'none']);
		$this->addPath(['d' => 'M20 20L80 80', 'stroke' => '#a0a0a0', 'stroke-width' => 6]);
		return $this->getXml();
	}
}