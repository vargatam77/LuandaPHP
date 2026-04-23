<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a meta tag with attributes and content.
 */
class Meta extends Element {
    protected int $level = 0; // Indentation level for header compatibility
    protected ?string $name = null; // Name attribute for the meta tag
    protected ?string $charset = null; // Charset attribute for the meta tag
    protected ?string $httpEquiv = null; // HTTP-Equiv attribute for the meta tag
    protected array $contents = []; // Array to hold content attributes
    
    /**
     * Constructor for the meta tag.
     *
     * @param string|null $name Name attribute
     * @param string|null $content Content attribute
     */
    public function __construct(?string $name = null, ?string $content = null) {
        if (isset($name)) $this->setName($name);
        if (isset($content)) $this->addContent($content);
    }
    
    /**
     * Set the indentation level.
     *
     * @param int $level Indentation level
     * @return void
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Sets the name attribute for the meta tag.
     *
     * @param string $name Name value
     * @return void
     */
    public function setName(string $name): void {
        $this->name = $name;
    }
    
    /**
     * Sets the charset attribute for the meta tag.
     *
     * @param string $charset Charset value
     * @return void
     */
    public function setCharset(string $charset): void {
        $this->charset = $charset;
    }
    
    /**
     * Sets the HTTP-Equiv attribute for the meta tag.
     *
     * @param string $equiv HTTP-Equiv value
     * @return void
     */
    public function setEquiv(string $equiv): void {
        $this->httpEquiv = $equiv;
    }
    
    /**
     * Adds content to the contents array.
     *
     * @param string $content Content to add
     * @return void
     */
    public function addContent(string $content): void {
        $this->contents[] = $this->safeHtml($content);
    }
    
    /**
     * Generate the HTML representation of the meta tag.
     *
     * @return string The HTML representation
     */
    public function getMeta(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<meta'
            . ($this->name ? ' name="' . $this->name . '"' : '')
            . ($this->charset ? ' charset="' . $this->charset . '"' : '')
            . ($this->httpEquiv ? ' http-equiv="' . $this->httpEquiv . '"' : '')
            . (count($this->contents) ? ' content="' . implode(', ', $this->contents) . '"' : '')
            . ' />';
            
        return $html;
    }
}

?>