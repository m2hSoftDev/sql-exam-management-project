<?php
/**
 * Database Configuration
 * Uses PHP PDO with PostgreSQL driver
 */

namespace Config;

use PDO;
use PDOException;

class Database {
    private $host = '127.0.0.1';
    private $db_name = 'exam_db';
    private $username = 'root'; // Default XAMPP user
    private $password = ''; // Default XAMPP password is empty
    private $port = '3306';
    public $conn;

    /**
     * Get the database connection
     * 
     * @return PDO|null
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Set error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Set default fetch mode to associative array for "Pure Row" approach
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $exception) {
            // In production, you would log this instead of Echoing
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
