<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/classes/Product.php";
require_once __DIR__ . "/classes/Category.php";
require_once __DIR__ . "/classes/Supplier.php";

$product = new Product();
$category = new Category();
$supplier = new Supplier();

$message = "";

// Fetch data
$categories = $category->getCategories();
$suppliers = $supplier->getSuppliers();
$products = $product->getProducts();

// ADD
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['product_name'];
    $cat = $_POST['category_id'];
    $sup = $_POST['supplier_id'];
    $qty = $_POST['quantity'];
    $price = $_POST['price'];

    $message = $product->addProduct($name, $cat, $sup, $qty, $price)
        ? "✅ Product added successfully!"
        : "❌ Error adding product.";
}

// UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['product_name'];
    $cat = $_POST['category_id'];
    $sup = $_POST['supplier_id'];
    $qty = $_POST['quantity'];
    $price = $_POST['price'];

    $message = $product->updateProduct($id, $name, $cat, $sup, $qty, $price)
        ? "✅ Product updated successfully!"
        : "❌ Error updating product.";
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $message = $product->deleteProduct($id)
        ? "✅ Product deleted successfully!"
        : "❌ Error deleting product.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .form-section { border-right: 2px solid #ddd; }
    .table-section { overflow-x: auto; }
    .card { height: 100%; }
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
      <i class="fas fa-boxes ml-2"></i>
      <span class="brand-text font-weight-light ml-2">PMS Dashboard</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item"><a href="index.php" class="nav-link"><i class="nav-icon fas fa-home"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="categories.php" class="nav-link"><i class="nav-icon fas fa-layer-group"></i><p>Manage Categories</p></a></li>
          <li class="nav-item"><a href="suppliers.php" class="nav-link"><i class="nav-icon fas fa-truck"></i><p>Manage Suppliers</p></a></li>
          <li class="nav-item"><a href="products.php" class="nav-link active"><i class="nav-icon fas fa-box"></i><p>Manage Products</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h2><i class="fas fa-box"></i> Manage Products</h2>
        <?php if ($message): ?>
          <div class="alert alert-info mt-2"><?= $message ?></div>
        <?php endif; ?>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <!-- LEFT SIDE: FORM -->
          <div class="col-md-4 form-section">
            <!-- Add Product -->
            <div class="card card-warning">
              <div class="card-header"><h3 class="card-title">Add Product</h3></div>
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="product_name" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                      <option value="">Select Category</option>
                      <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['category_id'] ?>"><?= $c['category_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Supplier</label>
                    <select name="supplier_id" class="form-control" required>
                      <option value="">Select Supplier</option>
                      <?php foreach ($suppliers as $s): ?>
                        <option value="<?= $s['supplier_id'] ?>"><?= $s['supplier_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" class="form-control" min="0" required>
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="add" class="btn btn-warning btn-block">Save Product</button>
                </div>
              </form>
            </div>

            <!-- Edit Product -->
            <?php if (isset($_GET['edit'])):
              $editProduct = $product->getProductById($_GET['edit']);
              if ($editProduct): ?>
              <div class="card card-info mt-4">
                <div class="card-header"><h3 class="card-title">Edit Product</h3></div>
                <form method="POST">
                  <input type="hidden" name="id" value="<?= $editProduct['product_id'] ?>">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Product Name</label>
                      <input type="text" name="product_name" value="<?= htmlspecialchars($editProduct['product_name']) ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Category</label>
                      <select name="category_id" class="form-control" required>
                        <?php foreach ($categories as $c): ?>
                          <option value="<?= $c['category_id'] ?>" <?= $c['category_id'] == $editProduct['category_id'] ? 'selected' : '' ?>>
                            <?= $c['category_name'] ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Supplier</label>
                      <select name="supplier_id" class="form-control" required>
                        <?php foreach ($suppliers as $s): ?>
                          <option value="<?= $s['supplier_id'] ?>" <?= $s['supplier_id'] == $editProduct['supplier_id'] ? 'selected' : '' ?>>
                            <?= $s['supplier_name'] ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Quantity</label>
                      <input type="number" name="quantity" value="<?= $editProduct['quantity'] ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Price</label>
                      <input type="number" step="0.01" name="price" value="<?= $editProduct['price'] ?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" name="update" class="btn btn-info btn-block">Update Product</button>
                  </div>
                </form>
              </div>
            <?php endif; endif; ?>
          </div>

          <!-- RIGHT SIDE: TABLE -->
          <div class="col-md-8 table-section">
            <div class="card card-dark">
              <div class="card-header"><h3 class="card-title">Product List</h3></div>
              <div class="card-body">
                <?php if (!empty($products)): ?>
                  <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Action</th>
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
                        <td>
                          <a href="?edit=<?= $p['product_id'] ?>" class="btn btn-sm btn-info">Edit</a>
                          <a href="?delete=<?= $p['product_id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                <?php else: ?>
                  <p>No products found.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
