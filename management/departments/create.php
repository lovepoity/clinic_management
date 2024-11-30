<?php
ob_start();
include '../config/database.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $description = $_POST['description'];

  $query = "INSERT INTO departments (name, description) VALUES ('$name', '$description')";

  if (mysqli_query($conn, $query)) {
    ob_end_clean();
    header('Location: index.php');
    exit();
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }
}
?>

<div class="container-fluid margin--top">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="card-title mb-0 fw-bold text-primary">
            <i class="fas fa-hospital me-2"></i>Thêm phòng ban mới
          </h5>
        </div>
        <div class="card-body">
          <form method="POST" class="needs-validation" novalidate>
            <div class="mb-4">
              <label class="form-label fw-bold">Tên phòng ban</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-hospital-alt text-primary"></i>
                </span>
                <input type="text" name="name" class="form-control" required>
                <div class="invalid-feedback">
                  Vui lòng nhập tên phòng ban
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Mô tả</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-align-left text-primary"></i>
                </span>
                <textarea name="description" class="form-control" rows="3"></textarea>
              </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="index.php" class="btn btn-light me-md-2">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Lưu phòng ban
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>