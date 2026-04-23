<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents an <object> HTML element for embedding external resources.
 */
class ObjectEmbed extends Node {
    protected string $data;             // URL of the resource
    protected ?string $mediatype = null; // MIME type of the resource
    protected ?int $width = null;       // Width in pixels
    protected ?int $height = null;      // Height in pixels

    /**
     * Constructor for the ObjectEmbed element.
     *
     * @param string $data The URL of the resource to embed.
     */
    public function __construct(string $data) {
        $this->data = $this->safeUrl($data);
    }

    /**
     * Set the MIME type of the embedded resource.
     *
     * @param string $type MIME type string.
     * @return void
     */
    public function setMediatype(string $type): void {
        $this->mediatype = $type;
    }

    /**
     * Set the display dimensions.
     *
     * @param int $width  Width in pixels.
     * @param int $height Height in pixels.
     * @return void
     */
    public function setSize(int $width, int $height): void {
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * Generate the HTML representation of the <object> element.
     *
     * @return string The HTML representation of the <object> element.
     */
    public function getHtml(): string {
        if ($this->content) {
            $this->content->setLevel($this->level);
        }

        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<object data="' . $this->data . '"'
            . ($this->mediatype ? ' type="'   . $this->mediatype . '"' : '')
            . ($this->width     ? ' width="'  . $this->width     . '"' : '')
            . ($this->height    ? ' height="' . $this->height    . '"' : '')
            . $this->getAttributes()
            . '>'
            . ($this->content ? $this->content->getHtml() : '')
            . "\n" . $space . '</object>';

        return $html;
    }
}

//--------------------------------------------------------------------------------------------------------------------------------

/**
 * Represents a <param> HTML element used inside an <object>.
 */
class Param extends Node {
    protected string $paramName;  // Parameter name
    protected string $paramValue; // Parameter value

    /**
     * Constructor for the Param element.
     *
     * @param string $paramName  The parameter name.
     * @param string $paramValue The parameter value.
     */
    public function __construct(string $paramName, string $paramValue) {
        $this->paramName  = $this->safeHtml($paramName);
        $this->paramValue = $this->safeHtml($paramValue);
    }

    /**
     * Generate the HTML representation of the <param> element.
     *
     * @return string The HTML representation of the <param> element.
     */
    public function getHtml(): string {
        $space = str_repeat("\t", $this->level);

        $html = "\n" . $space . '<param name="' . $this->paramName . '" value="' . $this->paramValue . '"'
            . $this->getAttributes()
            . ' />';

        return $html;
    }
}

?>
