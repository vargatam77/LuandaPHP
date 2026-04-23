<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <div> HTML element.
 */
class Div extends Node {
    
    /**
     * Constructor for the Div element.
     */
    public function __construct() {
        
    }
    
    /**
     * Output the <div> element directly to the browser.
     *
     * @return void
     */
    public function show(): void {
        echo $this->getHtml();
    }
    
    /**
     * Generate the HTML representation of the <div> element.
     *
     * @return string The HTML representation of the <div> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<div'
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</div>';
                
        return $html;
    }
}

?>
