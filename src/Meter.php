<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents a <meter> HTML element.
 */
class Meter extends Node {
    protected int|float $value;             // Current value
    protected int|float|null $min = null;   // Minimum value
    protected int|float|null $max = null;   // Maximum value
    protected int|float|null $low = null;   // Low threshold
    protected int|float|null $high = null;  // High threshold
    protected int|float|null $optimum = null; // Optimum value

    /**
     * Constructor for the Meter element.
     *
     * @param int|float $value The current value.
     * @param int|float $min   Minimum of the range.
     * @param int|float $max   Maximum of the range.
     */
    public function __construct(int|float $value, int|float $min = 0, int|float $max = 1) {
        $this->value = $value;
        $this->min   = $min;
        $this->max   = $max;
    }

    /**
     * Set the low and high thresholds.
     *
     * @param int|float $low  Value below which is considered low.
     * @param int|float $high Value above which is considered high.
     * @return void
     */
    public function setThresholds(int|float $low, int|float $high): void {
        $this->low  = $low;
        $this->high = $high;
    }

    /**
     * Set the optimum value.
     *
     * @param int|float $optimum The optimal value.
     * @return void
     */
    public function setOptimum(int|float $optimum): void {
        $this->optimum = $optimum;
    }

    /**
     * Generate the HTML representation of the <meter> element.
     *
     * @return string The HTML representation of the <meter> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<meter'
            . ' value="' . $this->value . '"'
            . ($this->min     !== null ? ' min="'     . $this->min     . '"' : '')
            . ($this->max     !== null ? ' max="'     . $this->max     . '"' : '')
            . ($this->low     !== null ? ' low="'     . $this->low     . '"' : '')
            . ($this->high    !== null ? ' high="'    . $this->high    . '"' : '')
            . ($this->optimum !== null ? ' optimum="' . $this->optimum . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . '</meter>';

        return $html;
    }
}

?>
