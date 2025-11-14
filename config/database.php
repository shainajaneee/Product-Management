<?php
// ✅ Database class is responsible for handling the connection
class Database {
    private $host;
    private $username;
    private $password;
    private $dbname;
    protected $conn; // Protected so child classes can use it

    // Constructor sets up database credentials
    public function __construct() {
        $this->host = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->dbname = 'product_management';
    }

    // Function to establish a connection to the MySQL database
    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        // Check if connection failed
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
?>