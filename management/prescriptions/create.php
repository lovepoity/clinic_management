<?php
ob_start();
include '../config/database.php';
include '../includes/header.php';

$patients_query = "SELECT * FROM patients ORDER BY full_name";
$patients = mysqli_query($conn, $patients_query);

$doctors_query = "SELECT * FROM staff ORDER BY full_name";
$doctors = mysqli_query($conn, $doctors_query);

$medicines_query = "SELECT m.id, 
                          m.name, 
                          m.price,
                          mt.name as type_name,
                          COALESCE(SUM(mb.quantity), 0) as total_quantity 
                   FROM medicines m
                   LEFT JOIN medicine_types mt ON m.type_id = mt.id 
                   LEFT JOIN medicine_batches mb ON m.id = mb.medicine_id
                   GROUP BY m.id, m.name, m.price, mt.name
                   HAVING total_quantity > 0
                   ORDER BY m.name";

$medicines = mysqli_query($conn, $medicines_query);

if (!$medicines) {
  die("Lỗi truy vấn: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $patient_id = $_POST['patient_id'];
  $staff_id = $_POST['staff_id'];
  $diagnosis = $_POST['diagnosis'];
  $doctor_notes = $_POST['doctor_notes'];
  $prescription_date = date('Y-m-d');

  mysqli_begin_transaction($conn);

  try {
    $query = "INSERT INTO prescriptions (patient_id, staff_id, diagnosis, doctor_notes, prescription_date) 
              VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iisss", $patient_id, $staff_id, $diagnosis, $doctor_notes, $prescription_date);

    if (mysqli_stmt_execute($stmt)) {
      $prescription_id = mysqli_insert_id($conn);

      $medicines = $_POST['medicines'];
      $quantities = $_POST['quantity'];
      $batch_ids = $_POST['batch_id'];
      $notes = $_POST['notes'];

      $detail_query = "INSERT INTO prescription_details 
                      (prescription_id, medicine_id, batch_id, quantity, notes) 
                      VALUES (?, ?, ?, ?, ?)";

      $detail_stmt = mysqli_prepare($conn, $detail_query);

      for ($i = 0; $i < count($medicines); $i++) {
        if (!empty($medicines[$i]) && !empty($quantities[$i]) && !empty($batch_ids[$i])) {
          mysqli_stmt_bind_param(
            $detail_stmt,
            "iiiis",
            $prescription_id,
            $medicines[$i],
            $batch_ids[$i],
            $quantities[$i],
            $notes[$i]
          );
          mysqli_stmt_execute($detail_stmt);
        }
      }

      mysqli_commit($conn);
      header("Location: view.php?id=$prescription_id");
      exit();
    }
  } catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Lỗi: " . $e->getMessage();
  }
}
?>

<div class="container-fluid margin--top">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold text-primary">
          <i class="fas fa-prescription me-2"></i>Tạo đơn thuốc mới
        </h2>
      </div>

      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="card-title mb-0 fw-bold text-primary">
            <i class="fas fa-file-prescription me-2"></i>Thông tin đơn thuốc
          </h5>
        </div>
        <div class="card-body">
          <form method="POST" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label fw-bold">Bệnh nhân</label>
                  <select name="patient_id" class="form-select" required>
                    <option value="">Chọn bệnh nhân...</option>
                    <?php while ($patient = mysqli_fetch_assoc($patients)): ?>
                      <option value="<?php echo $patient['id']; ?>">
                        <?php echo $patient['full_name']; ?> - <?php echo $patient['phone']; ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                  <div class="invalid-feedback">
                    Vui lòng chọn bệnh nhân
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label fw-bold">Bác sĩ</label>
                  <select name="staff_id" class="form-select" required>
                    <option value="">Chọn bác sĩ...</option>
                    <?php while ($doctor = mysqli_fetch_assoc($doctors)): ?>
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

            <div class="mb-4">
              <label class="form-label fw-bold">Danh sách thuốc</label>
              <div class="table-responsive">
                <table class="table table-bordered" id="medicineTable">
                  <thead>
                    <tr>
                      <th>Tên thuốc</th>
                      <th>Số lượng</th>
                      <th>Lô thuốc</th>
                      <th>Ghi chú</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select name="medicines[]" class="form-select medicine-select" required>
                          <option value="">Chọn thuốc...</option>
                          <?php while ($medicine = mysqli_fetch_assoc($medicines)): ?>
                            <option value="<?php echo $medicine['id']; ?>"
                              data-price="<?php echo $medicine['price']; ?>"
                              data-type="<?php echo $medicine['type_name']; ?>">
                              <?php echo $medicine['name']; ?> (<?php echo $medicine['type_name']; ?>) -
                              Tồn: <?php echo $medicine['total_quantity']; ?>
                            </option>
                          <?php endwhile; ?>
                        </select>
                      </td>
                      <td>
                        <input type="number" name="quantity[]" class="form-control" min="1" required>
                      </td>
                      <td>
                        <select name="batch_id[]" class="form-select batch-select" required>
                          <option value="">Chọn lô...</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="notes[]" class="form-control" placeholder="Cách dùng...">
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <button type="button" class="btn btn-success btn-sm" id="addMedicine">
                  <i class="fas fa-plus me-2"></i>Thêm thuốc
                </button>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Chẩn đoán</label>
              <textarea name="diagnosis" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Ghi chú của bác sĩ</label>
              <textarea name="doctor_notes" class="form-control" rows="3"></textarea>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="index.php" class="btn btn-light me-md-2">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Tạo đơn thuốc
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('addMedicine').onclick = function() {
    const firstRow = document.querySelector('#medicineTable tbody tr');
    const newRow = firstRow.cloneNode(true);

    newRow.querySelectorAll('select, input').forEach(el => el.value = '');

    newRow.querySelector('.remove-row').onclick = removeRow;
    newRow.querySelector('.medicine-select').onchange = loadBatches;

    document.querySelector('#medicineTable tbody').appendChild(newRow);
  };

  function removeRow() {
    const tbody = document.querySelector('#medicineTable tbody');
    if (tbody.children.length > 1) {
      this.closest('tr').remove();
    }
  }

  document.querySelectorAll('.remove-row').forEach(btn => {
    btn.onclick = removeRow;
  });

  function loadBatches() {
    const medicineId = this.value;
    const batchSelect = this.closest('tr').querySelector('.batch-select');

    if (!medicineId) {
      batchSelect.innerHTML = '<option value="">Chọn lô...</option>';
      return;
    }

    fetch(`get_batches.php?medicine_id=${medicineId}`)
      .then(response => response.json())
      .then(batches => {
        let options = '<option value="">Chọn lô...</option>';
        batches.forEach(batch => {
          options += `<option value="${batch.id}">
          ${batch.batch_number} - SL: ${batch.quantity} - HSD: ${batch.expiry_date}
        </option>`;
        });
        batchSelect.innerHTML = options;
      });
  }

  document.querySelectorAll('.medicine-select').forEach(select => {
    select.onchange = loadBatches;
  });

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