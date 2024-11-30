<?php
ob_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/check_admin.php';  // Chỉ admin mới được sửa nhân viên

$id = $_GET['id'];

$dept_query = "SELECT * FROM departments";
$departments = mysqli_query($conn, $dept_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $full_name = $_POST['full_name'];
  $gender = $_POST['gender'];
  $birth_year = $_POST['birth_year'];
  $position = $_POST['position'];
  $department_id = $_POST['department_id'];

  $query = "UPDATE staff SET 
              full_name = '$full_name',
              gender = '$gender',
              birth_year = $birth_year,
              position = '$position',
              department_id = $department_id
              WHERE id = $id";

  if (mysqli_query($conn, $query)) {
    ob_end_clean();
    header('Location: index.php');
    exit();
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }
}

$query = "SELECT * FROM staff WHERE id = $id";
$result = mysqli_query($conn, $query);
$staff = mysqli_fetch_assoc($result);
?>

<div class="container-fluid margin--top">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="card-title mb-0 fw-bold text-primary">
            <i class="fas fa-user-md me-2"></i>Sửa thông tin nhân viên
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
                <input type="text" name="full_name" class="form-control" value="<?php echo $staff['full_name']; ?>" required>
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
                  <option value="Male" <?php echo ($staff['gender'] == 'Male') ? 'selected' : ''; ?>>Nam</option>
                  <option value="Female" <?php echo ($staff['gender'] == 'Female') ? 'selected' : ''; ?>>Nữ</option>
                  <option value="Other" <?php echo ($staff['gender'] == 'Other') ? 'selected' : ''; ?>>Khác</option>
                </select>
                <div class="invalid-feedback">
                  Vui lòng chọn giới tính
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Năm sinh</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-calendar text-primary"></i>
                </span>
                <input type="number" name="birth_year" class="form-control"
                  value="<?php echo $staff['birth_year']; ?>"
                  min="1900" max="<?php echo date('Y'); ?>" required>
                <div class="invalid-feedback">
                  Vui lòng nhập năm sinh hợp lệ
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Chức vụ</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-briefcase text-primary"></i>
                </span>
                <input type="text" name="position" class="form-control" value="<?php echo $staff['position']; ?>" required>
                <div class="invalid-feedback">
                  Vui lòng nhập chức vụ
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Phòng ban</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-hospital text-primary"></i>
                </span>
                <select name="department_id" class="form-select" required>
                  <?php while ($department = mysqli_fetch_assoc($departments)): ?>
                    <option value="<?php echo $department['id']; ?>"
                      <?php echo ($staff['department_id'] == $department['id']) ? 'selected' : ''; ?>>
                      <?php echo $department['name']; ?>
                    </option>
                  <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">
                  Vui lòng chọn phòng ban
                </div>
              </div>
            </div>

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
  // Form validation
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