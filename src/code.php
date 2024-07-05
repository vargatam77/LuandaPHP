<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a code HTML element.
 */
class code {
    protected ?string $id = null; // ID attribute of the code element
    protected string $text = ''; // Text content of the code element
    protected bool $formatted = false; // Flag indicating if content is preformatted
    protected array $classes = []; // Array of classes for the code element
    protected int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the level of indentation for HTML output.
     *
     * @param int $level The level to set.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor method for the code class.
     *
     * @param string $text The initial text content for the code element.
     */
    public function __construct(string $text) {
        $this->setText($text);
    }
    
    /**
     * Set the ID attribute of the code element.
     *
     * @param string $id The ID to set.
     */
    public function setId(string $id): void {
        $this->id = $id;
    }
    
    /**
     * Get the ID attribute of the code element.
     *
     * @return string|null The ID attribute value.
     */
    public function getId(): ?string {
        return $this->id;
    }
    
    /**
     * Add a class to the code element.
     *
     * @param string $class The class to add.
     */
    public function addClass(string $class): void {
        $this->classes[] = $class;
    }
    
    /**
     * Set the text content of the code element.
     *
     * @param string $text The text content to set.
     */
    public function setText(string $text): void {
        $this->text = $text;
    }
    
    /**
     * Set whether the content should be preformatted.
     *
     * @param bool $formatted Whether to preformat the content.
     */
    public function preformat(bool $formatted = true): void {
        $this->formatted = $formatted;
    }
    
    /**
     * Add a line of text to the existing text content.
     *
     * @param string $text The line of text to add.
     */
    public function addLine(string $text): void {
        $this->text .= $text;
    }
    
    /**
     * Fetch text content from a specified URL and set it as the content of the code element.
     *
     * @param string $url The URL from which to fetch content.
     */
    public function getFromURL(string $url): void {
        $this->text = file_get_contents($url);
    }
    
    /**
     * Get the concatenated string of classes for the code element.
     *
     * @return string The concatenated classes.
     */
    public function getClasses(): string {
        return implode(' ', $this->classes);
    }
    
    /**
     * Generate the HTML representation of the code element.
     *
     * @return string The HTML representation of the code element.
     */
    public function getHtml(): string {
        // Generate the indentation for HTML output
        $space = str_repeat("\t", $this->level);
        
        // Construct the HTML for the code element
        $code = ""
            . (($this->formatted) ? "\n" . $space . "<pre><code" . (($this->classes) ? " class='" . $this->getClasses() . "'" : "") . ">" : "")
            . $this->text
            . (($this->formatted) ? "</code></pre>" : "");
            
        return $code;
    }
}

?>