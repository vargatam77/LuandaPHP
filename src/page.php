<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class page
 * Represents an HTML page with head and body sections.
 */
class page {
    public string $lang = "en";         // Default language
    public string $xmlns = "http://www.w3.org/1999/xhtml";  // XML namespace
    public ?head $head = null;         // Head section of the page
    public ?body $body = null;          // Body section of the page
    
    /**
     * Constructor.
     * Initializes the page with a title for the head section and an empty body.
     *
     * @param string $page_title The title of the page
     */
    public function __construct(string $page_title) {
        $this->head = new head($page_title);
        $this->body = new body();
    }
    
    /**
     * Sets up meta tags for mobile devices.
     */
    public function setupMobile(): void {
        $this->addMeta(new meta("viewport", "height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"));
    }
    
    /**
     * Sets the charset meta tag.
     *
     * @param string $charset The charset to set
     */
    public function setCharset(string $charset): void {
        $meta = new meta();
        $meta->setCharset(charset::UTF8);
        $this->addMeta($meta);
    }
    
    /**
     * Sets meta tags to prevent caching.
     */
    public function setNoCache(): void {
        $this->addMeta(new meta("Cache-Control", "no-cache, no-store, must-revalidate"));
        $this->addMeta(new meta("Pragma", "no-cache"));
        $this->addMeta(new meta("Expires", "0"));
    }
    
    /**
     * Sets the <base> tag.
     *
     * @param string $base The base URL
     */
    public function setBase(string $base): void {
        $this->head->base = $base;
    }
    
    /**
     * Sets the target attribute for the <base> tag.
     *
     * @param string $target The target attribute value
     */
    public function setBasetarget(string $target): void {
        $this->head->target = $target;
    }
    
    /**
     * Adds a stylesheet link to the head section.
     *
     * @param string $url The URL of the stylesheet
     * @param string|null $media The media attribute (optional)
     */
    public function addStylesheet(string $url, ?string $media = null): void {
        $link = new link("stylesheet", $url, $media);
        $this->head->links[] = $link;
    }
    
    /**
     * Adds a generic link to the head section.
     *
     * @param link $link The link object to add
     */
    public function addLink(link $link): void {
        $this->head->links[] = $link;
    }
    
    /**
     * Adds a meta tag to the head section.
     *
     * @param meta $meta The meta tag object to add
     */
    public function addMeta(meta $meta): void {
        $this->head->metas[] = $meta;
    }
    
    /**
     * Adds a script to either the head or body section based on type.
     *
     * @param string $type The type of script placement (HEADLINK, BODYLINK, RUNCMD)
     * @param string $url The URL of the script
     * @param string|null $crossorigin The crossorigin attribute (optional)
     */
    public function addScript(string $type, string $url, ?string $crossorigin = null): void {
        $script = new script($url, $crossorigin);
        switch ($type) {
            case script_type::HEADLINK:
                $this->head->scripts[] = $script;
                break;
            case script_type::BODYLINK:
                $this->body->scripts[] = $script;
                break;
            case script_type::RUNCMD:
                $this->body->commands[] = $script;
                break;
        }
    }
    
    /**
     * Adds content to the body section.
     *
     * @param mixed $content The content to add
     */
    public function addContent($content): void {
        $this->body->addContent($content);
    }
    
    /**
     * Adds a cloned content to the body section.
     *
     * @param mixed $content The content to clone and add
     */
    public function addClone($content): void {
        $this->body->addContent(Cloner::getClone($content));
    }
    
    /**
     * Sets the favicon icon link.
     *
     * @param string $url The URL of the favicon
     */
    public function setIcon(string $url): void {
        $link = new link("icon", $url);
        $this->head->links[] = $link;
    }
    
    /**
     * Changes the title of the page.
     *
     * @param string $new_title The new title of the page
     */
    public function changeTitle(string $new_title): void {
        $this->head->title->text = $new_title;
    }
    
    /**
     * Displays the HTML representation of the page.
     */
    public function Show(): void {
        echo "<!DOCTYPE html>";
        echo "\n<html xmlns='" . $this->xmlns . "' lang='" . $this->lang . "'>";
        if ($this->head) {
            echo $this->head->getHead();
        }
        if ($this->body) {
            echo $this->body->getBody();
        }
        echo "\n</html>";
    }
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Class head
 * Represents the head section of an HTML page.
 */
class head {
    public title $title;           // Title of the page
    public ?string $base = null;   // Base URL for relative links
    public ?string $target = null; // Target attribute for the base tag
    public array $links = [];      // Array of link elements
    public array $scripts = [];    // Array of script elements
    public array $metas = [];      // Array of meta elements
    protected int $level = 0;        // Indentation level
    
    /**
     * Constructor.
     *
     * @param string $title_text The text for the title tag
     */
    public function __construct(string $title_text) {
        $this->title = new title($title_text);
    }
    
