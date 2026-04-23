<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a node in the HTML document.
 */
class Node extends GlobalAttr {
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
     * @param object $content The content to add.
     * @return void
     */
    public function addContent(object $content): void {
        if (!$this->content) {
            $this->content = new HtmlContent();
        }
        $this->content->add($content);
    }
    
    /**
     * Add a cloned content to the node element.
     *
     * @param object $content The content to clone and add.
     * @return void
     */
    public function addClone(object $content): void {
        if (!$this->content) {
            $this->content = new HtmlContent();
        }
        $this->content->add(Cloner::getClone($content));
    }
}

?>