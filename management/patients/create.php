<?php
session_start();
ob_start();

include '../config/database.php';
include '../includes/header.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
<<<<<<< HEAD
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);

  $query = "INSERT INTO patients (full_name, birth_date, gender, phone, address) 
            VALUES (?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sssss", $full_name, $birth_date, $gender, $phone, $address);

  if (mysqli_stmt_execute($stmt)) {
    ob_end_clean();
=======
  $full_name = $_POST['full_name'];
  $gender = $_POST['gender'];
  $birth_date = $_POST['birth_date'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];

  $query = "INSERT INTO patients (full_name, gender, birth_date, phone, address) VALUES ('$full_name', '$gender', '$birth_date', '$phone', '$address')";

  if (mysqli_query($conn, $query)) {
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
    $_SESSION['success_message'] = "Thêm bệnh nhân thành công";
    header('Location: index.php');
    exit();
  } else {
    $_SESSION['error_message'] = "Lỗi: " . mysqli_error($conn);
  }
}
?>

<div class="container-fluid margin--top">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="card-title mb-0 fw-bold text-primary">
            <i class="fas fa-user-injured me-2"></i>Thêm bệnh nhân mới
          </h5>
        </div>
        <div class="card-body">
          <form method="POST" class="needs-validation" novalidate>
            <div class="mb-4">
              <label class="form-label fw-bold">Họ và tên</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user text-primary"></i>
                </span>
                <input type="text" name="full_name" class="form-control" required>
                <div class="invalid-feedback">
                  Vui lòng nhập họ và tên
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Giới tính</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-venus-mars text-primary"></i>
                </span>
                <select name="gender" class="form-select" required>
                  <option value="">Chọn giới tính</option>
                  <option value="Male">Nam</option>
                  <option value="Female">Nữ</option>
                </select>
                <div class="invalid-feedback">
                  Vui lòng chọn giới tính
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Ngày sinh</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-calendar text-primary"></i>
                </span>
                <input type="date" name="birth_date" class="form-control" required>
                <div class="invalid-feedback">
                  Vui lòng chọn ngày sinh
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Số điện thoại</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-phone text-primary"></i>
                </span>
                <input type="tel" name="phone" class="form-control" pattern="[0-9]{10}" required>
                <div class="invalid-feedback">
                  Vui lòng nhập số điện thoại hợp lệ (10 số)
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Địa chỉ</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-map-marker-alt text-primary"></i>
                </span>
                <textarea name="address" class="form-control" required></textarea>
                <div class="invalid-feedback">
                  Vui lòng nhập địa chỉ
                </div>
              </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="index.php" class="btn btn-light me-md-2">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Lưu
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