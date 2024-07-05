<?php
namespace TamasVarga\LuandaPHP;

/**
 * Represents a list HTML element.
 */
class listing extends global_attr {
    protected ?string $style = null; // Style of the list (ordered, unordered, description)
    protected ?html_content $content = null; // Content of the list
    protected int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Constructor for the listing element.
     *
     * @param string $style Style of the list (ordered, unordered, description).
     */
    public function __construct(string $style) {
        $this->style = $style;
    }
    
    /**
     * Add an item to the list.
     *
     * @param mixed $element The item to add to the list.
     */
    public function addItem($element): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($element);
    }
    
    /**
     * Generate HTML representation of the list element.
     *
     * @return string The HTML string representing the list element.
     */
    public function getHtml(): string {
        $listType = "ul";
        
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        $space = str_repeat("\t", $this->level);
        
        switch ($this->style) {
            case list_style::ORDERED:
                $listType = "ol";
                break;
            case list_style::DESCRIPTION:
                $listType = "dl";
                break;
            default:
                break;
        }
        
        $list = "\n" . $space . "<" . $listType
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</" . $listType . ">";
            
        return $list;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a list item HTML element.
 */
class listItem extends global_attr {
    private ?string $style = null; // Style of the list item (li, dl)
    private ?html_content $content = null; // Content of the list item
    private int $level = 0; // Level of indentation for HTML output
    
    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }
    
    /**
     * Set the style of the list item.
     *
     * @param string $style Style of the list item (li, dl).
     */
    public function setStyle(string $style): void {
        $this->style = $style;
    }
    
    /**
     * Constructor for the list item element.
     */
    public function __construct() {
    }
    
    /**
     * Add content to the list item.
     *
     * @param string $content Content to add to the list item.
     */
    public function addContent(string $content): void {
        if (!$this->content) {
            $this->content = new html_content();
        }
        $this->content->add($content);
    }
    
    /**
     * Generate HTML representation of the list item element.
     *
     * @return string The HTML string representing the list item element.
     */
    public function getHtml(): string {
        $itemType = "li";
        
        if ($this->content) {
            $this->content->setLevel($this->level);
        }
        
        if ($this->style == list_style::DESCRIPTION) {
            $itemType = "dl";
        }
        
        $space = str_repeat("\t", $this->level);
        
        $listItem = "\n" . $space . "<" . $itemType
            . $this->getAttributes()
            . ">"
            . (($this->content) ? $this->content->getHtml() : "")
            . "\n" . $space . "</" . $itemType . ">";
            
        return $listItem;
    }
}

?>