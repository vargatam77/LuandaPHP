<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents the top-level HTML document structure.
 */
class Html extends Element {
	protected string $lang		= 'en';
	protected string $xmlns		= 'http://www.w3.org/1999/xhtml';
	protected ?Head $head		= null;
	protected ?Body $body		= null;
	
	/**
	 * Constructor for the page.
	 *
	 * @param string $pagetitle The title of the page.
	 */
	public function __construct(string $pagetitle) {
		$this->head = new Head($pagetitle);
		$this->body = new Body();
	}
	
	/**
	 * Sets the language attribute of the HTML element.
	 *
	 * @param string $lang The language code to set.
	 * @return void
	 */
	public function setLang(string $lang): void {
		$this->lang = $lang;
	}
	
	/**
	 * Sets the xmlns attribute of the HTML element.
	 *
	 * @param string $xmlns The xmlns value to set.
	 * @return void
	 */
	public function setXmlns(string $xmlns): void {
		$this->xmlns = $xmlns;
	}
	
	/**
	 * Sets up Font Awesome via CDN stylesheet.
	 * Free tier only — no API key required.
	 * For Pro icons, set up your own stylesheet via addStylesheet().
	 *
	 * @return void
	 */
	public function setupFontAwesome(): void {
		$this->addStylesheet('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css');
	}
	
