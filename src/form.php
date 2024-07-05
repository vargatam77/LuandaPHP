<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a form HTML element.
 */
class form extends global_attr{
    protected ?html_content $content = null; // Content of the form
    protected int $level = 0; // Level of indentation for HTML output
    protected ?string $url = null; // URL to submit form data
    protected ?string $rel = null; // Relationship between current document and linked document
    protected ?string $method = null; // HTTP method for sending form data
    protected ?string $target = null; // Browsing context for form submission result
    protected array $charsets = []; // Accepted charsets for form submission
    protected ?string $enctype = null; // Content type to use for form submission
    public bool $autocomplete = true; // Enable or disable autocomplete for form fields
    public bool $novalidate = false; // Indicates if form should be validated on submit
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor to initialize form with optional URL and method.
     *
     * @param string|null $url    The URL to submit form data.
     * @param string|null $method The HTTP method for sending form data.
     */
    public function __construct(?string $url = null, ?string $method = null) {
        if ($url) {
            $this->url = $url;
        }
        if ($method) {
            $this->method = $method;
        }
    }
    
    /**
     * Set the action URL for form submission.
     *
     * @param string $url The URL to submit form data.
     */
    public function setAction(string $url): void {
        $this->url = $url;
    }
    
    /**
     * Set the HTTP method for form submission.
     *
     * @param string $method The HTTP method for sending form data.
     */
    public function setMethod(string $method): void {
        $this->method = $method;
    }
    
    /**
     * Set the browsing context for form submission result.
     *
     * @param string $target The target browsing context.
     */
    public function setTarget(string $target): void {
        $this->target = $target;
    }
    
    /**
     * Set the content type to use for form submission.
     *
     * @param string $enctype The content type for form submission.
     */
    public function setEncType(string $enctype): void {
        $this->enctype = $enctype;
    }
    
    /**
     * Set the relationship between current document and linked document.
     *
     * @param string $rel The relationship between documents.
     */
    public function setRelation(string $rel): void {
        $this->rel = $rel;
    }
    
    /**
     * Add a charset to the list of accepted charsets for form submission.
     *
     * @param string $charset The charset to add.
     */
    public function addCharset(string $charset): void {
        $this->charsets[] = $charset;
    }
    
    /**
     * Add content to the form element.
     *
     * @param mixed $content The content to add.
     */
    public function addContent($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Add a cloned content to the form element.
     *
     * @param mixed $content The content to clone and add.
     */
    public function addClone($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add(Cloner::getClone($content));
    }
    
    /**
     * Generate HTML representation of the form.
     *
     * @return string The HTML string representing the form.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        $form = "\n{$space}<form"
        . ($this->url ? " action='{$this->url}'" : "")
        . ($this->method ? " method='{$this->method}'" : "")
        . ($this->enctype ? " enctype='{$this->enctype}'" : "")
        . ($this->target ? " target='{$this->target}'" : "")
        . ($this->rel ? " rel='{$this->rel}'" : "")
        . ($this->novalidate ? " novalidate='novalidate'" : "")
        . (isset($this->autocomplete) ? ($this->autocomplete ? " autocomplete='on'" : " autocomplete='off'") : "")
        . $this->getAttributes();
        
        if (!empty($this->charsets)) {
            $form .= " accept-charset='" . implode(' ', $this->charsets) . "'";
        }
        
        $form .= ">"
            . ($this->content ? $this->content->getHtml() : "")
            . "\n{$space}</form>";
            
        return $form;
    }
}
?>