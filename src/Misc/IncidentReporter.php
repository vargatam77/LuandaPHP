<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

/**
 * Static internal error handling
 // TODO: extend! -write-to-file -produce-html-output normal.
  *
 */
class IncidentReporter {
    private static array $storage = [];
    
    /**
     * Handshake for external objects.
     * Always true if the class is available in this namespace.
     */
    public static function isAvailable(): bool {
        return true;
    }
    
    /**
     * The actual error reporting
     * We concatenate for the storage to keep it "speaking" and linear
     */
    public static function report(string $origin, string $message, int $code = 0): void {
        self::$storage[] = '[' . date('H:i:s') . '] '
            . 'Origin: ' . $origin . ' | '
            . 'Error: ' . $message . ' | '
            . 'Code: ' . (string)$code;
    }
    
    public static function getLogs(): array {
        return self::$storage;
    }
}

?>