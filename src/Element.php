<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP;

/**
 * Foundation logic for all LuandaPHP components.
 * 
 * Handles escaping and core helpers.
 */
abstract class Element {
    
    /**
     * Safely escapes a string for HTML output (Content & Attributes).
     * 
     * @param string $text
     * @return string
     */
    protected function safeHtml(string $text): string {
        return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Specifically for URLs (href, src, action). 
     * 
     * Supports SPA javascript: calls.
     * 
     * @param string $url
     * @return string
     */
    protected function safeUrl(string $url): string {
        $result = $this->safeHtml($url);
        return $result;
    }
}

?>