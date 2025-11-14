<?php
require_once __DIR__ . '/../config/database.php';

class Category extends Database {
    public function __construct() {
        parent::__construct();
        $this->connect();
    }

    // CREATE
    public function addCategory($name, $description) {
        $stmt = $this->conn->prepare("INSERT INTO tbl_category (category_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);
        return $stmt->execute();
    }

    // READ ALL
    public function getCategories() {
        $result = $this->conn->query("SELECT * FROM tbl_category ORDER BY category_id ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // READ ONE
    public function getCategoryById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_category WHERE category_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE
    public function updateCategory($id, $name, $description) {
        $stmt = $this->conn->prepare("UPDATE tbl_category SET category_name = ?, description = ? WHERE category_id = ?");
        $stmt->bind_param("ssi", $name, $description, $id);
        return $stmt->execute();
    }

    // DELETE
    public function deleteCategory($id) {
        $stmt = $this->conn->prepare("DELETE FROM tbl_category WHERE category_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
