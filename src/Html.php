<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents the top-level HTML document structure.
 */
class Html extends Element {
    public string $lang = 'en'; // Default language
    public string $xmlns = 'http://www.w3.org/1999/xhtml'; // Spite-driven XML namespace
    public ?Head $head = null; // Head section
    public ?Body $body = null; // Body section
    
    /**
     * Constructor for the page.
     *
     * @param string $page_title The title of the page
     */
    public function __construct(string $page_title) {
        $this->head = new Head($page_title);
        $this->body = new Body();
    }
    
    public function setupFontAwesome(): void {
    	// TODO <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
     * @param string $charset The charset (default UTF-8)
     * @return void
     */
    public function setCharset(string $charset = 'UTF-8'): void {
        $meta = new Meta();
        $meta->setCharset($charset);
        $this->addMeta($meta);
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
     * Sets the base URL and target.
     *
     * @param string $url The base URL
     * @param string|null $target Optional target
     * @return void
     */
    public function setBase(string $url, ?string $target = null): void {
        $this->head->base = $url;
        if ($target) $this->head->target = $target;
    }
    
    /**
     * Adds a stylesheet link to the head section.
     *
     * @param string $url The URL of the stylesheet
     * @param string|null $media The media query
     * @return void
     */
    public function addStylesheet(string $url, ?string $media = null): void {
        $this->head->links[] = new Resource('stylesheet', $url, $media);
    }
    
    /**
     * Adds a generic Resource link to the head section.
     *
     * @param Resource $link The link object
     * @return void
     */
    public function addLink(Resource $link): void {
        $this->head->links[] = $link;
    }
    
    /**
     * Adds a meta tag to the head section.
     *
     * @param Meta $meta The meta tag object
     * @return void
     */
    public function addMeta(Meta $meta): void {
        $this->head->metas[] = $meta;
    }
    
    /**
     * Adds a script with specific placement logic.
     *
     * @param string $type Use script_type constants
     * @param string $url_or_code Script source or inline code
     * @param string|null $crossorigin Optional crossorigin
     * @return void
     */
    public function addScript(string $type, string $url_or_code, ?string $crossorigin = null): void {
        $script = new Script($url_or_code, $crossorigin);
        if ($type === 'HEADLINK') $this->head->scripts[] = $script;
        if ($type === 'BODYLINK') $this->body->scripts[] = $script;
        if ($type === 'RUNCMD') $this->body->commands[] = $script;
    }
    
    /**
     * Changes the page title.
     *
     * @param string $new_title The new title string
     * @return void
     */
    public function changeTitle(string $new_title): void {
        $this->head->title->text = $this->safeHtml($new_title);
    }
    
    /**
     * Changes the page title.
     *
     * @param object $content Add a new element to the body
     * @return void
     */
    public function addContent(object $content): void {
        $this->body->addContent($content);
    }
    
    /**
     * Final output of the entire document.
     *
     * @return void
     */
    public function show(): void {
        echo '<!DOCTYPE html>';
        echo "\n" . '<html xmlns="' . $this->xmlns . '" lang="' . $this->lang . '">';
        
        if ($this->head) {
            echo $this->head->getHtml();
        }
        
        if ($this->body) {
            echo $this->body->getHtml();
        }
        
        echo "\n" . '</html>';
    }
}

/**
 * Internal Head structure for the Html class.
 */
class Head extends Element {
    protected Title $title;
    protected ?string $base = null;
    protected ?string $target = null;
    protected int $level = 1;
    public array $links = [];
    public array $scripts = [];
    public array $metas = [];
    
    public function __construct(string $title_text) {
        $this->title = new Title($title_text);
    }
    
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<head>';
        
        $html .= $this->title->getHtml();
        
        if ($this->base || $this->target) {
            $html .= "\n" . $space . "\t" . '<base'
                . ($this->base ? ' href="' . $this->base . '"' : '')
                . ($this->target ? ' target="' . $this->target . '"' : '')
                . ' />';
        }
        
        foreach ($this->metas as $meta) {
            $meta->setLevel($this->level + 1);
            $html .= $meta->getHtml();
        }
        
        foreach ($this->links as $link) {
            $link->setLevel($this->level + 1);
            $html .= $link->getHtml();
        }
        
        foreach ($this->scripts as $script) {
            $script->setLevel($this->level + 1);
            $html .= $script->getHtml();
        }
        
        $html .= "\n" . $space . '</head>';
        
        return $html;
    }
}

/**
 * Internal Body structure for the Html class.
 */
class Body extends Node {
    public array $scripts = [];
    public array $commands = [];
    
    public function getHtml(): string {
        if ($this->content) $this->content->setLevel($this->level);
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<body' . $this->getAttributes() . '>';
        
        if ($this->content) $html .= $this->content->getHtml();
        
        foreach ($this->scripts as $script) {
            $script->setLevel($this->level + 1);
            $html .= $script->getHtml();
        }
        
        foreach ($this->commands as $script) {
            $script->setLevel($this->level + 1);
            $html .= $script->runScript();
        }
        
        $html .= "\n" . $space . '</body>';
        
        return $html;
    }
}

/**
 * Internal Title structure for the Head section.
 */
class Title extends Element {
    public string $text;
    protected int $level = 2;
    
    public function __construct(string $text) {
        $this->text = $this->safeHtml($text);
    }
    
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = ($this->text !== '')
        ? "\n" . $space . '<title>' . $this->text . '</title>'
            : '';
            
            return $html;
    }
}

?>