<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an HTML <option> element.
 */
class Option extends Node {
    protected ?string $value		= null;    // Value attribute
    protected ?string $label		= null;    // Label attribute
    protected ?bool $disabled		= null;   // Disabled flag
    protected ?bool $selected		= null;   // Selected flag

    /**
     * Constructor for the Option element.
     *
     * @param string $value The value attribute of the option.
     * @param string|null $label Optional label for the option.
     */
    public function __construct(string $value, ?string $label = null) {
        $this->setValue($value);
        if ($this->hasValue($label))
        	$this->setLabel($label);
    }

    /**
     * Sets the value attribute of the option.
     *
     * @param string $value The value to set.
     * @return void
     */
    public function setValue(string $value): void {
        $this->value = $this->safeHtml($value);
    }

    /**
     * Gets the value attribute of the option.
     *
     * @return string|null The current value.
     */
    public function getValue(): ?string {
        return $this->value;
    }

    /**
     * Sets the label attribute of the option.
     *
     * @param string $label The label to set.
     * @return void
     */
    public function setLabel(string $label): void {
        $this->label = $this->safeHtml($label);
    }

    /**
     * Marks the option as selected.
     *
     * @return void
     */
    public function Select(): void {
        $this->selected = true;
    }

    /**
     * Generate the HTML representation of the option element.
     *
     * @return string The HTML representation of the option element.
     */
    public function getHtml(): string {
        $_indent = str_repeat(indent_type::TAB, $this->level);

        $_html = special_chars::NEWLINE
            . $_indent . '<option'
            . ($this->hasValue($this->value)		? ' value="' . $this->value . '"'	: '')
            . ($this->hasValue($this->label)		? ' label="' . $this->label . '"'	: '')
            . ($this->hasValue($this->selected)		? ' selected="selected"'			: '')
            . $this->getClasses()
            . $this->getAttributes()
            . $this->getEvents()
            . ' />';

        return $_html;
    }
}

?>