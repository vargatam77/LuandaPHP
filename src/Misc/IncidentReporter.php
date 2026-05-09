<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

/**
 * Static internal error handling
 * Extended: -write-to-file -produce-html-output
 */
class IncidentReporter {
    private static array $storage = [];
    
    /**
     * Handshake for external objects.
     * Always true if the class is available in this namespace.
     */
    public static function isAvailable(): bool {
        return debug_state::ON;
    }
    
    /**
     * The actual error reporting.
     * We concatenate for the storage to keep it "speaking" and linear.
     *
     * @param string $origin  The class or context where the error occurred.
     * @param string $message Human-readable description of the error.
     * @param int    $code    Optional error/status code, defaults to 0.
     */
    public static function report(string $origin, string $message, int $code = 0): void {
        self::$storage[] = '[' . date('H:i:s') . '] '
            . 'Origin: ' . $origin . ' | '
            . 'Error: ' . $message . ' | '
            . 'Code: ' . (string)$code;
    }
    
    /**
     * Retrieve all stored log entries.
     *
     * @return array List of formatted log strings in chronological order.
     */
    public static function getLogs(): array {
        return self::$storage;
    }
    
    /**
     * Write all stored log entries to a file.
     * Appends to the file if it already exists.
     *
     * @param string $filePath Destination file path
     */
    public static function writeToFile(string $filePath): void {
		if (!empty(self::$storage))
			if (file_put_contents($filePath,implode(PHP_EOL, self::$storage) . PHP_EOL, FILE_APPEND | LOCK_EX) === false)
				self::report('IncidentReporter', 'Failed to write log to file: ' . $filePath);
    }
}

class debug_state {
	public const ON = true;
	public const OFF = false;
}

?>