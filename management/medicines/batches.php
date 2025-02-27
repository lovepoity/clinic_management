<?php
include '../config/database.php';
include '../includes/header.php';

$medicine_id = $_GET['id'];

$medicine_query = "SELECT * FROM medicines WHERE id = $medicine_id";
$medicine_result = mysqli_query($conn, $medicine_query);
$medicine = mysqli_fetch_assoc($medicine_result);

$batches_query = "SELECT * FROM medicine_batches WHERE medicine_id = $medicine_id ORDER BY import_date DESC";
$batches = mysqli_query($conn, $batches_query);
?>

<div class="container-fluid margin--top">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold text-primary">
          <i class="fas fa-boxes me-2"></i>Quản lý lô thuốc - <?php echo $medicine['name']; ?>
        </h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBatchModal">
          <i class="fas fa-plus me-2"></i>Thêm lô mới
        </button>
      </div>

      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Mã lô</th>
                  <th>Số lượng</th>
                  <th>Ngày nhập</th>
                  <th>Hạn sử dụng</th>
                  <th>Số lượng còn lại</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($batch = mysqli_fetch_assoc($batches)): ?>
                  <tr>
                    <td><?php echo $batch['batch_number']; ?></td>
                    <td><?php echo $batch['quantity']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($batch['import_date'])); ?></td>
                    <td><?php echo $batch['expiry_date'] ? date('d/m/Y', strtotime($batch['expiry_date'])) : 'N/A'; ?></td>
                    <td>
                      <?php

                      $used_query = "SELECT COALESCE(SUM(quantity), 0) as used FROM prescription_details WHERE batch_id = " . $batch['id'];
                      $used_result = mysqli_query($conn, $used_query);
                      $used = mysqli_fetch_assoc($used_result)['used'];
                      $remaining = $batch['quantity'] - $used;
                      echo $remaining;
                      ?>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-outline-primary me-2"
                        onclick="editBatch(<?php echo htmlspecialchars(json_encode($batch)); ?>)">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="deleteBatch(<?php echo $batch['id']; ?>)">
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

<div class="modal fade" id="addBatchModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm lô thuốc mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="addBatchForm">
        <div class="modal-body">
          <input type="hidden" name="medicine_id" value="<?php echo $medicine_id; ?>">

          <div class="mb-3">
            <label class="form-label">Mã lô</label>
            <input type="text" name="batch_number" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="quantity" class="form-control" min="1" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Ngày nhập</label>
            <input type="date" name="import_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Hạn sử dụng</label>
            <input type="date" name="expiry_date" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu lô thuốc</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal sửa lô thuốc -->
<div class="modal fade" id="editBatchModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sửa thông tin lô thuốc</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editBatchForm">
        <div class="modal-body">
          <input type="hidden" name="batch_id" id="edit_batch_id">
          <input type="hidden" name="medicine_id" value="<?php echo $medicine_id; ?>">

          <div class="mb-3">
            <label class="form-label">Mã lô</label>
            <input type="text" name="batch_number" id="edit_batch_number" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="quantity" id="edit_quantity" class="form-control" min="1" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Ngày nhập</label>
            <input type="date" name="import_date" id="edit_import_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Hạn sử dụng</label>
            <input type="date" name="expiry_date" id="edit_expiry_date" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
      </form>
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

  document.getElementById('addBatchForm').onsubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    try {
      const response = await fetch('add_batch.php', {
        method: 'POST',
        body: formData
      });

      const message = await response.text();

      if (response.ok) {
        showToast('Thêm lô thuốc thành công');
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBatchModal'));
        modal.hide();
        location.reload();
      } else {
        showToast(message || 'Có lỗi xảy ra', false);
      }
    } catch (error) {
      showToast('Có lỗi xảy ra', false);
      console.error('Error:', error);
    }
  };

  function deleteBatch(id) {
    if (confirm('Bạn có chắc muốn xóa lô thuốc này?')) {
      fetch(`delete_batch.php?id=${id}`)
        .then(response => {
          if (response.ok) {
            showToast('Xóa lô thuốc thành công');
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

  function editBatch(batch) {
    document.getElementById('edit_batch_id').value = batch.id;
    document.getElementById('edit_batch_number').value = batch.batch_number;
    document.getElementById('edit_quantity').value = batch.quantity;
    document.getElementById('edit_import_date').value = batch.import_date;
    document.getElementById('edit_expiry_date').value = batch.expiry_date;

    const modal = new bootstrap.Modal(document.getElementById('editBatchModal'));
    modal.show();
  }

  document.getElementById('editBatchForm').onsubmit = async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    try {
      const response = await fetch('update_batch.php', {
        method: 'POST',
        body: formData
      });

      const message = await response.text();

      if (response.ok) {
        showToast('Cập nhật lô thuốc thành công');
        const modal = bootstrap.Modal.getInstance(document.getElementById('editBatchModal'));
        modal.hide();
        location.reload();
      } else {
        showToast(message || 'Có lỗi xảy ra', false);
      }
    } catch (error) {
      showToast('Có lỗi xảy ra', false);
      console.error('Error:', error);
    }
  };
</script>

<?php include '../includes/footer.php'; ?>