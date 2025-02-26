<?php
session_start();
ob_start();

include '../config/database.php';
include '../includes/header.php';

$id = $_GET['id'];
$success = false;

$patients_query = "SELECT * FROM patients";
$patients = mysqli_query($conn, $patients_query);

$staff_query = "SELECT * FROM staff";
$staff = mysqli_query($conn, $staff_query);

$medicines_query = "SELECT * FROM medicines WHERE quantity > 0";
$medicines = mysqli_query($conn, $medicines_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $patient_id = $_POST['patient_id'];
  $staff_id = $_POST['staff_id'];
  $diagnosis = $_POST['diagnosis'];
  $doctor_notes = $_POST['doctor_notes'];

  mysqli_begin_transaction($conn);

  try {
    $update_query = "UPDATE prescriptions 
                    SET patient_id = ?, 
                        staff_id = ?, 
                        diagnosis = ?, 
                        doctor_notes = ?
                    WHERE id = ?";

    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "iissi", $patient_id, $staff_id, $diagnosis, $doctor_notes, $id);
    mysqli_stmt_execute($stmt);

    mysqli_query($conn, "DELETE FROM prescription_details WHERE prescription_id = $id");

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
          $id,
          $medicines[$i],
          $batch_ids[$i],
          $quantities[$i],
          $notes[$i]
        );
        mysqli_stmt_execute($detail_stmt);
      }
    }

    mysqli_commit($conn);
    header("Location: view.php?id=$id");
    exit();
  } catch (Exception $e) {
    mysqli_rollback($conn);
    header("Location: edit.php?id=$id");
    exit();
  }
}

$query = "SELECT p.*, 
          pt.full_name as patient_name,
          COALESCE(s.full_name, 'N/A') as staff_name
          FROM prescriptions p
          LEFT JOIN patients pt ON p.patient_id = pt.id 
          LEFT JOIN staff s ON p.staff_id = s.id
          WHERE p.id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$prescription = mysqli_stmt_get_result($stmt)->fetch_assoc();

$medicines_query = "SELECT pd.*,
                   m.name as medicine_name,
                   m.price as medicine_price,
                   mb.batch_number,
                   (mb.quantity - COALESCE(
                     (SELECT SUM(quantity) 
                      FROM prescription_details 
                      WHERE batch_id = mb.id AND prescription_id != $id), 0
                   )) as remaining
                   FROM prescription_details pd
                   LEFT JOIN medicines m ON pd.medicine_id = m.id
                   LEFT JOIN medicine_batches mb ON pd.batch_id = mb.id
                   WHERE pd.prescription_id = $id";

$medicines_result = mysqli_query($conn, $medicines_query);
$prescription_medicines = [];
while ($row = mysqli_fetch_assoc($medicines_result)) {
  $prescription_medicines[] = $row;
}

$patients_query = "SELECT * FROM patients ORDER BY full_name";
$patients = mysqli_query($conn, $patients_query);

$doctors_query = "SELECT s.*, d.name as department_name 
                 FROM staff s 
                 LEFT JOIN departments d ON s.department_id = d.id 
                 ORDER BY s.full_name";
$doctors = mysqli_query($conn, $doctors_query);

$medicines_query = "SELECT m.*, mt.name as type_name 
                   FROM medicines m 
                   LEFT JOIN medicine_types mt ON m.type_id = mt.id 
                   ORDER BY m.name";
$medicines = mysqli_query($conn, $medicines_query);
?>

<div class="container-fluid margin--top">
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
      <h5 class="card-title mb-0 fw-bold text-primary">
        <i class="fas fa-edit me-2"></i>Sửa đơn thuốc #<?php echo $id; ?>
      </h5>
    </div>
    <div class="card-body">
      <form method="POST" action="/management/prescriptions/edit.php?id=<?php echo $id; ?>" class="needs-validation" novalidate>
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Bệnh nhân</label>
            <select name="patient_id" class="form-select" required>
              <option value="">-- Chọn bệnh nhân --</option>
              <?php while ($patient = mysqli_fetch_assoc($patients)): ?>
                <option value="<?php echo $patient['id']; ?>"
                  <?php echo ($patient['id'] == $prescription['patient_id']) ? 'selected' : ''; ?>>
                  <?php echo $patient['full_name']; ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Bác sĩ</label>
            <select name="staff_id" class="form-select" required>
              <option value="">-- Chọn bác sĩ --</option>
              <?php while ($doctor = mysqli_fetch_assoc($doctors)): ?>
                <option value="<?php echo $doctor['id']; ?>"
                  <?php echo ($doctor['id'] == $prescription['staff_id']) ? 'selected' : ''; ?>>
                  <?php echo $doctor['full_name']; ?> - <?php echo $doctor['position']; ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

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
              <?php foreach ($prescription_medicines as $med): ?>
                <tr>
                  <td>
                    <select name="medicines[]" class="form-select medicine-select" required>
                      <option value="">Chọn thuốc...</option>
                      <?php
                      mysqli_data_seek($medicines, 0);
                      while ($medicine = mysqli_fetch_assoc($medicines)):
                      ?>
                        <option value="<?php echo $medicine['id']; ?>"
                          <?php echo ($medicine['id'] == $med['medicine_id']) ? 'selected' : ''; ?>>
                          <?php echo $medicine['name']; ?> (<?php echo $medicine['type_name']; ?>)
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </td>
                  <td>
                    <input type="number" name="quantity[]" class="form-control"
                      value="<?php echo $med['quantity']; ?>" min="1" required>
                  </td>
                  <td>
                    <select name="batch_id[]" class="form-select batch-select" required>
                      <option value="<?php echo $med['batch_id']; ?>">
                        <?php echo $med['batch_number']; ?> (Còn: <?php echo $med['remaining'] + $med['quantity']; ?>)
                      </option>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="notes[]" class="form-control"
                      value="<?php echo $med['notes']; ?>" placeholder="Cách dùng...">
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <button type="button" class="btn btn-success btn-sm" id="addMedicine">
            <i class="fas fa-plus me-2"></i>Thêm thuốc
          </button>
        </div>

        <div class="mb-3">
          <label class="form-label">Chẩn đoán</label>
          <textarea name="diagnosis" class="form-control" rows="3" required><?php echo $prescription['diagnosis']; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Ghi chú của bác sĩ</label>
          <textarea name="doctor_notes" class="form-control" rows="3"><?php echo $prescription['doctor_notes'] ?? ''; ?></textarea>
        </div>

        <div class="text-end">
          <a href="view.php?id=<?php echo $id; ?>" class="btn btn-light me-2">Hủy</a>
          <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </div>
      </form>
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
</script>

<?php include '../includes/footer.php'; ?>
<?php
ob_end_flush();
?>