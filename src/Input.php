<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an input HTML element.
 */
class Input extends Node {
	protected ?string $parent				= null;		// Parent form ID for the input
	protected ?string $alt					= null;		// Alternate text for the input
	protected ?string $src					= null;		// Source URL for image inputs
	protected ?int $width					= null;		// Width of image inputs
	protected ?int $height					= null;		// Height of image inputs
	public string|int|float|null $value		= null;		// Value attribute of the input
	protected bool $readonly				= false;	// Indicates if the input is readonly
	protected bool $required				= false;	// Indicates if the input is required
	protected ?string $type					= null;		// Type of the input
	protected ?int $size					= null;		// Size of the input
	protected ?int $minlen					= null;		// Minimum length for text input
	protected ?int $maxlen					= null;		// Maximum length for text input
	protected string|int|float|null $min	= null;		// Minimum value for input
	protected string|int|float|null $max	= null;		// Maximum value for input
	protected bool $multiple				= false;	// Indicates if multiple files can be selected
	protected ?string $pattern				= null;		// Pattern for validating input
	protected ?string $placeholder			= null;		// Placeholder text for input
	protected ?string $step					= null;		// Step value for number input
	protected bool $checked					= false;	// Indicates if the input is checked
	protected array $fileformats			= [];		// Accepted file formats for file input
	protected ?string $device				= null;		// Device type for capture input
	protected array $autocompletes			= [];		// Autocomplete tokens for input
	protected ?Output $output				= null;		// Output element associated with input
	protected ?Datalist $datalist			= null;		// Datalist element associated with input
	
	/**
	 * Constructor for the input element.
	 *
	 * @param string|null $type Type of the input
	 */
	public function __construct(?string $type = null) {
		if ($this->hasValue($type)) $this->type = $type;
	}
	
	/**
	 * Check the input element.
	 *
	 * @return void
	 */
	public function Check(): void {
		$this->checked = true;
	}
	
	/**
	 * Set the input as readonly.
	 *
	 * @return void
	 */
	public function toReadonly(): void {
		$this->readonly = true;
	}
	
	/**
	 * Set the input as required.
	 *
	 * @return void
	 */
	public function toRequired(): void {
		$this->required = true;
	}
	
	/**
	 * Set the value of the input with safe HTML encoding.
	 *
	 * @param string|int|float $value Value of the input
	 * @return void
	 */
	public function setValue(string|int|float $value): void {
		$this->value = $this->safeHtml((string)$value);
	}
	
	/**
	 * Add autocomplete tokens for the input.
	 *
	 * @param string $autocomplete Autocomplete token, use form_autocomplete:: constants or custom value
	 * @return void
	 */
	public function addAutocompletes(string $autocomplete): void {
		foreach (explode(' ', $autocomplete) as $_autocomplete)
			$this->autocompletes[$_autocomplete] = $_autocomplete;
	}
	
	/**
	 * Add an element to the datalist associated with the input.
	 *
	 * @param string $element Element to add to the datalist
	 * @return void
	 */
	public function addElement(string $element): void {
		if (!$this->datalist) $this->datalist = new Datalist();
		$this->datalist->addElement($element);
	}
	
	/**
	 * Set the size attribute for the input.
	 *
	 * @param int $size Size of the input
	 * @return void
	 */
	public function setLength(int $size): void {
		$this->size = $size;
	}
	
	/**
	 * Set the parent form ID for the input.
	 *
	 * @param string $formid Parent form ID
	 * @return void
	 */
	public function setParent(string $formid): void {
		$this->parent = $formid;
	}
	
	/**
	 * Set the size of the image input.
	 *
	 * @param int $width Width of the image
	 * @param int $height Height of the image
	 * @return void
	 */
	public function setImgSize(int $width, int $height): void {
		$this->width = $width;
		$this->height = $height;
	}
	
	/**
	 * Set the step value for number input.
	 *
	 * @param string $step Step value
	 * @return void
	 */
	public function setStep(string $step): void {
		$this->step = $step;
	}
	
	/**
	 * Set the alternate text for the input.
	 *
	 * @param string $alt Alternate text
	 * @return void
	 */
	public function setAlt(string $alt): void {
		$this->alt = $this->safeHtml($alt);
	}
	
	/**
	 * Set the source URL for image input.
	 *
	 * @param string $url Source URL
	 * @return void
	 */
	public function setSource(string $url): void {
		$this->src = $this->safeUrl($url);
	}
	
	/**
	 * Set the min and max values for input.
	 *
	 * @param string|int|float|null $min Minimum value
	 * @param string|int|float|null $max Maximum value
	 * @return void
	 */
	public function setMinMax(string|int|float|null $min = null, string|int|float|null $max = null): void {
		if ($this->hasValue($min)) $this->min = $min;
		if ($this->hasValue($max)) $this->max = $max;
	}
	
