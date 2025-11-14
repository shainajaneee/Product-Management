<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/classes/Supplier.php";

$supplier = new Supplier();
$message = "";

// ADD SUPPLIER
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['supplier_name'];
    $person = $_POST['contact_person'];
    $number = $_POST['contact_number'];
    $address = $_POST['address'];
    $message = $supplier->addSupplier($name, $person, $number, $address)
        ? "✅ Supplier added successfully!"
        : "❌ Error adding supplier.";
}

// UPDATE SUPPLIER
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['supplier_name'];
    $person = $_POST['contact_person'];
    $number = $_POST['contact_number'];
    $address = $_POST['address'];
    $message = $supplier->updateSupplier($id, $name, $person, $number, $address)
        ? "✅ Supplier updated successfully!"
        : "❌ Error updating supplier.";
}

// DELETE SUPPLIER
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $message = $supplier->deleteSupplier($id)
        ? "✅ Supplier deleted successfully!"
        : "❌ Error deleting supplier.";
}

$suppliers = $supplier->getSuppliers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Suppliers</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .form-section { border-right: 2px solid #e0e0e0; }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="index.php" class="nav-link">Dashboard</a></li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
      <i class="fas fa-boxes ml-2"></i><span class="brand-text font-weight-light ml-2">PMS Dashboard</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item"><a href="index.php" class="nav-link"><i class="nav-icon fas fa-home"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="categories.php" class="nav-link"><i class="nav-icon fas fa-layer-group"></i><p>Manage Categories</p></a></li>
          <li class="nav-item"><a href="suppliers.php" class="nav-link active"><i class="nav-icon fas fa-truck"></i><p>Manage Suppliers</p></a></li>
          <li class="nav-item"><a href="products.php" class="nav-link"><i class="nav-icon fas fa-box"></i><p>Manage Products</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h2><i class="fas fa-truck"></i> Manage Suppliers</h2>
        <?php if ($message): ?>
          <div class="alert alert-info"><?= $message; ?></div>
        <?php endif; ?>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- LEFT SIDE: FORM -->
          <div class="col-md-4 form-section">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Add Supplier</h3>
              </div>
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" name="supplier_name" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Contact Person</label>
                    <input type="text" name="contact_person" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control">
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="add" class="btn btn-success btn-block">Save</button>
                </div>
              </form>

              <!-- Edit Form -->
              <?php if (isset($_GET['edit'])):
                $editSup = $supplier->getSupplierById($_GET['edit']);
                if ($editSup): ?>
                <div class="card card-warning mt-4">
                  <div class="card-header"><h3 class="card-title">Edit Supplier</h3></div>
                  <form method="POST">
                    <input type="hidden" name="id" value="<?= $editSup['supplier_id'] ?>">
                    <div class="card-body">
                      <div class="form-group">
                        <label>Supplier Name</label>
                        <input type="text" name="supplier_name" value="<?= $editSup['supplier_name'] ?>" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Contact Person</label>
                        <input type="text" name="contact_person" value="<?= $editSup['contact_person'] ?>" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" value="<?= $editSup['contact_number'] ?>" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="<?= $editSup['address'] ?>" class="form-control">
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" name="update" class="btn btn-warning btn-block">Update</button>
                    </div>
                  </form>
                </div>
              <?php endif; endif; ?>
            </div>
          </div>

          <!-- RIGHT SIDE: TABLE -->
          <div class="col-md-8">
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Supplier List</h3>
              </div>
              <div class="card-body">
                <?php if (!empty($suppliers)): ?>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Contact #</th>
                        <th>Address</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($suppliers as $s): ?>
                      <tr>
                        <td><?= $s['supplier_id'] ?></td>
                        <td><?= htmlspecialchars($s['supplier_name']) ?></td>
                        <td><?= htmlspecialchars($s['contact_person']) ?></td>
                        <td><?= htmlspecialchars($s['contact_number']) ?></td>
                        <td><?= htmlspecialchars($s['address']) ?></td>
                        <td>
                          <a href="?edit=<?= $s['supplier_id'] ?>" class="btn btn-sm btn-info">Edit</a>
                          <a href="?delete=<?= $s['supplier_id'] ?>" onclick="return confirm('Delete this supplier?')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                <?php else: ?>
                  <p>No suppliers found.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
