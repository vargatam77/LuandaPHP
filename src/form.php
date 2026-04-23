<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a form HTML element.
 */
class Form extends Node {
    protected ?string $url = null; // URL to submit form data
    protected ?string $rel = null; // Relationship between documents
    protected ?string $method = null; // HTTP method for sending form data
    protected ?string $target = null; // Browsing context for result
    protected array $charsets = []; // Accepted charsets for submission
    protected ?string $enctype = null; // Content type for submission
    public bool $autocomplete = true; // Enable or disable autocomplete
    public bool $novalidate = false; // Indicates if form should be validated
    
    /**
     * Constructor to initialize form with optional URL and method.
     *
     * @param string|null $url The URL to submit form data
     * @param string|null $method The HTTP method for sending form data
     */
    public function __construct(?string $url = null, ?string $method = null) {
        if ($url) $this->url = $this->safeUrl($url);
        if ($method) $this->method = $method;
    }
    
    /**
     * Set the action URL for form submission.
     *
     * @param string $url The URL to submit form data
     * @return void
     */
    public function setAction(string $url): void {
        $this->url = $this->safeUrl($url);
    }
    
    /**
     * Set the HTTP method for form submission.
     *
     * @param string $method The HTTP method for sending form data
     * @return void
     */
    public function setMethod(string $method): void {
        $this->method = $method;
    }
    
    /**
     * Set the browsing context for form submission result.
     *
     * @param string $target The target browsing context
     * @return void
     */
    public function setTarget(string $target): void {
        $this->target = $target;
    }
    
    /**
     * Set the content type to use for form submission.
     *
     * @param string $enctype The content type for form submission
     * @return void
     */
    public function setEncType(string $enctype): void {
        $this->enctype = $enctype;
    }
    
    /**
     * Set the relationship between current document and linked document.
     *
     * @param string $rel The relationship between documents
     * @return void
     */
    public function setRelation(string $rel): void {
        $this->rel = $rel;
    }
    
    /**
     * Add a charset to the list of accepted charsets for form submission.
     *
     * @param string $charset The charset to add
     * @return void
     */
    public function addCharset(string $charset): void {
        $this->charsets[] = $charset;
    }
    
    /**
     * Generate HTML representation of the form.
     *
     * @return string The HTML string representing the form
     */
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<form'
            . ($this->url ? ' action="' . $this->url . '"' : '')
            . ($this->method ? ' method="' . $this->method . '"' : '')
            . ($this->enctype ? ' enctype="' . $this->enctype . '"' : '')
            . ($this->target ? ' target="' . $this->target . '"' : '')
            . ($this->rel ? ' rel="' . $this->rel . '"' : '')
            . ($this->novalidate ? ' novalidate="novalidate"' : '')
            . ($this->autocomplete ? ' autocomplete="on"' : ' autocomplete="off"')
            . (count($this->charsets) > 0 ? ' accept-charset="' . implode(' ', $this->charsets) . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</form>';
            
        return $html;
    }
}

?>