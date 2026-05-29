<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

use TamasVarga\LuandaPHP\HtmlContent;
use TamasVarga\LuandaPHP\INodeInterface;
use TamasVarga\LuandaPHP\Element;

/**
 * Represents the root <svg> element.
 */
class SvgBase extends SvgAttr implements INodeInterface {
	private string $xmlns					= 'http://www.w3.org/2000/svg';
	private ?string $id						= null;
	private array $classes					= [];
	private ?string $viewBox				= null;
	private HtmlContent $content;
	private int $level = 0;
	
	public function __construct() {
		$this->content = new HtmlContent();
	}
	
	public function setLevel(int $level): void {
		$this->level = $level;
	}
	
	public function getHtml(): string {
		$this->content?->setLevel($this->level);
		
		$_indent = str_repeat(Element::getIndentString(), $this->level);
		
		$_html = Element::getNewlineString() . $_indent . '<svg' . $this->getAttributes() . ' />'
			
			. ($this->hasValue($this->title) ? Element::getNewlineString . $_indent . Element::getIndentString . '<title>' . $this->title . '</title>' : '')
			. ($this->hasValue($this->desc) ? Element::getNewlineString . $_indent . Element::getIndentString . '<desc>' . $this->desc . '</desc>' : '')
			. $this->content?->getHtml()
			. Element::getNewlineSting() . $_indent . '</svg>';
		
		return $_html;
	}
	
	public function addContent(HtmlContent $content): void {
		$this->content->Add($content);
	}
}

?>