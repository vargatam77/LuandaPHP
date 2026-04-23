<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\DataBase;

use \PDO;
use \PDOException;
use TamasVarga\LuandaPHP\Misc\IncidentReporter;

class DataBase_1 {
    private ?PDO $pdo;
    private DbConfig $config;

    public function __construct(DbConfig $config) {
        $this->config = $config;
        $this->pdo = null;
    }

    public function connect(): bool {
        $status = false;

        // Concatenating line-by-line 'C-style'
        $dsn = 'mysql:host=' 
            . $this->config->host 
            . ';port=' 
            . (string)$this->config->port 
            . ';dbname=' 
            . $this->config->dbname 
            . ';charset=utf8mb4';

        /**
         * PDO constructor is one of the few things in PHP that 
         * strictly throws exceptions, so we wrap just the 
         * instantiation to keep our library "silent".
         */
        try {
            $connection = new PDO(
                $dsn, 
                $this->config->user, 
                $this->config->pass, 
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );

            if ($connection) {
                $this->pdo = $connection;
                $status = true;
            }
        } catch (PDOException $e) {
            IncidentReporter::report(
                'Database', 
                'PDO Connection failed: ' . $e->getMessage(), 
                (int)$e->getCode()
            );
        }

        return $status;
    }

    /**
     * Executes a Stored Procedure (TSQL Style)
     * returns the result set or empty array on fail.
     */
    public function call(string $procedureName, array $params = []): array {
        $results = [];

        if (isset($this->pdo)) {
            // Build the CALL string: CALL name(?, ?, ?)
            $placeholders = '';
            if (count($params) > 0) {
                $placeholders = implode(',', array_fill(0, count($params), '?'));
            }

            $sql = 'CALL ' . $procedureName . '(' . $placeholders . ')';
            $stmt = $this->pdo->prepare($sql);

            if ($stmt) {
                $success = $stmt->execute(array_values($params));

                if ($success) {
                    $results = $stmt->fetchAll();
                }

                if ($success === false) {
                    $info = $stmt->errorInfo();
                    IncidentReporter::report(
                        'Database', 
                        'Procedure ' . $procedureName . ' failed: ' . ($info[2] ?? 'Unknown'), 
                        (int)($info[1] ?? 0)
                    );
                }
            }
        }

        return $results;
    }

    public function getInternalPdo(): ?PDO {
        return $this->pdo;
    }
}

?>