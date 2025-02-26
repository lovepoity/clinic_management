<?php
include '../config/database.php';
include '../includes/header.php';

$query = "SELECT p.id, 
          p.prescription_date,
          p.diagnosis,
          pat.full_name as patient_name,
          s.full_name as doctor_name,
          GROUP_CONCAT(
            CONCAT(m.name, ' (', pd.quantity, ' viên) - ', pd.notes)
            SEPARATOR '<br>'
          ) as medicines_list
          FROM prescriptions p
          LEFT JOIN patients pat ON p.patient_id = pat.id
          LEFT JOIN staff s ON p.staff_id = s.id
          LEFT JOIN prescription_details pd ON p.id = pd.prescription_id
          LEFT JOIN medicines m ON pd.medicine_id = m.id
          GROUP BY p.id, p.prescription_date, p.diagnosis, pat.full_name, s.full_name
          ORDER BY p.prescription_date DESC";

$result = mysqli_query($conn, $query);
?>

<div class="container-fluid margin--top">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold text-primary">
          <i class="fas fa-prescription me-2"></i>Quản lý đơn thuốc
        </h2>
        <a href="create.php" class="btn btn-primary">
          <i class="fas fa-plus me-2"></i>Tạo đơn thuốc
        </a>
      </div>

      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Mã đơn</th>
                  <th>Ngày kê</th>
                  <th>Bệnh nhân</th>
                  <th>Bác sĩ</th>
                  <th>Chẩn đoán</th>
                  <th>Thuốc đã kê</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['prescription_date'])); ?></td>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td><?php echo $row['diagnosis']; ?></td>
                    <td><?php echo $row['medicines_list']; ?></td>
                    <td>
                      <a href="view.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-sm btn-outline-primary me-2">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="edit.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-sm btn-outline-warning me-2">
                        <i class="fas fa-edit"></i>
                      </a>
                      <button class="btn btn-sm btn-outline-danger"
                        onclick="deletePrescription(<?php echo $row['id']; ?>)">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="notification" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script>
  function showToast(message, isSuccess = true) {
    const toast = document.getElementById('notification');
    toast.className = `toast align-items-center text-white border-0 bg-${isSuccess ? 'success' : 'danger'}`;
    toast.querySelector('.toast-body').textContent = message;
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
  }

  function deletePrescription(id) {
    if (confirm('Bạn có chắc muốn xóa đơn thuốc này?')) {
      fetch(`delete.php?id=${id}`)
        .then(response => {
          if (response.ok) {
            location.reload();
          } else {
            showToast('Có lỗi xảy ra khi xóa', false);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Có lỗi xảy ra khi xóa', false);
        });
    }
  }
</script>

<?php include '../includes/footer.php'; ?>