<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML comment.
 */
class comment {
    protected ?string $text = null;         // Text content of the comment
    protected ?int $level = null;           // Level of the comment (not currently used)
    protected string $dashchar = "-";       // Character used for dashes in the comment
    protected int $dashes = 0;              // Number of dashes surrounding the comment
    
    /**
     * Constructor method for the comment class.
     *
     * @param string|null $text The text content of the comment.
     * @param int|null $dashes The number of dashes surrounding the comment.
     * @param string|null $dashchar The character used for dashes in the comment.
     */
    public function __construct(?string $text = null, ?int $dashes = 0, ?string $dashchar = null) {
        if ($text) {
            $this->text = $text;
        }
        if ($dashes) {
            $this->dashes = $dashes;
        }
        if ($dashchar) {
            $this->dashchar = $dashchar;
        }
    }
    
    /**
     * Set the level of the comment (not currently used).
     *
     * @param int $level The level of the comment.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Set the character used for dashes in the comment.
     *
     * @param string $dashchar The character to set.
     */
    public function setDashChar(string $dashchar): void {
        $this->dashchar = $dashchar;
    }
    
    /**
     * Fetch content from a specified URL and set it as the text content of the comment.
     *
     * @param string $url The URL from which to fetch content.
     */
    public function getFromURL(string $url): void {
        $this->text = file_get_contents($url);
    }
    
    /**
     * Generate the HTML representation of the comment.
     *
     * @return string The HTML representation of the comment.
     */
    public function getHtml(): string {
        // Calculate number of dashes before and after the text
        $dashes = intdiv($this->dashes - strlen($this->text) - 2, 2);
        $dashmod = ($this->dashes - strlen($this->text) - 2) % 2;
        
        // Construct the HTML for the comment
        $comment = "\n\n<!-- "
            . str_repeat($this->dashchar, $dashes - 1) . " " . $this->text . " " . str_repeat($this->dashchar, $dashes + $dashmod)
            . " -->\n";
            
        return $comment;
    }
}

?>