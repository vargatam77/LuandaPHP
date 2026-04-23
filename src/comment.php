<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML comment.
 */
class Comment extends Element {
    protected int $level = 0; // Level of the comment for compatibility
    protected ?string $comment = null; // Text content of the comment
    protected ?string $dashChar = null; // Character used for dashes in the comment
    protected ?int $dashCount = null; // Number of dashes surrounding the comment
    
    /**
     * Constructor for the comment class.
     *
     * @param string $comment The text content of the comment
     * @param int $dash_count The number of dashes surrounding the comment
     * @param string $dash_char The character used for dashes
     */
    public function __construct(string $comment = 'comment', int $dash_count = 0, string $dash_char = ' ') {
        $this->comment = $comment;
        $this->dashCount = $dash_count;
        $this->dashChar = $dash_char;
    }
    
    /**
     * Set the level of the comment for compatibility.
     *
     * @param int $level The level of the comment
     * @return void
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Set the character used for dashes in the comment.
     *
     * @param string $dash_char The character to set
     * @return void
     */
    public function setDashChar(string $dash_char): void {
        $this->dashChar = $dash_char[0];
    }
    
    /**
     * Fetch content from a specified URL and set it as the text content.
     *
     * @param string $url The URL from which to fetch content
     * @return void
     */
    public function getFromURL(string $url): void {
        $this->comment = $this->safeHtml(file_get_contents($url));
    }
    
    /**
     * Generate the HTML representation of the comment.
     *
     * @return string The HTML representation of the comment
     */
    public function getHtml(): string {
        $html = "\n\n" . '<!-- '
            . str_repeat($this->dashChar, intdiv($this->dashCount, 2))
            . ' '
            . $this->comment
            . ' '
            . str_repeat($this->dashChar, intdiv($this->dashCount, 2))
            . ' -->' . "\n";
            
        return $html;
    }
}

?>