	/**
	 * Set the min and max length for text input.
	 *
	 * @param int|null $minlen Minimum length
	 * @param int|null $maxlen Maximum length
	 * @return void
	 */
	public function setMinMaxLen(?int $minlen = null, ?int $maxlen = null): void {
		if ($this->hasValue($minlen)) $this->minlen = $minlen;
		if ($this->hasValue($maxlen)) $this->maxlen = $maxlen;
	}
	
	/**
	 * Enable multiple file selection for file input.
	 *
	 * @return void
	 */
	public function enableMultiple(): void {
		$this->multiple = true;
	}
	
	/**
	 * Set the pattern for validating input.
	 *
	 * @param string $pattern Pattern for validation
	 * @return void
	 */
	public function setPattern(string $pattern): void {
		$this->pattern = $pattern;
	}
	
	/**
	 * Set the placeholder text for input.
	 *
	 * @param string $placeholder Placeholder text
	 * @return void
	 */
	public function setPlaceholder(string $placeholder): void {
		$this->placeholder = $this->safeHtml($placeholder);
	}
	
	/**
	 * Set the device type for capture input.
	 *
	 * @param string $device Device type
	 * @return void
	 */
	public function setDevice(string $device): void {
		$this->device = $device;
	}
	
	/**
	 * Show the output element associated with input.
	 *
	 * @return void
	 */
	public function showValue(): void {
		$this->output = new Output();
	}
	
	/**
	 * Add accepted file formats for file input.
	 *
	 * @param string $format Accepted file format
	 * @return void
	 */
	public function addFileformat(string $format): void {
		$this->fileformats[] = $format;
	}
	
	/**
	 * Generate HTML representation of the input element.
	 *
	 * @return string The HTML string representing the input element
	 */
	public function getHtml(): string {
		if ($this->output) {
			$this->output->setLevel($this->level);
			$this->output->setId($this->getId() . '_output');
			$this->output->setInput($this->getId());
			$this->output->value = $this->value;
			if ($this->isHidden()) $this->output->Hide();
		}
		
		if ($this->datalist) {
			$this->datalist->setLevel($this->level);
			$this->datalist->setId($this->getId() . '_list');
		}
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<input'
			. ($this->hasValue($this->type)				? ' type="' . $this->type . '"'									: '')
			. ($this->hasValue($this->alt)				? ' alt="' . $this->alt . '"'									: '')
			. ($this->hasValue($this->src)				? ' src="' . $this->src . '"'									: '')
			. ($this->hasValue($this->value)			? ' value="' . (string)$this->value . '"'						: '')
			. ($this->hasValue($this->parent)			? ' form="' . $this->parent . '"'								: '')
			. ($this->readonly							? ' readonly="readonly"'										: '')
			. ($this->disabled							? ' disabled="disabled"'										: '')
			. ($this->checked							? ' checked="checked"'											: '')
			. ($this->hasValue($this->size)				? ' size="' . (string)$this->size . '"'							: '')
			. ($this->hasValue($this->width)			? ' width="' . (string)$this->width . '"'						: '')
			. ($this->hasValue($this->height)			? ' height="' . (string)$this->height . '"'						: '')
			. ($this->hasValue($this->minlen)			? ' minlength="' . (string)$this->minlen . '"'					: '')
			. ($this->hasValue($this->maxlen)			? ' maxlength="' . (string)$this->maxlen . '"'					: '')
			. ($this->hasValue($this->min)				? ' min="' . (string)$this->min . '"'							: '')
			. ($this->hasValue($this->max)				? ' max="' . (string)$this->max . '"'							: '')
			. ($this->hasValue($this->step)				? ' step="' . $this->step . '"'									: '')
			. ($this->datalist							? ' list="' . $this->getId() . '_list"'							: '')
			. ($this->multiple							? ' multiple="multiple"'										: '')
			. ($this->required							? ' required="required"'										: '')
			. ($this->hasValue($this->autocompletes)	? ' autocomplete="' . implode(' ', $this->autocompletes) . '"'	: '')
			. ($this->hasValue($this->pattern)			? ' pattern="' . $this->pattern . '"'							: '')
			. ($this->hasValue($this->placeholder)		? ' placeholder="' . $this->placeholder . '"'					: '')
			. ($this->output							? ' oninput="' . $this->getId() . '_output.value=value"'		: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. ($this->hasValue($this->fileformats)		? ' accept="' . implode(', ', $this->fileformats) . '"'			: '')
			. ($this->hasValue($this->device)			? ' capture="' . $this->device . '"'							: '')
			. ' />'
			. ($this->output							? $this->output->getHtml()										: '')
			. ($this->datalist							? $this->datalist->getHtml()									: '');
			
		return $_html;
	}
}

?>