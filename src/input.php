<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents an input HTML element.
 */
class input extends global_attr {
    protected int $level = 0; // Level of indentation for HTML output
    protected ?string $parent = null; // Parent form ID for the input
    protected ?string $alt = null; // Alternate text for the input
    protected ?string $src = null; // Source URL for image inputs
    protected ?int $width = null; // Width of image inputs
    protected ?int $height = null; // Height of image inputs
    public ?string $value = null; // Value attribute of the input
    public bool $readonly = false; // Indicates if the input is readonly
    public bool $required = false; // Indicates if the input is required
    protected ?string $type = null; // Type of the input
    protected bool $disabled = false; // Indicates if the input is disabled
    protected ?int $size = null; // Size of the input
    protected ?int $minlen = null; // Minimum length for text input
    protected ?int $maxlen = null; // Maximum length for text input
    protected ?string $min = null; // Minimum value for number input
    protected ?string $max = null; // Maximum value for number input
    protected bool $multiple = false; // Indicates if multiple files can be selected
    protected ?string $pattern = null; // Pattern for validating input
    protected ?string $placeholder = null; // Placeholder text for input
    protected ?string $step = null; // Step value for number input
    protected bool $focused = false; // Indicates if the input is focused
    protected bool $checked = false; // Indicates if the input is checked
    protected array $fileformats = []; // Accepted file formats for file input
    protected ?string $device = null; // Device type for capture input
    public ?string $autocomplete = null; // Autocomplete attribute for input
    protected ?output $output = null; // Output element associated with input
    protected ?datalist $datalist = null; // Datalist element associated with input
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the input element.
     *
     * @param string|null $type Type of the input.
     */
    public function __construct(?string $type) {
        $this->type = $type;
    }
    
    /**
     * Disable the input element.
     */
    public function disable(): void {
        $this->disabled = true;
    }
    
    /**
     * Set focus on the input element.
     */
    public function focus(): void {
        $this->focused = true;
    }
    
    /**
     * Check the input element.
     */
    public function check(): void {
        $this->checked = true;
    }
    
    /**
     * Add an element to the datalist associated with the input.
     *
     * @param mixed $element Element to add to the datalist.
     */
    public function addElement($element): void {
        if (!$this->datalist) {
            $this->datalist = new datalist();
        }
        
        $this->datalist->addElement($element);
    }
    
    /**
     * Set the size attribute for the input.
     *
     * @param int $size Size of the input.
     */
    public function setLength(int $size): void {
        $this->size = $size;
    }
    
    /**
     * Set the parent form ID for the input.
     *
     * @param string $form_id Parent form ID for the input.
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Set the size of the image input.
     *
     * @param int $width Width of the image.
     * @param int $height Height of the image.
     */
    public function setImgSize(int $width, int $height): void {
        $this->width = $width;
        $this->height = $height;
    }
    
    /**
     * Set the step value for number input.
     *
     * @param string $step Step value for number input.
     */
    public function setStep(string $step): void {
        $this->step = $step;
    }
    
    /**
     * Set the alternate text for the input.
     *
     * @param string $alt Alternate text for the input.
     */
    public function setAlt(string $alt): void {
        $this->alt = $alt;
    }
    
    /**
     * Set the source URL for image input.
     *
     * @param string $url Source URL for image input.
     */
    public function setSource(string $url): void {
        $this->src = $url;
    }
    
    /**
     * Set the min and max values for number input.
     *
     * @param string|null $min Minimum value for number input.
     * @param string|null $max Maximum value for number input.
     */
    public function setMinMax(?string $min = null, ?string $max = null): void {
        if ($min) {
            $this->min = $min;
        }
        if ($max) {
            $this->max = $max;
        }
    }
    
    /**
     * Set the min and max length for text input.
     *
     * @param int|null $minlen Minimum length for text input.
     * @param int|null $maxlen Maximum length for text input.
     */
    public function setMinMaxLen(?int $minlen = null, ?int $maxlen = null): void {
        if ($minlen) {
            $this->minlen = $minlen;
        }
        if ($maxlen) {
            $this->maxlen = $maxlen;
        }
    }
    
    /**
     * Enable multiple file selection for file input.
     */
    public function enableMultiple(): void {
        $this->multiple = true;
    }
    
    /**
     * Set the pattern for validating input.
     *
     * @param string $pattern Pattern for validating input.
     */
    public function setPattern(string $pattern): void {
        $this->pattern = $pattern;
    }
    
    /**
     * Set the placeholder text for input.
     *
     * @param string $placeholder Placeholder text for input.
     */
    public function setPlaceholder(string $placeholder): void {
        $this->placeholder = $placeholder;
    }
    
    /**
     * Set the device type for capture input.
     *
     * @param string $device Device type for capture input.
     */
    public function setDevice(string $device): void {
        $this->device = $device;
    }
    
    /**
     * Show the output element associated with input.
     */
    public function showValue(): void {
        $this->output = new output($this->getId() . "_output", $this->value);
        if ($this->isHidden()) {
            $this->output->hide();
        }
    }
    
