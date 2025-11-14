<?php
require_once __DIR__ . '/../config/database.php';

class Product extends Database {
    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect(); // ✅ store connection into $this->conn
    }

    // CREATE
    public function addProduct($name, $category, $supplier, $quantity, $price) {
        $stmt = $this->conn->prepare("INSERT INTO tbl_product (product_name, category_id, supplier_id, quantity, price) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("SQL error: " . $this->conn->error);
        }
        $stmt->bind_param("siiid", $name, $category, $supplier, $quantity, $price);
        return $stmt->execute();
    }

    // READ ALL
    public function getProducts() {
        $query = "SELECT p.*, c.category_name, s.supplier_name 
                  FROM tbl_product p
                  LEFT JOIN tbl_category c ON p.category_id = c.category_id
                  LEFT JOIN tbl_supplier s ON p.supplier_id = s.supplier_id
                  ORDER BY p.product_id ASC";
        $result = $this->conn->query($query);
        if (!$result) {
            die("Query error: " . $this->conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // READ ONE
    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_product WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE
    public function updateProduct($id, $name, $category, $supplier, $quantity, $price) {
        $stmt = $this->conn->prepare("UPDATE tbl_product SET product_name=?, category_id=?, supplier_id=?, quantity=?, price=?  WHERE product_id=?");
        $stmt->bind_param("siiidi", $name, $category, $supplier, $quantity, $price, $id);
        return $stmt->execute();
    }

    // DELETE
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM tbl_product WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
