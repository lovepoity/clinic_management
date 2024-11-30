<?php
include '../config/database.php';
include '../includes/header.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = '';
if (!empty($search)) {
  $where = "WHERE pt.full_name LIKE '%$search%' OR s.full_name LIKE '%$search%' OR m.name LIKE '%$search%'";
}

$query = "SELECT p.*, 
          pt.full_name as patient_name,
          s.full_name as staff_name,
          m.name as medicine_name
          FROM prescriptions p
          LEFT JOIN patients pt ON p.patient_id = pt.id
          LEFT JOIN staff s ON p.staff_id = s.id
          LEFT JOIN medicines m ON p.medicine_id = m.id
          $where
          ORDER BY p.id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="prescriptions margin--top">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold text-primary">
      <i class="fas fa-file-prescription me-2"></i>Quản lý đơn thuốc
    </h2>
    <a href="/management/prescriptions/create.php" class="btn btn-primary">
      <i class="fas fa-plus me-2"></i>Thêm đơn thuốc
    </a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
      <form method="GET" class="row g-3">
        <div class="col-12 col-md-4">
          <div class="input-group">
            <span class="input-group-text bg-white">
              <i class="fas fa-search text-primary"></i>
            </span>
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bệnh nhân, bác sĩ hoặc thuốc" value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <?php if (!empty($search)): ?>
              <a href="/index.php" class="btn btn-outline-secondary">Xóa</a>
            <?php endif; ?>
          </div>
        </div>
      </form>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="px-4">ID</th>
              <th>Ngày</th>
              <th>Bệnh nhân</th>
              <th>Bác sĩ</th>
              <th>Thuốc</th>
              <th>Số lượng</th>
              <th>Tổng giá</th>
              <th class="text-end px-4">Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td class="px-4"><?php echo $row['id']; ?></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm bg-info bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-calendar text-info"></i>
                      </div>
                      <?php echo date('d M Y', strtotime($row['prescription_date'])); ?>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-primary">
                      <?php echo $row['patient_name']; ?>
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-success">
                      <?php echo $row['staff_name']; ?>
                    </span>
                  </td>
                  <td><?php echo $row['medicine_name']; ?></td>
                  <td><?php echo $row['quantity']; ?> đơn vị</td>
                  <td>
                    <span class="badge bg-warning text-dark">
                      $<?php echo number_format($row['price'], 2); ?>
                    </span>
                  </td>
                  <td class="text-end px-4">
                    <a href="/management/prescriptions/view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-info me-2">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="/management/prescriptions/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="/management/prescriptions/delete.php?id=<?php echo $row['id']; ?>"
                      class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Bạn có chắc chắn muốn xóa đơn thuốc này không?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center py-4">
                  <div class="text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p class="mb-0">Không tìm thấy đơn thuốc</p>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>