<?php
require_once __DIR__ . '/../config/database.php';

class Supplier extends Database {
    public function __construct() {
        parent::__construct();
        $this->connect();
    }

    // CREATE
    public function addSupplier($name, $person, $number, $address) {
        $stmt = $this->conn->prepare("INSERT INTO tbl_supplier (supplier_name, contact_person, contact_number, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $person, $number, $address);
        return $stmt->execute();
    }

    // READ ALL
    public function getSuppliers() {
        $result = $this->conn->query("SELECT * FROM tbl_supplier ORDER BY supplier_id ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // READ ONE
    public function getSupplierById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_supplier WHERE supplier_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE
    public function updateSupplier($id, $name, $person, $number, $address) {
        $stmt = $this->conn->prepare("UPDATE tbl_supplier SET supplier_name=?, contact_person=?, contact_number=?, address=? WHERE supplier_id=?");
        $stmt->bind_param("ssssi", $name, $person, $number, $address, $id);
        return $stmt->execute();
    }

    // DELETE
    public function deleteSupplier($id) {
        $stmt = $this->conn->prepare("DELETE FROM tbl_supplier WHERE supplier_id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
