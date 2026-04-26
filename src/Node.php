<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a node in the HTML document.
 */
abstract class Node extends GlobalAttr implements IRenderableInterface {
    protected ?HtmlContent $content = null;     // Content of the node element
    protected int $level = 0;                   // Indentation level for HTML output
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level to set.
     * @return void
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }

    /**
     * Add content to the node element.
     *
     * @param IRenderableInterface $content The content to add.
     * @return void
     */
    public function addContent(IRenderableInterface  $content): void {
        if (!$this->content) {
            $this->content = new HtmlContent();
        }
        $this->content->add($content);
    }
    
    /**
     * Add a cloned content to the node element.
     *
     * @param IRenderableInterface $content The content to clone and add.
     * @return void
     */
    public function addClone(IRenderableInterface  $content): void {
        if (!$this->content) {
            $this->content = new HtmlContent();
        }
        $this->content->add(deep_cloner::getClone($content));
    }
    
    /**
     * Output the node element directly to the browser.
     *
     * @return void
     */
    public function Show(): void {
    	echo $this->getHtml();
    }
}

interface IRenderableInterface {
	public function setLevel(int $level): void;
	public function getHtml(): string;
}

?>