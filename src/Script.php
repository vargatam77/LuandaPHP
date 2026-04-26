<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <script> tag for JavaScript files or inline scripts.
 */
class Script extends Node {
    protected ?string $src = null; // Src attribute of the script
    protected ?string $crossorigin = null; // Crossorigin attribute of the script
    
    /**
     * Constructor for the Script element.
     *
     * @param string $src The src attribute or inline code
     * @param string|null $crossorigin The crossorigin attribute value
     */
    public function __construct(string $src, ?string $crossorigin = null) {
        $this->src = $src;
        $this->crossorigin = $crossorigin;
    }
    
    /**
     * Sets the crossorigin attribute of the script.
     *
     * @param string $origin The crossorigin attribute value
     * @return void
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
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<script type="text/javascript">'
            . $this->src
            . '</script>';
            
        return $html;
    }
    
    /**
     * Generates the HTML representation of the external script tag.
     *
     * @return string The HTML representation of the script tag
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<script'
            . (!$this->crossorigin ? ' type="text/javascript"' : '')
            . ' src="' . $this->src . '"'
            . ($this->crossorigin ? ' crossorigin="' . $this->crossorigin . '"' : '')
            . $this->getAttributes()
            . '></script>';
            
        return $html;
    }
}

?>