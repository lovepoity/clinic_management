<?php
ob_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/check_admin.php';  // Chỉ admin mới được thêm nhân viên

$dept_query = "SELECT * FROM departments";
$departments = mysqli_query($conn, $dept_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $full_name = $_POST['full_name'];
  $gender = $_POST['gender'];
  $birth_year = $_POST['birth_year'];
  $position = $_POST['position'];
  $department_id = $_POST['department_id'];

  $query = "INSERT INTO staff (full_name, gender, birth_year, position, department_id) 
              VALUES ('$full_name', '$gender', $birth_year, '$position', $department_id)";

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
            <i class="fas fa-user-md me-2"></i>Add New Staff Member
          </h5>
        </div>
        <div class="card-body">
          <form method="POST" class="needs-validation" novalidate>
            <div class="mb-4">
              <label class="form-label fw-bold">Full Name</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-user text-primary"></i>
                </span>
                <input type="text" name="full_name" class="form-control" required>
                <div class="invalid-feedback">
                  Please enter full name
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Gender</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-venus-mars text-primary"></i>
                </span>
                <select name="gender" class="form-select" required>
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
                <div class="invalid-feedback">
                  Please select gender
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Birth Year</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-calendar text-primary"></i>
                </span>
                <input type="number" name="birth_year" class="form-control"
                  min="1900" max="<?php echo date('Y'); ?>" required>
                <div class="invalid-feedback">
                  Please enter valid birth year
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Position</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-briefcase text-primary"></i>
                </span>
                <input type="text" name="position" class="form-control" required>
                <div class="invalid-feedback">
                  Please enter position
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Department</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-hospital text-primary"></i>
                </span>
                <select name="department_id" class="form-select" required>
                  <option value="">Select Department</option>
                  <?php while ($dept = mysqli_fetch_assoc($departments)): ?>
                    <option value="<?php echo $dept['id']; ?>">
                      <?php echo $dept['name']; ?>
                    </option>
                  <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">
                  Please select department
                </div>
              </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="index.php" class="btn btn-light me-md-2">
                <i class="fas fa-arrow-left me-2"></i>Back
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Save Staff Member
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