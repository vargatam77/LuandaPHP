<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML iframe element.
 */
class iframe extends global_attr {
    protected ?html_content $content = null; // Content within the iframe
    protected int $level = 0; // Level of indentation for HTML output
    protected ?string $src = null; // URL of the content to embed
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the iframe element.
     *
     * @param string $src URL of the content to embed (default: "")
     * @param string $title Title attribute of the iframe (default: "")
     */
    public function __construct(string $src = "", string $title = "") {
        $this->src = $src;
        $this->setTitle($title);
    }
    
    /**
     * Set the URL of the content to embed.
     *
     * @param string $src URL of the content to embed.
     */
    public function setUrl(string $src = ""): void {
        $this->src = $src;
    }
    
    /**
     * Add content to the iframe element.
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
     * Add cloned content to the iframe element.
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
     * Generate HTML representation of the iframe element.
     *
     * @return string The HTML string representing the iframe element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        $iframe = "\n" . $space . "<iframe"
            . (($this->src) ? " src='" . $this->src . "'" : "")
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</iframe>";
                
        return $iframe;
    }
}

?>