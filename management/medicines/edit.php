<?php
ob_start();
include '../config/database.php';
include '../includes/header.php';

$id = $_GET['id'];

$type_query = "SELECT * FROM medicine_types";
$types = mysqli_query($conn, $type_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $type_id = $_POST['type_id'];
<<<<<<< HEAD
  $price = $_POST['price'];

  $query = "UPDATE medicines SET 
            name = ?,
            type_id = ?,
            price = ?
            WHERE id = ?";

  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sidi", $name, $type_id, $price, $id);

  if (mysqli_stmt_execute($stmt)) {
=======
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];
  $import_date = $_POST['import_date'];

  $query = "UPDATE medicines SET 
              name = '$name',
              type_id = $type_id,
              quantity = $quantity,
              price = $price,
              import_date = '$import_date'
              WHERE id = $id";

  if (mysqli_query($conn, $query)) {
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
    ob_end_clean();
    header('Location: index.php');
    exit();
  } else {
<<<<<<< HEAD
    echo "Error: " . mysqli_error($conn);
=======
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
  }
}

$query = "SELECT * FROM medicines WHERE id = $id";
$result = mysqli_query($conn, $query);
$medicine = mysqli_fetch_assoc($result);
?>

<div class="container-fluid margin--top">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="card-title mb-0 fw-bold text-primary">
            <i class="fas fa-pills me-2"></i>Sửa thông tin thuốc
          </h5>
        </div>
        <div class="card-body">
          <form method="POST" class="needs-validation" novalidate>
            <div class="mb-4">
              <label class="form-label fw-bold">Tên thuốc</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-capsules text-primary"></i>
                </span>
                <input type="text" name="name" class="form-control" value="<?php echo $medicine['name']; ?>" required>
                <div class="invalid-feedback">
                  Vui lòng nhập tên thuốc
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Loại thuốc</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-tags text-primary"></i>
                </span>
                <select name="type_id" class="form-select" required>
                  <?php while ($type = mysqli_fetch_assoc($types)): ?>
                    <option value="<?php echo $type['id']; ?>" <?php echo ($medicine['type_id'] == $type['id']) ? 'selected' : ''; ?>>
                      <?php echo $type['name']; ?>
                    </option>
                  <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">
                  Vui lòng chọn loại thuốc
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-4">
<<<<<<< HEAD
                  <label class="form-label fw-bold">Giá (VNĐ)</label>
=======
                  <label class="form-label fw-bold">Số lượng</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="fas fa-cubes text-primary"></i>
                    </span>
                    <input type="number" name="quantity" class="form-control" value="<?php echo $medicine['quantity']; ?>" min="0" required>
                    <div class="invalid-feedback">
                      Vui lòng nhập số lượng hợp lệ
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label fw-bold">Giá</label>
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="fas fa-dollar-sign text-primary"></i>
                    </span>
<<<<<<< HEAD
                    <input type="number" name="price" class="form-control" value="<?php echo $medicine['price']; ?>" min="0" required>
                    <span class="input-group-text bg-light">VNĐ</span>
=======
                    <input type="number" name="price" class="form-control" value="<?php echo $medicine['price']; ?>" min="0" step="0.01" required>
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
                    <div class="invalid-feedback">
                      Vui lòng nhập giá hợp lệ
                    </div>
                  </div>
                </div>
              </div>
            </div>

<<<<<<< HEAD
=======
            <div class="mb-4">
              <label class="form-label fw-bold">Ngày nhập</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-calendar text-primary"></i>
                </span>
                <input type="date" name="import_date" class="form-control" value="<?php echo $medicine['import_date']; ?>" required>
                <div class="invalid-feedback">
                  Vui lòng chọn ngày nhập
                </div>
              </div>
            </div>

>>>>>>> 0695859d63a820c859be24892da491c533d353aa
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="index.php" class="btn btn-light me-md-2">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Cập nhật
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  (function() {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
      .forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>

<?php include '../includes/footer.php'; ?>