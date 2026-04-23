<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a datalist HTML element.
 */
class DataList extends Node {
    protected array $list = []; // List of options for the datalist
    
    /**
     * Constructor for the DataList element.
     */
    public function __construct() {
        
    }
    
    /**
     * Add an element to the datalist.
     *
     * @param string $element Element to add to the datalist
     * @return void
     */
    public function addElement(string $element): void {
        foreach ($this->list as $item) {
            if (strcasecmp($item, $element) === 0) {
                return;
            }
        }
        $this->list[] = $element;
    }
    
    /**
     * Generate HTML representation of the datalist element.
     *
     * @return string The HTML representation of the datalist
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);
        
        $html = "\n" . $space . '<datalist'
            . $this->getAttributes()
            . '>';
            
            foreach ($this->list as $element) {
                $html .= "\n" . $space . "\t" . '<option value="' . $this->safeHtml((string)$element) . '" />';
            }
            
            $html .= "\n" . $space . '</datalist>';
            
            return $html;
    }
}

?>