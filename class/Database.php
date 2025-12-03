<?php
// class/Database.php
class Database {
    public PDO $conn;

    public function __construct() {
        $this->connect();
    }

    public function connect(): ?PDO {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            return $this->conn;
        } catch (PDOException $e) {
            // Tampilkan friendly error saat development
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }

    public function query(string $sql, array $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
