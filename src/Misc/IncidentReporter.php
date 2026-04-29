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
    
    /**
     * Produce a self-contained HTML report of all stored log entries.
     * Returns the HTML string; does not write to disk.
     *
     * @param string $title Optional page/report title
     * @return string Full HTML document
     */
    public static function toHtml(string $title = 'Incident Report'): string {
        $_escapedTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $_generatedAt  = htmlspecialchars(date('Y-m-d H:i:s'), ENT_QUOTES, 'UTF-8');
        
        $_rows = '';
        foreach (self::$storage as $_index => $_entry) {
            $_escaped = htmlspecialchars($_entry, ENT_QUOTES, 'UTF-8');
            $_rowClass = $_index % 2 === 0 ? 'even' : 'odd';
            $_rows .= "            <tr class=\"{$_rowClass}\"><td>" . ($_index + 1) . "</td><td>{$_escaped}</td></tr>\n";
        }
        
        if ($_rows === '') {
            $_rows = '            <tr><td colspan="2"><em>No incidents recorded.</em></td></tr>' . "\n";
        }
        
        return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$_escapedTitle}</title>
            <style>
                body { font-family: monospace; background: #1e1e1e; color: #d4d4d4; padding: 2rem; }
                h1   { color: #ce9178; margin-bottom: 0.25rem; }
                p.meta { color: #6a9955; font-size: 0.85rem; margin-top: 0; }
                table { border-collapse: collapse; width: 100%; margin-top: 1.5rem; }
                th   { background: #2d2d2d; color: #9cdcfe; padding: 0.5rem 1rem; text-align: left; }
                td   { padding: 0.4rem 1rem; vertical-align: top; }
                tr.even { background: #252526; }
                tr.odd  { background: #1e1e1e; }
                td:first-child { color: #858585; width: 3rem; text-align: right; }
            </style>
        </head>
        <body>
            <h1>{$_escapedTitle}</h1>
            <p class="meta">Generated at: {$_generatedAt}</p>
            <table>
                <thead><tr><th>#</th><th>Log Entry</th></tr></thead>
                <tbody>
                    {$_rows}
                </tbody>
            </table>
        </body>
        </html>
        HTML;
    }
}

class debug_state {
	public const ON = true;
	public const OFF = false;
}

?>