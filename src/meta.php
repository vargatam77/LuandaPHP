<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a meta tag with attributes and content.
 */
class meta extends global_attr {
    protected int $level = 1; // Level of indentation for HTML output
    protected ?string $charset = null; // Charset attribute for the meta tag
    protected ?string $http_equiv = null; // HTTP-Equiv attribute for the meta tag
    protected array $contents = []; // Array to hold content attributes
    
    /**
     * Constructor for the meta tag.
     *
     * @param string|null $name Name attribute for the meta tag.
     * @param string|null $content Content attribute for the meta tag.
     */
    public function __construct(?string $name = null, ?string $content = null) {
        if ($name) {
            $this->setName($name);
        }
        if ($content) {
            $this->addContent($content);
        }
    }
    
    /**
     * Sets the charset attribute for the meta tag.
     *
     * @param string $charset Charset value.
     */
    public function setCharset(string $charset): void {
        $this->charset = $charset;
    }
    
    /**
     * Sets the HTTP-Equiv attribute for the meta tag.
     *
     * @param string $equiv HTTP-Equiv value.
     */
    public function setHttpEquiv(string $equiv): void {
        $this->http_equiv = $equiv;
    }
    
    /**
     * Adds content to the contents array.
     *
     * @param string|array $content Content to add.
     */
    public function addContent($content): void {
        if (is_array($content)) {
            $this->contents = array_merge($this->contents, $content);
        } else {
            $this->contents[] = $content;
        }
    }
    
    /**
     * Generates the content attribute string for the meta tag.
     *
     * @return string Content attribute string.
     */
    private function getContents(): string {
        $cont = " content='";
        
        $flag = 0;
        foreach ($this->contents as $content) {
            if ($flag > 0) {
                $cont .= ", ";
            }
            $flag = 1;
            $cont .= $content;
        }
        
        $cont .= "'";
        
        return $cont;
    }
    
    /**
     * Generates the complete HTML for the meta tag.
     *
     * @return string HTML representation of the meta tag.
     */
    public function getMeta(): string {
        $space = str_repeat("\t", $this->level);
        
        $meta = "\n" . $space . "<meta"
            . (($this->charset) ? " charset='" . $this->charset . "'" : "")
            . (($this->http_equiv) ? " http-equiv='" . $this->http_equiv . "'" : "")
            . (($this->contents) ? $this->getContents() : "")
            . $this->getAttributes()
            . "/>";
            
        return $meta;
    }
}

?>