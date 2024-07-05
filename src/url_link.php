<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class url_link
 * Represents a hyperlink (<a>) element with various attributes.
 */
class url_link extends global_attr {
    protected ?string $url = null;          // URL attribute
    protected ?string $target = null;       // Target attribute
    protected ?string $rel = null;          // Relationship attribute
    protected ?string $type = null;         // Type attribute
    protected ?html_content $content = null; // Content of the link
    protected int $level = 0;               // Indentation level
    
    /**
     * Sets the indentation level for formatting.
     *
     * @param int $level The level of indentation
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor.
     *
     * @param string $url The URL of the hyperlink
     */
    public function __construct(string $url) {
        $this->setUrl($url);
    }
    
    /**
     * Sets the URL attribute of the hyperlink.
     *
     * @param string $url The URL to set
     */
    public function setUrl(string $url): void {
        $this->url = $url;
    }
    
    /**
     * Sets the target attribute of the hyperlink.
     *
     * @param string $target The target attribute value
     */
    public function setTarget(string $target): void {
        $this->target = $target;
    }
    
    /**
     * Sets the rel (relationship) attribute of the hyperlink.
     *
     * @param string $rel The rel attribute value
     */
    public function setRelation(string $rel): void {
        $this->rel = $rel;
    }
    
    /**
     * Sets the type attribute of the hyperlink.
     *
     * @param string $type The type attribute value
     */
    public function setType(string $type): void {
        $this->type = $type;
    }
    
    /**
     * Adds content to the hyperlink.
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
     * Adds a cloned content to the hyperlink.
     *
     * @param mixed $content The content to clone and add
     */
    public function addClone($content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add(Cloner::getClone($content));
    }
    
    /**
     * Generates the HTML representation of the hyperlink.
     *
     * @return string The HTML representation of the hyperlink
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $url_link = "\n{$space}<a"
            ." href=\"{$this->url}\""
            .($this->target ? " target=\"{$this->target}\"" : "")
            .($this->type ? " type=\"{$this->type}\"" : "")
            .($this->rel ? " rel=\"{$this->rel}\"" : "")
            .$this->getAttributes()
            .">"
            .($this->content ? $this->content->getHtml() : "")
            ."\n{$space}</a>";
            
        return $url_link;
    }
}

?>