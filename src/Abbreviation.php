<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <abbr> element.
 */
class Abbreviation extends Node {
	private ?string $text = null;
    
    /**
     * Constructor for the Abbreviation element.
     * @param string $text The content of the Abbreviation
     */
    public function __construct(string $text) {
        $this->setText($text);
    }
    
    /**
     * Function to change/set the text content
     * @param string $text The content of the abbreviation
     */
    public function setText(string $text): void {
    	$this->text = $this->safeHtml($text);
    }

    /**
     * Generate the HTML representation of the abbreviation.
     *
     * @return string The HTML representation of the abbreviation.
     */
    public function getHtml(): string {
    	$_indent  = str_repeat(indent_type::TAB, $this->level);

    	$_html  = special_chars::NEWLINE
    		. $_indent . '<abbr'
            . $this->getClasses()
            . $this->getAttributes()
            . $this->getEvents()
            . '>' . special_chars::NEWLINE
            . $_indent . indent_type::TAB . $this->text . special_chars::NEWLINE
            . $_indent . '</abbr>';

		return $_html;
    }
}

?>