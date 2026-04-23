<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Represents HTML content that can contain nested elements.
 */
class HtmlContentExtended {
    private array $contents = []; // Array to store content elements
    private array $eids = []; // Internal element IDs for referencing elements
    private int $level = 0; // Level of indentation for HTML output
    private int $nextEid = 0; // Next available eid for new elements

    /**
     * Set the indentation level for HTML output.
     *
     * @param int $level The level of indentation.
     * @return void
     */
    public function setLevel(int $level): void {
        $this->level = $level;
    }

    /**
     * Constructor to initialize HTML content.
     */
    public function __construct() {
        // Nothing needed for initialization
    }

    /**
     * Add content to the end.
     *
     * @param object $content The content to add.
     * @return int The assigned internal eid.
     */
    public function add(object $content): int {
        $eid = $this->nextEid;
        $this->nextEid++;
        $this->contents[] = $content;
        $this->eids[] = $eid;
        return $eid;
    }

    /**
     * Prepend content to the beginning.
     *
     * @param object $content The content to prepend.
     * @return int The assigned internal eid.
     */
    public function prepend(object $content): int {
        $eid = $this->nextEid;
        $this->nextEid++;
        array_unshift($this->contents, $content);
        array_unshift($this->eids, $eid);
        return $eid;
    }

    /**
     * Insert content before a specific eid.
     *
     * @param int $beforeEid The target eid to insert before.
     * @param object $content The content to insert.
     * @return int|null The assigned eid or null if target not found.
     */
    public function insertBefore(int $beforeEid, object $content): ?int {
        $eid = null;
        $index = array_search($beforeEid, $this->eids, true);
        if ($index !== false) {
            $eid = $this->nextEid;
            $this->nextEid++;
            array_splice($this->contents, $index, 0, [$content]);
            array_splice($this->eids, $index, 0, [$eid]);
        }
        return $eid;
    }

    /**
     * Insert content after a specific eid.
     *
     * @param int $afterEid The target eid to insert after.
     * @param object $content The content to insert.
     * @return int|null The assigned eid or null if target not found.
     */
    public function insertAfter(int $afterEid, object $content): ?int {
        $eid = null;
        $index = array_search($afterEid, $this->eids, true);
        if ($index !== false) {
            $eid = $this->nextEid;
            $this->nextEid++;
            array_splice($this->contents, $index + 1, 0, [$content]);
            array_splice($this->eids, $index + 1, 0, [$eid]);
        }
        return $eid;
    }

    /**
     * Replace content of a specific eid.
     *
     * @param int $targetEid The eid of the element to replace.
     * @param object $newContent The new content to replace with.
     * @return bool True if replaced, false if target not found.
     */
    public function replace(int $targetEid, object $newContent): bool {
        $replaced = false;
        $index = array_search($targetEid, $this->eids, true);
        if ($index !== false) {
            $this->contents[$index] = $newContent;
            $replaced = true;
        }
        return $replaced;
    }

    /**
     * Delete a content element by eid.
     *
     * @param int $targetEid The eid of the element to delete.
     * @return bool True if deleted, false if target not found.
     */
    public function delete(int $targetEid): bool {
        $deleted = false;
        $index = array_search($targetEid, $this->eids, true);
        if ($index !== false) {
            array_splice($this->contents, $index, 1);
            array_splice($this->eids, $index, 1);
            $deleted = true;
        }
        return $deleted;
    }
    
    /**
     * Retrieve a content element by its internal eid.
     *
     * @param int $targetEid The eid of the element to retrieve.
     * @return object|null The element if found, null otherwise.
     */
    public function getByEid(int $targetEid): ?object {
        $element = null;
        $index = array_search($targetEid, $this->eids, true);
        if ($index !== false) {
            $element = $this->contents[$index];
        }
        return $element;
    }

    /**
     * Get the number of elements in the content.
     *
     * @return int The number of elements in the content.
     */
    public function length(): int {
        $count = count($this->contents);
        return $count;
    }

    /**
     * Generate HTML representation of the content.
     *
     * @return string The HTML string representing the content and its nested elements.
     */
    public function getHtml(): string {
        $html = '';
        foreach ($this->contents as $object) {
            $object->setLevel($this->level + 1);
            $html .= $object->getHtml();
        }
        return $html;
    }
}

?>