	/**
	 * Sets up Tailwind CSS via CDN.
	 *
	 * @return void
	 */
	public function setupTailwind(): void {
		$this->addScript(script_type::HEADLINK, 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4');
	}
	
	/**
	 * Sets up Bootstrap via CDN.
	 *
	 * @return void
	 */
	public function setupBootstrap(): void {
		$this->addScript(script_type::HEADLINK, 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js');
		$this->addStylesheet('https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css');
	}
	
	/**
	 * Sets up meta tags for mobile devices.
	 *
	 * @return void
	 */
	public function setupMobile(): void {
		$this->addMeta(new Meta('viewport', 'height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no'));
	}
	
	/**
	 * Sets the charset meta tag.
	 *
	 * @param string $charset The charset, defaults to UTF-8.
	 * @return void
	 */
	public function setCharset(string $charset = charset::UTF8): void {
		$_meta = new Meta();
		$_meta->setCharset($charset);
		$this->addMeta($_meta);
	}
	
	/**
	 * Sets meta tags to prevent caching.
	 *
	 * @return void
	 */
	public function setNoCache(): void {
		$this->addMeta(new Meta('Cache-Control', 'no-cache, no-store, must-revalidate'));
		$this->addMeta(new Meta('Pragma', 'no-cache'));
		$this->addMeta(new Meta('Expires', '0'));
	}
	
	/**
	 * Sets the base URL for the page.
	 *
	 * @param string $url The base URL.
	 * @return void
	 */
	public function setBaseUrl(string $url): void {
		$this->head->setBaseUrl($url);
	}
	
	/**
	 * Sets the base target for the page.
	 *
	 * @param string $target The base target.
	 * @return void
	 */
	public function setBaseTarget(string $target): void {
		$this->head->setBaseTarget($target);
	}
	
	/**
	 * Adds a stylesheet link to the head section.
	 *
	 * @param string      $url   The URL of the stylesheet.
	 * @param string|null $media Optional media query.
	 * @return void
	 */
	public function addStylesheet(string $url, ?string $media = null): void {
		$this->head->addLink(new Resource('stylesheet', $url, $media));
	}
	
	/**
	 * Adds a generic Resource link to the head section.
	 *
	 * @param Resource $link The link object.
	 * @return void
	 */
	public function addLink(Resource $link): void {
		$this->head->addLink($link);
	}
	
	/**
	 * Adds a meta tag to the head section.
	 *
	 * @param Meta $meta The meta tag object.
	 * @return void
	 */
	public function addMeta(Meta $meta): void {
		$this->head->addMeta($meta);
	}
	
	/**
	 * Adds a script with specific placement logic.
	 *
	 * @param int         $type        Use script_type constants.
	 * @param string      $urlorcode   Script source URL or inline code.
	 * @param string|null $crossorigin Optional crossorigin attribute.
	 * @return void
	 */
	public function addScript(int $type, string $urlorcode, ?string $crossorigin = null): void {
		$_script = new Script($urlorcode, $crossorigin);
		
		match ($type) {
			script_type::HEADLINK => $this->head->addScript($_script),
			script_type::BODYLINK => $this->body->addScript($_script),
			script_type::RUNCMD   => $this->body->addCommand($_script)
		};
	}
	
	/**
	 * Changes the page title.
	 *
	 * @param string $newtitle The new title string.
	 * @return void
	 */
	public function changeTitle(string $newtitle): void {
		$this->head->setTitle($newtitle);
	}
	
	/**
	 * Adds a new element to the body.
	 *
	 * @param INodeInterface $content The content element to add.
	 * @return void
	 */
	public function addContent(INodeInterface $content): void {
		$this->body->addContent($content);
	}
	
	/**
	 * Final output of the entire document.
	 *
	 * @return void
	 */
	public function Show(): void {
		echo '<!DOCTYPE html>';
		echo special_chars::NEWLINE . '<html xmlns="' . $this->xmlns . '" lang="' . $this->lang . '">';
		
		if ($this->hasValue($this->head)) $this->head->Show();
		if ($this->hasValue($this->body)) $this->body->Show();
		
		echo special_chars::NEWLINE . '</html>';
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Internal Head structure for the Html class.
 */
class Head extends Element {
	protected Title $title;
	protected ?Base $base		= null;	// Base element
	protected int $level		= 1;
	protected array $links		= [];	// Stylesheet and resource links
	protected array $scripts	= [];	// Head scripts
	protected array $metas		= [];	// Meta tags
	
	/**
	 * Constructor for the Head element.
	 *
	 * @param string $titletext The page title.
	 */
	public function __construct(string $titletext = 'No Title') {
		$this->title = new Title($titletext);
	}
	
	/**
	 * Sets the page title.
	 *
	 * @param string $titletext The new title text.
	 * @return void
	 */
	public function setTitle(string $titletext): void {
		$this->title = new Title($titletext);
	}
	
	/**
	 * Sets the base URL.
	 *
	 * @param string $url The base URL.
	 * @return void
	 */
	public function setBaseUrl(string $url): void {
		if (!$this->hasValue($this->base)) $this->base = new Base();
		$this->base->setUrl($url);
	}
	
	/**
	 * Sets the base target.
	 *
	 * @param string $target The base target, use target_type constants.
	 * @return void
	 */
	public function setBaseTarget(string $target): void {
		if (!$this->hasValue($this->base)) $this->base = new Base();
		$this->base->setTarget($target);
	}
	
	/**
	 * Adds a Resource link to the head.
	 *
	 * @param Resource $link The link object.
	 * @return void
	 */
	public function addLink(Resource $link): void {
		$this->links[] = $link;
	}
	
	/**
	 * Adds a meta tag to the head.
	 *
	 * @param Meta $meta The meta object.
	 * @return void
	 */
	public function addMeta(Meta $meta): void {
		$this->metas[] = $meta;
	}
	
	/**
	 * Adds a script to the head.
	 *
	 * @param Script $script The script object.
	 * @return void
	 */
	public function addScript(Script $script): void {
		$this->scripts[] = $script;
	}
	
	/**
	 * Output the <head> section directly to the browser.
	 *
	 * @return void
	 */
	public function Show(): void {
		echo $this->getHtml();
	}
	
	/**
	 * Generate the HTML representation of the <head> element.
	 *
	 * @return string The HTML representation of the head element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<head>'
			. ($this->hasValue($this->base) ? $this->base->getHtml() : '')
			. $this->title->getHtml();
			
		foreach ($this->metas as $_meta) {
			$_meta->setLevel($this->level + 1);
			$_html .= $_meta->getHtml();
		}
		
		foreach ($this->links as $_link) {
			$_link->setLevel($this->level + 1);
			$_html .= $_link->getHtml();
		}
		
		foreach ($this->scripts as $_script) {
			$_script->setLevel($this->level + 1);
			$_html .= $_script->getHtml();
		}
		
		$_html .= special_chars::NEWLINE
			. $_indent . '</head>';
		
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Internal Body structure for the Html class.
 */
class Body extends Node {
	protected int $level		= 1;
	protected array $scripts	= [];	// Body scripts
	protected array $commands	= [];	// Inline run commands
	
	/**
	 * Constructor for the Body element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Adds a script to the body.
	 *
	 * @param Script $script The script object.
	 * @return void
	 */
	public function addScript(Script $script): void {
		$this->scripts[] = $script;
	}
	
	/**
	 * Adds a command script to the body.
	 *
	 * @param Script $script The script object.
	 * @return void
	 */
	public function addCommand(Script $script): void {
		$this->commands[] = $script;
	}
	
	/**
	 * Generate the HTML representation of the <body> element.
	 *
	 * @return string The HTML representation of the body element.
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
		. $_indent . '<body'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml();
			
			foreach ($this->scripts as $_script) {
				$_script->setLevel($this->level + 1);
				$_html .= $_script->getHtml();
			}
			
			foreach ($this->commands as $_script) {
				$_script->setLevel($this->level + 1);
				$_html .= $_script->runScript();
			}
			
			$_html .= special_chars::NEWLINE
				. $_indent . '</body>';
			
			return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Internal Title structure for the Head section.
 */
class Title extends Element {
	protected string $text;
	protected int $level	= 2;
	
	/**
	 * Constructor for the Title element.
	 *
	 * @param string $text The title text.
	 */
	public function __construct(string $text) {
		$this->text = $this->safeHtml($text);
	}
	
	/**
	 * Generate the HTML representation of the <title> element.
	 *
	 * @return string The HTML representation of the title element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<title>'
			. $this->text
			. '</title>';
			
		return $_html;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Internal Base structure for the Head section.
 */
class Base extends Element {
	protected ?string $url		= null;		// Base URL
	protected ?string $target	= null;		// Base target
	protected int $level		= 2;
	
	/**
	 * Constructor for the Base element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Sets the base URL.
	 *
	 * @param string $url The base URL.
	 * @return void
	 */
	public function setUrl(string $url): void {
		$this->url = $this->safeUrl($url);
	}
	
	/**
	 * Sets the base target.
	 *
	 * @param string $target The base target, use target_type constants.
	 * @return void
	 */
	public function setTarget(string $target): void {
		$this->target = $target;
	}
	
	/**
	 * Generate the HTML representation of the <base> element.
	 *
	 * @return string The HTML representation of the base element.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<base'
			. ($this->hasValue($this->url)		? ' href="'		. $this->url	. '"' : '')
			. ($this->hasValue($this->target)	? ' target="'	. $this->target	. '"' : '')
			. ' />';
			
		return $_html;
	}
}

?>