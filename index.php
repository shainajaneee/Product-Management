<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/classes/Product.php";

$product = new Product();
$products = $product->getProducts(); // Get all products to display
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Management System</title>

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link text-danger" href="#" onclick="alert('Logging out...')">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
      <i class="fas fa-boxes text-light ml-2"></i>
      <span class="brand-text font-weight-light ml-2">PMS Dashboard</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item">
            <a href="index.php" class="nav-link active">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <!-- ✅ FIXED: these links should point to pages (not class files) -->
          <li class="nav-item">
            <a href="categories.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>Manage Categories</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="suppliers.php" class="nav-link">
              <i class="nav-icon fas fa-truck"></i>
              <p>Manage Suppliers</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="products.php" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>Manage Products</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-chart-line"></i> Product Management System</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Dashboard Summary -->
        <div class="card">
          <div class="card-header bg-primary text-white">
          </div>
          <div class="card-body">

            <div class="row">
              <!-- Category Box -->
              <div class="col-md-4">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>Categories</h3>
                    <p>Manage all product categories</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-list"></i>
                  </div>
                  <a href="categories.php" class="small-box-footer">Go to Categories <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <!-- Supplier Box -->
              <div class="col-md-4">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Suppliers</h3>
                    <p>Manage supplier information</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-truck"></i>
                  </div>
                  <a href="suppliers.php" class="small-box-footer">Go to Suppliers <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <!-- Product Box -->
              <div class="col-md-4">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>Products</h3>
                    <p>View and manage products</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-box"></i>
                  </div>
                  <a href="products.php" class="small-box-footer">Go to Products <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Product Table -->
        <div class="card mt-4">
          <div class="card-header bg-dark text-white">
            <h3 class="card-title"><i class="fas fa-table"></i> Product List</h3>
          </div>
          <div class="card-body">
            <?php if (!empty($products)): ?>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Quantity</th>
                    <th>Price</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($products as $p): ?>
                  <tr>
                    <td><?= $p['product_id'] ?></td>
                    <td><?= htmlspecialchars($p['product_name']) ?></td>
                    <td><?= htmlspecialchars($p['category_name']) ?></td>
                    <td><?= htmlspecialchars($p['supplier_name']) ?></td>
                    <td><?= $p['quantity'] ?></td>
                    <td>₱<?= number_format($p['price'], 2) ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p>No products available. Add some in <a href="products.php">Manage Products</a>.</p>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer text-center">
    <strong>&copy; <?= date("Y"); ?> Product Management System.</strong> All rights reserved.
  </footer>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