    /**
     * Add accepted file formats for file input.
     *
     * @param mixed $format Accepted file format(s).
     */
    public function addFileformat($format): void {
        if (is_array($format)) {
            $this->fileformats = array_merge($this->fileformats, $format);
        } else {
            $this->fileformats[] = $format;
        }
    }
    
    /**
     * Hide the input and its associated output element.
     */
    public function hide(): void {
        parent::hide();
        if ($this->output) {
            $this->output->hide();
        }
    }
    
    /**
     * Get the accepted file formats as a comma-separated string.
     *
     * @return string Accepted file formats.
     */
    public function getFormats(): string {
        return implode(", ", $this->fileformats);
    }
    
    /**
     * Generate HTML representation of the input element.
     *
     * @return string The HTML string representing the input element.
     */
    public function getHtml(): string {
        if ($this->output) {
            $this->output->setLevel($this->level);
        }
        if ($this->datalist) {
            $this->datalist->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $input = "\n" . $space . "<input"
            . (($this->type) ? " type='" . $this->type . "'" : "")
            . (($this->alt) ? " alt='" . $this->alt . "'" : "")
            . (($this->src) ? " src='" . $this->src . "'" : "")
            . (($this->value) ? " value='" . $this->value . "'" : "")
            . (($this->parent) ? " form='" . $this->parent . "'" : "")
            . (($this->readonly) ? " readonly='readonly'" : "")
            . (($this->disabled) ? " disabled='disabled'" : "")
            . (($this->checked) ? " checked='checked'" : "")
            . (($this->size) ? " size='" . $this->size . "'" : "")
            . (($this->width) ? " width='" . $this->width . "'" : "")
            . (($this->height) ? " height='" . $this->height . "'" : "")
            . (($this->minlen) ? " minlength='" . $this->minlen . "'" : "")
            . (($this->maxlen) ? " maxlength='" . $this->maxlen . "'" : "")
            . (($this->min) ? " min='" . $this->min . "'" : "")
            . (($this->max) ? " max='" . $this->max . "'" : "")
            . (($this->step) ? " step='" . $this->step . "'" : "")
            . (($this->datalist) ? " list='" . $this->getId() . "_list'" : "")
            . (($this->multiple) ? " multiple='multiple'" : "")
            . (($this->required) ? " required='required'" : "")
            . (($this->focused) ? " autofocus='autofocus'" : "")
            . ((isset($this->autocomplete)) ? (($this->autocomplete) ? " autocomplete='on'" : " autocomplete='off'") : "")
            . (($this->pattern) ? " pattern='" . $this->pattern . "'" : "")
            . (($this->placeholder) ? " placeholder='" . $this->placeholder . "'" : "")
            . (($this->output) ? " oninput='" . $this->getId() . "_output.value=value'" : "")
            
            . $this->getAttributes()
            
            . (($this->fileformats) ? " accept='" . $this->getFormats() ."'" : "")
            . (($this->device) ? " capture='" . $this->device ."'" : "")
            
            . "/>"
                
            . (($this->output) ? $this->output->getHtml() : "")
                
            . (($this->datalist) ? $this->datalist->getHtml() : "");
                
        return $input;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents an output HTML element.
 */
class output extends global_attr {
    protected int $level = 0; // Level of indentation for HTML output
    protected ?input $input = null; // Input element associated with output
    protected ?string $parent = null; // Parent form ID for the output
    public ?string $value = null; // Value attribute of the output
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the output element.
     *
     * @param string|null $value Value to display in the output.
     */
    public function __construct(?string $value) {
        $this->value = $value;
    }
    
    /**
     * Set the associated input element ID for the output.
     *
     * @param string $input_id ID of the associated input element.
     */
    public function setInput(string $input_id): void {
        $this->input = $input_id;
    }
    
    /**
     * Set the parent form ID for the output.
     *
     * @param string $form_id Parent form ID for the output.
     */
    public function setParent(string $form_id): void {
        $this->parent = $form_id;
    }
    
    /**
     * Generate HTML representation of the output element.
     *
     * @return string The HTML string representing the output element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $output = "\n" . $space . "<output"
            . (($this->parent) ? " form='" . $this->parent . "'" : "")
            . (($this->input) ? " for='" . $this->input . "'" : "")
            . $this->getAttributes()
            . ">" . $this->value . "</output>";
            
            return $output;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------


/**
 * Represents a datalist HTML element.
 */
class datalist extends global_attr {
    protected int $level = 0; // Level of indentation for HTML output
    protected array $list = []; // List of options for the datalist
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the datalist element.
     */
    public function __construct() {
    }
    
    /**
     * Add an element or array of elements to the datalist.
     *
     * @param mixed $element Element(s) to add to the datalist.
     */
    public function addElement($element): void {
        if (is_array($element)) {
            $this->list = array_merge($this->list, $element);
        } else {
            $this->list[] = $element;
        }
    }
    
    /**
     * Generate HTML representation of the datalist element.
     *
     * @return string The HTML string representing the datalist element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $datalist = "\n" . $space . "<datalist>";
        foreach ($this->list as $data) {
            $datalist .= "\n" . $space . "\t<option value='" . $data . "'/>";
        }
        $datalist .= "\n" . $space . "</datalist>";
        
        return $datalist;
    }
}

?>