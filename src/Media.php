<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a media query string builder.
 */
class Media extends Element {
	protected ?string $mediaType		= null;		// Media type of the query (e.g., screen, print)
	protected int|float|null $minWidth	= null;		// Minimum width for the media query
	protected int|float|null $maxWidth	= null;		// Maximum width for the media query
	protected int|float|null $minHeight	= null;		// Minimum height for the media query
	protected int|float|null $maxHeight	= null;		// Maximum height for the media query
	protected ?string $orientation		= null;		// Orientation of the viewport
	protected ?string $colorScheme		= null;		// Preferred color scheme
	protected ?string $reducedMotion	= null;		// Preferred reduced motion
	protected ?string $hover			= null;		// Hover capability
	protected ?string $resolution		= null;		// Resolution of the display
	
	/**
	 * Constructor for the media query.
	 *
	 * @param string|null $mediatype Media type, use media_type:: constants
	 */
	public function __construct(?string $mediatype = null) {
		if ($this->hasValue($mediatype))
			$this->setMediaType($mediatype);
	}
	
	/**
	 * Set the media type for the query.
	 *
	 * @param string $mediatype Media type, use media_type:: constants
	 * @return void
	 */
	public function setMediaType(string $mediatype): void {
		$this->mediaType = $mediatype;
	}
	
	/**
	 * Set the minimum width for the media query.
	 *
	 * @param int|float $minwidth Minimum width in pixels
	 * @return void
	 */
	public function setMinWidth(int|float $minwidth): void {
		$this->minWidth = $minwidth;
	}
	
	/**
	 * Set the maximum width for the media query.
	 *
	 * @param int|float $maxwidth Maximum width in pixels
	 * @return void
	 */
	public function setMaxWidth(int|float $maxwidth): void {
		$this->maxWidth = $maxwidth;
	}
	
	/**
	 * Set the minimum height for the media query.
	 *
	 * @param int|float $minheight Minimum height in pixels
	 * @return void
	 */
	public function setMinHeight(int|float $minheight): void {
		$this->minHeight = $minheight;
	}
	
	/**
	 * Set the maximum height for the media query.
	 *
	 * @param int|float $maxheight Maximum height in pixels
	 * @return void
	 */
	public function setMaxHeight(int|float $maxheight): void {
		$this->maxHeight = $maxheight;
	}
	
	/**
	 * Set the orientation for the media query.
	 *
	 * @param string $orientation Use media_orientation:: constants
	 * @return void
	 */
	public function setOrientation(string $orientation): void {
		$this->orientation = $orientation;
	}
	
	/**
	 * Set the preferred color scheme for the media query.
	 *
	 * @param string $colorscheme Use media_colorscheme:: constants
	 * @return void
	 */
	public function setColorScheme(string $colorscheme): void {
		$this->colorScheme = $colorscheme;
	}
	
	/**
	 * Set the preferred reduced motion for the media query.
	 *
	 * @param string $reducedmotion Use media_reducedmotion:: constants
	 * @return void
	 */
	public function setReducedMotion(string $reducedmotion): void {
		$this->reducedMotion = $reducedmotion;
	}
	
	/**
	 * Set the hover capability for the media query.
	 *
	 * @param string $hover Use media_hover:: constants
	 * @return void
	 */
	public function setHover(string $hover): void {
		$this->hover = $hover;
	}
	
	/**
	 * Set the resolution for the media query.
	 *
	 * @param string $resolution Resolution string, e.g. '2dppx'
	 * @return void
	 */
	public function setResolution(string $resolution): void {
		$this->resolution = $resolution;
	}
	
	/**
	 * Get the complete media query string.
	 *
	 * @return string Complete media query string
	 */
	public function getMedia(): string {
		$_parts = [];
		
		if ($this->hasValue($this->mediaType))		$_parts[] = $this->mediaType;
		if ($this->hasValue($this->minWidth))		$_parts[] = '(min-width: ' . (string)$this->minWidth . 'px)';
		if ($this->hasValue($this->maxWidth))		$_parts[] = '(max-width: ' . (string)$this->maxWidth . 'px)';
		if ($this->hasValue($this->minHeight))		$_parts[] = '(min-height: ' . (string)$this->minHeight . 'px)';
		if ($this->hasValue($this->maxHeight))		$_parts[] = '(max-height: ' . (string)$this->maxHeight . 'px)';
		if ($this->hasValue($this->orientation))	$_parts[] = '(orientation: ' . $this->orientation . ')';
		if ($this->hasValue($this->colorScheme))	$_parts[] = '(prefers-color-scheme: ' . $this->colorScheme . ')';
		if ($this->hasValue($this->reducedMotion))	$_parts[] = '(prefers-reduced-motion: ' . $this->reducedMotion . ')';
		if ($this->hasValue($this->hover))			$_parts[] = '(hover: ' . $this->hover . ')';
		if ($this->hasValue($this->resolution))		$_parts[] = '(resolution: ' . $this->resolution . ')';
		
		return implode(' and ', $_parts);
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for media type values.
 */
class media_type {
	public const ALL	= 'all';
	public const SCREEN	= 'screen';
	public const PRINT	= 'print';
	public const SPEECH	= 'speech';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for media orientation values.
 */
class media_orientation {
	public const PORTRAIT	= 'portrait';
	public const LANDSCAPE	= 'landscape';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for media color scheme values.
 */
class media_colorscheme {
	public const LIGHT	= 'light';
	public const DARK	= 'dark';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for media reduced motion values.
 */
class media_reducedmotion {
	public const REDUCE			= 'reduce';
	public const NO_PREFERENCE	= 'no-preference';
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Class to define constants for media hover values.
 */
class media_hover {
	public const HOVER	= 'hover';
	public const NONE	= 'none';
}

?>