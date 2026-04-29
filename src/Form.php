<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a form HTML element.
 */
class Form extends Node {
	protected ?string $url				= null;
	protected ?string $rel				= null;
	protected ?string $method			= null;
	protected ?string $target			= null;
	protected ?string $encType			= null;
	protected ?bool $noValidate			= null;
	protected array $autocompletes		= [];
	protected array $charsets			= [];
	
	/**
	 * Constructor to initialize form with optional URL and method.
	 *
	 * @param string|null $url    The URL to submit form data.
	 * @param string|null $method The HTTP method, use form_method:: constants.
	 */
	public function __construct(?string $url = null, ?string $method = null) {
		if ($this->hasValue($url)) $this->setAction($url);
		if ($this->hasValue($method)) $this->setMethod($method);
	}
	
	/**
	 * Set the action URL for form submission.
	 *
	 * @param string $url The URL to submit form data.
	 * @return void
	 */
	public function setAction(string $url): void {
		$this->url = $this->safeUrl($url);
	}
	
	/**
	 * Set the HTTP method for form submission.
	 *
	 * @param string $method The HTTP method, use form_method:: constants.
	 * @return void
	 */
	public function setMethod(string $method): void {
		$this->method = $method;
	}
	
	/**
	 * Set the browsing context for form submission result.
	 *
	 * @param string $target The target browsing context.
	 * @return void
	 */
	public function setTarget(string $target): void {
		$this->target = $target;
	}
	
	/**
	 * Set the content type to use for form submission.
	 *
	 * @param string $enctype The content type, use form_enctype:: constants.
	 * @return void
	 */
	public function setEncType(string $enctype): void {
		$this->encType = $enctype;
	}
	
	/**
	 * Set the relationship between current document and linked document.
	 *
	 * @param string $rel The relationship between documents.
	 * @return void
	 */
	public function setRelation(string $rel): void {
		$this->rel = $rel;
	}
	
	/**
	 * Add a charset to the list of accepted charsets for form submission.
	 * Duplicates are ignored.
	 *
	 * @param string $charsets The charset to add.
	 * @return void
	 */
	public function addCharset(string $charset): void {
		foreach (explode(' ', $charset) as $_charset)
			$this->charsets[$_charset] = $_charset;
	}
	
	/**
	 * add autocomplete tokens
	 *
	 * @param string $autocomplete form_autocomplete::
	 * or custom value
	 * @return void
	 */
	public function addAutocompletes(string $autocompletes): void {
		foreach (explode(' ', $autocompletes) as $_autocomplete)
			$this->autocompletes[$_autocomplete] = $_autocomplete;
	}
	
	/**
	 * Disable client-side validation for the form.
	 *
	 * @return void
	 */
	public function disableValidation(): void {
		$this->noValidate = true;
	}
	
	/**
	 * Generate HTML representation of the form.
	 *
	 * @return string The HTML string representing the form.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<form'
			. ($this->hasValue($this->url)				? ' action="' . $this->url . '"'									: '')
			. ($this->hasValue($this->method)			? ' method="' . $this->method . '"'									: '')
			. ($this->hasValue($this->encType)			? ' enctype="' . $this->encType . '"'								: '')
			. ($this->hasValue($this->target)			? ' target="' . $this->target . '"'									: '')
			. ($this->hasValue($this->rel)				? ' rel="' . $this->rel . '"'										: '')
			. ($this->hasValue($this->noValidate)		? ' novalidate="novalidate"'										: '')
			. ($this->hasValue($this->autocompletes)	? ' autocomplete="' . implode(' ', $this->autocompletes) . '"'		: '')
			. ($this->hasValue($this->charsets)			? ' accept-charset="' . implode(' ', $this->charsets) . '"'			: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</form>';
			
		return $_html;
	}
}

?>