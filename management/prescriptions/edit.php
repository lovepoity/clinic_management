<?php
ob_start();
include '../config/database.php';
include '../includes/header.php';

$id = $_GET['id'];

$patients_query = "SELECT * FROM patients";
$patients = mysqli_query($conn, $patients_query);

$staff_query = "SELECT * FROM staff";
$staff = mysqli_query($conn, $staff_query);

$medicines_query = "SELECT * FROM medicines WHERE quantity > 0";
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
    $old_query = "SELECT medicine_id, quantity FROM prescriptions WHERE id = $id";
    $old_result = mysqli_query($conn, $old_query);
    $old_data = mysqli_fetch_assoc($old_result);

    $update_old_medicine = "UPDATE medicines SET quantity = quantity + {$old_data['quantity']} 
                              WHERE id = {$old_data['medicine_id']}";
    mysqli_query($conn, $update_old_medicine);

    $update_query = "UPDATE prescriptions SET 
                        patient_id = $patient_id,
                        staff_id = $staff_id,
                        medicine_id = $medicine_id,
                        quantity = $quantity,
                        price = $total_price,
                        diagnosis = '$diagnosis',
                        doctor_notes = '$doctor_notes'
                        WHERE id = $id";
    mysqli_query($conn, $update_query);

    $update_new_medicine = "UPDATE medicines SET quantity = quantity - $quantity 
                              WHERE id = $medicine_id";
    mysqli_query($conn, $update_new_medicine);

    mysqli_commit($conn);
    ob_end_clean();
    header('Location: index.php');
    exit();
  } catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error updating record: " . $e->getMessage();
  }
}

$query = "SELECT * FROM prescriptions WHERE id = $id";
$result = mysqli_query($conn, $query);
$prescription = mysqli_fetch_assoc($result);
?>

<div class="container-fluid margin--top">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="card-title mb-0 fw-bold text-primary">
            <i class="fas fa-prescription me-2"></i>Sửa đơn thuốc
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
                      <?php while ($patient = mysqli_fetch_assoc($patients)): ?>
                        <option value="<?php echo $patient['id']; ?>"
                          <?php echo ($prescription['patient_id'] == $patient['id']) ? 'selected' : ''; ?>>
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
                      <?php while ($doctor = mysqli_fetch_assoc($staff)): ?>
                        <option value="<?php echo $doctor['id']; ?>"
                          <?php echo ($prescription['staff_id'] == $doctor['id']) ? 'selected' : ''; ?>>
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
                      <?php while ($medicine = mysqli_fetch_assoc($medicines)): ?>
                        <option value="<?php echo $medicine['id']; ?>"
                          <?php echo ($prescription['medicine_id'] == $medicine['id']) ? 'selected' : ''; ?>>
                          <?php echo $medicine['name']; ?>
                          (Còn: <?php echo $medicine['quantity']; ?>) -
                          <?php echo number_format($medicine['price'], 0); ?>đ
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
                    <input type="number" name="quantity" class="form-control"
                      value="<?php echo $prescription['quantity']; ?>" min="1" required>
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
                <textarea name="diagnosis" class="form-control" rows="3" required><?php echo $prescription['diagnosis']; ?></textarea>
                <div class="invalid-feedback">
                  Vui lòng nhập chẩn đoán
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Ghi chú của bác sĩ</label>
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="fas fa-notes-medical text-primary"></i>
                </span>
                <textarea name="doctor_notes" class="form-control" rows="3" required><?php echo $prescription['doctor_notes']; ?></textarea>
                <div class="invalid-feedback">
                  Vui lòng nhập ghi chú
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