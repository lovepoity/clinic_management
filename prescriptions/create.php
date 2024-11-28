<?php
ob_start();
include '../config/database.php';
include '../includes/header.php';

$patients_query = "SELECT * FROM patients ORDER BY full_name";
$patients = mysqli_query($conn, $patients_query);

$staff_query = "SELECT * FROM staff ORDER BY full_name";
$staff = mysqli_query($conn, $staff_query);

$medicines_query = "SELECT * FROM medicines WHERE quantity > 0 ORDER BY name";
$medicines = mysqli_query($conn, $medicines_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $patient_id = $_POST['patient_id'];
  $staff_id = $_POST['staff_id'];
  $medicine_id = $_POST['medicine_id'];
  $quantity = $_POST['quantity'];
  $diagnosis = $_POST['diagnosis'];
  $doctor_notes = $_POST['doctor_notes'];

  $medicine_query = "SELECT price FROM medicines WHERE id = $medicine_id";
  $medicine_result = mysqli_query($conn, $medicine_query);
  $medicine_data = mysqli_fetch_assoc($medicine_result);
  $total_price = $medicine_data['price'] * $quantity;

  mysqli_begin_transaction($conn);

  try {
    $insert_query = "INSERT INTO prescriptions 
                        (patient_id, staff_id, medicine_id, quantity, price, diagnosis, doctor_notes, prescription_date) 
                        VALUES ($patient_id, $staff_id, $medicine_id, $quantity, $total_price, 
                                '$diagnosis', '$doctor_notes', CURRENT_DATE())";

    mysqli_query($conn, $insert_query);

    $update_medicine = "UPDATE medicines 
                          SET quantity = quantity - $quantity 
                          WHERE id = $medicine_id";
    mysqli_query($conn, $update_medicine);

    mysqli_commit($conn);
    ob_end_clean();
    header('Location: index.php');
    exit();
  } catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error: " . $e->getMessage();
  }
}
?>

<div class="container-fluid margin--top">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="card-title mb-0 fw-bold text-primary">
            <i class="fas fa-prescription me-2"></i>Tạo đơn thuốc mới
          </h5>
        </div>
        <div class="card-body">
          <form method="POST" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label fw-bold">Bệnh nhân</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="fas fa-user-injured text-primary"></i>
                    </span>
                    <select name="patient_id" class="form-select" required>
                      <option value="">Chọn bệnh nhân</option>
                      <?php while ($patient = mysqli_fetch_assoc($patients)): ?>
                        <option value="<?php echo $patient['id']; ?>">
                          <?php echo $patient['full_name']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback">
                      Vui lòng chọn bệnh nhân
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label fw-bold">Bác sĩ</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="fas fa-user-md text-primary"></i>
                    </span>
                    <select name="staff_id" class="form-select" required>
                      <option value="">Chọn bác sĩ</option>
                      <?php while ($doctor = mysqli_fetch_assoc($staff)): ?>
                        <option value="<?php echo $doctor['id']; ?>">
                          <?php echo $doctor['full_name']; ?> - <?php echo $doctor['position']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback">
                      Vui lòng chọn bác sĩ
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-8">
                <div class="mb-4">
                  <label class="form-label fw-bold">Thuốc</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="fas fa-pills text-primary"></i>
                    </span>
                    <select name="medicine_id" class="form-select" required>
                      <option value="">Chọn thuốc</option>
                      <?php while ($medicine = mysqli_fetch_assoc($medicines)): ?>
                        <option value="<?php echo $medicine['id']; ?>">
                          <?php echo $medicine['name']; ?>
                          (Stock: <?php echo $medicine['quantity']; ?>) -
                          $<?php echo number_format($medicine['price'], 2); ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback">
                      Vui lòng chọn thuốc
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-4">
                  <label class="form-label fw-bold">Số lượng</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="fas fa-cubes text-primary"></i>
                    </span>
                    <input type="number" name="quantity" class="form-control" min="1" required>
                    <div class="invalid-feedback">
                      Vui lòng nhập số lượng hợp lệ
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Chẩn đoán</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-stethoscope text-primary"></i>
                </span>
                <textarea name="diagnosis" class="form-control" rows="3" required></textarea>
                <div class="invalid-feedback">
                  Vui lòng nhập chẩn đoán
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Ghi chú bác sĩ</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-notes-medical text-primary"></i>
                </span>
                <textarea name="doctor_notes" class="form-control" rows="3" required></textarea>
                <div class="invalid-feedback">
                  Vui lòng nhập ghi chú bác sĩ
                </div>
              </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="index.php" class="btn btn-light me-md-2">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Lưu đơn thuốc
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