    /**
     * Generates the HTML representation of the head section.
     *
     * @return string The HTML representation of the head section
     */
    public function getHead(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $head = "\n{$space}<head>"
        . $this->title->getTitle()
        . (($this->base || $this->target) ? "<base" : "")
        . (($this->base) ? " href='{$this->base}'" : "")
        . (($this->target) ? " target='{$this->target}'" : "")
        . (($this->base || $this->target) ? ">" : "");
        
        foreach ($this->metas as $meta) {
            $head .= $meta->getMeta();
        }
        foreach ($this->links as $link) {
            $head .= $link->getLink();
        }
        foreach ($this->scripts as $script) {
            $head .= $script->getScript();
        }
        
        $head .= "\n{$space}</head>";
        
        return $head;
    }
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Class body
 * Represents the body section of an HTML page.
 */
class body extends global_attr {
    protected ?html_content $content = null;  // Content of the body
    public array $scripts = [];             // Array of script elements
    public array $commands = [];            // Array of command scripts
    protected int $level = 0;                 // Indentation level
    
    /**
     * Constructor.
     */
    public function __construct() {
    }
    
    /**
     * Adds content to the body section.
     *
     * @param mixed $content The content to add
     */
    public function addContent($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Generates the HTML representation of the body section.
     *
     * @return string The HTML representation of the body section
     */
    public function getBody(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $body = "\n{$space}<body"
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "");
            
        foreach ($this->scripts as $script) {
            $body .= $script->getScript();
        }
        
        foreach ($this->commands as $script) {
            $body .= $script->runScript();
        }
            
        $body .= "\n{$space}</body>";
            
        return $body;
    }
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Class title
 * Represents the title tag of an HTML page.
 */
class title {
    public ?string $text;   // Text of the title
    protected int $level = 1; // Indentation level
    
    /**
     * Constructor.
     *
     * @param string $title_text The text for the title tag
     */
    public function __construct(string $title_text) {
        $this->text = ($title_text) ? $title_text : "";
    }
    
    /**
     * Generates the HTML representation of the title tag.
     *
     * @return string The HTML representation of the title tag
     */
    public function getTitle(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $title = ($this->text != "")
        ? "\n{$space}<title>{$this->text}</title>"
        : "";
        
        return $title;
    }
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Class link
 * Represents a link tag (<link>) for stylesheets or icons in the head section.
 */
class link {
    protected ?string $id = null;     // ID attribute of the link
    protected string $rel;            // Relationship attribute of the link
    protected string $href;           // Href attribute of the link
    protected ?media $media = null;   // Media attribute of the link
    protected int $level = 1;         // Indentation level
    
    /**
     * Constructor.
     *
     * @param string $rel The relationship attribute value
     * @param string $href The href attribute value
     * @param string|null $media The media attribute value (optional)
     */
    public function __construct(string $rel, string $href, ?string $media = null) {
        $this->rel = $rel;
        $this->href = $href;
        $this->media = ($media) ? new media($media) : null;
    }
    
    /**
     * Sets the ID attribute of the link.
     *
     * @param string $id The ID attribute value
     */
    public function setId(string $id): void {
        $this->id = $id;
    }
    
    /**
     * Sets the media attribute of the link.
     *
     * @param string $media The media attribute value
     */
    public function setMedia(string $media): void {
        $this->media = new media($media);
    }
    
    /**
     * Generates the HTML representation of the link tag.
     *
     * @return string The HTML representation of the link tag
     */
    public function getLink(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $link = "\n{$space}<link rel='{$this->rel}' href='{$this->href}'"
            . (($this->rel == "icon") ? " type='image/gif'" : "")
            . (($this->media) ? " media='{$this->media->getMedia()}'" : "")
            . "/>";
        
        return $link;
    }
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Class script
 * Represents a script tag (<script>) for JavaScript files or inline scripts.
 */
class script {
    protected ?string $src = null;        // Src attribute of the script
    protected ?string $type = null;       // Type attribute of the script
    protected ?string $crossorigin = null;// Crossorigin attribute of the script
    protected int $level = 1;             // Indentation level
    
    /**
     * Constructor.
     *
     * @param string $src The src attribute value
     * @param string|null $crossorigin The crossorigin attribute value (optional)
     */
    public function __construct(string $src, ?string $crossorigin = null) {
        $this->src = $src;
        $this->crossorigin = $crossorigin;
    }
    
    /**
     * Sets the crossorigin attribute of the script.
     *
     * @param string $origin The crossorigin attribute value
     */
    public function setOrigin(string $origin): void {
        $this->crossorigin = $origin;
    }
    
    /**
     * Generates the HTML representation of an inline script.
     *
     * @return string The HTML representation of the inline script
     */
    public function runScript(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $script = "\n{$space}<script type='text/javascript'>{$this->src}</script>";
        
        return $script;
    }
    
    /**
     * Generates the HTML representation of the script tag.
     *
     * @return string The HTML representation of the script tag
     */
    public function getScript(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $script = "\n{$space}<script"
            . ((!$this->crossorigin) ? " type='text/javascript'" : "")
            . " src='{$this->src}'"
            . (($this->crossorigin) ? " crossorigin='{$this->crossorigin}'" : "")
            . "></script>";
        
        return $script;
    }
}

?>