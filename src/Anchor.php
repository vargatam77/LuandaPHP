<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Class Anchor
 *
 * Represents a hyperlink (<a>) element with various attributes.
 */
class Anchor extends Node {
	protected ?string $url				= null; // href attribute
	protected ?string $target			= null; // Target attribute
	protected ?string $rel				= null; // Relationship attribute
	protected ?string $type				= null; // MIME type attribute
	protected ?string $hreflang			= null; // Language of linked resource
	protected ?string $referrerpolicy	= null; // Referrer policy
	protected array $ping				= [];	// Space-separated list of URLs to ping
	protected ?string $download			= null;	// Suggested download filename
	
	/**
	 * Constructor for the Anchor element.
	 *
	 * @param string|null $url Optional URL
	 */
	public function __construct(?string $url = null) {
		if ($this->hasValue($url))
			$this->setUrl($url);
	}
	
	/**
	 * Sets the href URL of the hyperlink.
	 *
	 * @param string $url The URL to set.
	 * @return void
	 */
	public function setUrl(string $url): void {
		$this->url = $this->safeUrl($url);
	}
	
	/**
	 * Sets the target attribute of the hyperlink.
	 *
	 * @param string $target The target attribute value. Use link_target constants.
	 * @return void
	 */
	public function setTarget(string $target): void {
		$this->target = $target;
	}
	
	/**
	 * Sets the rel (relationship) attribute of the hyperlink.
	 *
	 * @param string $rel The rel attribute value. Use anchor_rel constants.
	 * @return void
	 */
	public function setRelation(string $rel): void {
		$this->rel = $rel;
	}
	
	/**
	 * Sets the type (MIME type) attribute of the hyperlink.
	 *
	 * @param string $type The MIME type of the linked resource.
	 * @return void
	 */
	public function setType(string $type): void {
		$this->type = $type;
	}
	
	/**
	 * Make the link trigger a file download.
	 *
	 * @param string $filename Optional suggested filename.
	 * @return void
	 */
	public function setDownload(string $filename = ''): void {
		$this->download = $this->safeHtml($filename);
	}
	
	/**
	 * Sets the hreflang attribute indicating the language of the linked resource.
	 *
	 * @param string $lang A BCP 47 language tag, e.g. 'en', 'hu', 'fr-CA'.
	 * @return void
	 */
	public function setHreflang(string $lang): void {
		$this->hreflang = $lang;
	}
	
	/**
	 * Sets the ping attribute — space-separated URLs notified when link is followed.
	 *
	 * @param string $urls Space-separated list of URLs.
	 * @return void
	 */
	public function setPing(string $urls): void {
		foreach (explode(' ', $urls) as $_url)
			$this->ping[$_url] = $_url;
	}
	
	/**
	 * Sets the referrerpolicy attribute.
	 *
	 * @param string $policy The referrer policy. Use anchor_referrerpolicy constants.
	 * @return void
	 */
	public function setReferrerpolicy(string $policy): void {
		$this->referrerpolicy = $policy;
	}
	
	/**
	 * Generates the HTML representation of the hyperlink.
	 *
	 * @return string The HTML representation of the hyperlink.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString()
			. $_indent . '<a'
			. ($this->hasValue($this->url)              ? ' href="' . $this->url . '"'													: '')
			. ($this->hasValue($this->target)           ? ' target="' . $this->target . '"'												: '')
			. ($this->hasValue($this->rel)              ? ' rel="' . $this->rel . '"'													: '')
			. ($this->hasValue($this->type)             ? ' type="' . $this->type . '"'													: '')
			. ($this->hasValue($this->hreflang)         ? ' hreflang="' . $this->hreflang . '"'											: '')
			. ($this->hasValue($this->referrerpolicy)   ? ' referrerpolicy="' . $this->referrerpolicy . '"'								: '')
			. ($this->hasValue($this->ping)				? ' ping="' . implode(' ', $this->ping) . '"'									: '')
			. ($this->hasValue($this->download)			? ' download' . ($this->download !== '' ? '="' . $this->download . '"' : '')	: '')
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. Element::getNewlineString()
			. $_indent . '</a>';
			
		return $_html;
	}
}

?>