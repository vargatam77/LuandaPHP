<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <datalist> element.
 */
class DataList extends Node {
	protected array $options = [];
	
	/**
	 * Constructor for the DataList element.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Add an option to the datalist.
	 * Duplicate values are ignored (case-sensitive).
	 *
	 * @param Option $option The option element to add.
	 * @return void
	 */
	public function addOption(Option $option): void {
		$this->options[$option->getValue()] = $option;
	}
	
	/**
	 * Generate HTML representation of the datalist element.
	 *
	 * @return string The HTML representation of the datalist.
	 */
	public function getHtml(): string {
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<datalist'
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>';
			
			foreach ($this->options as $_option) {
				$_option->setLevel($this->level + 1);
				$_html .= $_option->getHtml();
			}
			
			$_html .= special_chars::NEWLINE . $_indent . '</datalist>';
			
		return $_html;
	}
}

?>