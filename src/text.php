<?php
namespace TamasVarga\LuandaPHP;

/**
 * Class text
 * Represents a text element with various formatting options.
 */
class text {
    protected ?string $id = null;          // ID attribute
    protected string $text;                // Text content
    protected bool $formatted = false;     // Flag indicating preformatted text
    public bool $strong = false;         // Flag indicating strong emphasis
    protected array $classes = [];         // Array of CSS classes
    protected int $level = 0;              // Indentation level
    
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
     * @param string $text The initial text content
     */
    public function __construct(string $text) {
        $this->setText($text);
    }
    
    /**
     * Sets the ID attribute.
     *
     * @param string $id The ID attribute value
     */
    public function setId(string $id): void {
        $this->id = $id;
    }
    
    /**
     * Retrieves the ID attribute value.
     *
     * @return string|null The ID attribute value
     */
    public function getId(): ?string {
        return $this->id;
    }
    
    /**
     * Adds a CSS class to the element.
     *
     * @param string $class The CSS class to add
     */
    public function addClass(string $class): void {
        $this->classes[] = $class;
    }
    
    /**
     * Sets the text content.
     *
     * @param string $text The text content to set
     */
    public function setText(string $text): void {
        $this->text = $text;
    }
    
    /**
     * Retrieves the current text content.
     *
     * @return string The text content
     */
    public function getText(): string {
        return $this->text;
    }
    
    /**
     * Retrieves content from a given URL and sets it as the text content.
     *
     * @param string $url The URL to fetch content from
     */
    public function getFromURL(string $url): void {
        $this->text = file_get_contents($url);
    }
    
    /**
     * Retrieves the CSS classes as a string.
     *
     * @return string The CSS classes formatted as a string
     */
    public function getClasses(): string {
        return implode(' ', $this->classes);
    }
    
    /**
     * Generates the HTML representation of the text element.
     *
     * @return string The HTML representation of the text
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);   // Indentation
        
        $html = '';
        if ($this->formatted) {
            $html .= "\n{$space}<pre";
            if (!empty($this->classes)) {
                $html .= " class='" . $this->getClasses() . "'";
            }
            $html .= ">";
        }
        
        if ($this->strong) {
            $html .= "<strong>";
        }
        
        $html .= $this->text;
        
        if ($this->strong) {
            $html .= "</strong>";
        }
        
        if ($this->formatted) {
            $html .= "</pre>";
        }
        
        return $html;
    }
}

?>