<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a list item HTML element (li, dt, or dd).
 */
class ListItem extends Node {
	protected string $listItemType = listitem_type::ITEM;	// Default list item type
	
	/**
	 * Constructor for the ListItem element.
	 *
	 * @param string $listitemtype Type from listitem_type helper
	 */
	public function __construct(string $listitemtype) {
		$this->listItemType = $listitemtype;
	}
	
	/**
	 * Generate HTML representation of the list item.
	 *
	 * @return string The HTML representation of the list item
	 */
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(indent_type::TAB, $this->level);
		
		$_html = special_chars::NEWLINE
			. $_indent . '<' . $this->listItemType
			. $this->getClasses()
			. $this->getAttributes()
			. $this->getEvents()
			. '>'
			. $this->content?->getHtml()
			. special_chars::NEWLINE
			. $_indent . '</' . $this->listItemType
			. '>';
		
		return $_html;
	}
}

?>