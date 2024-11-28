<?php
include '../config/database.php';
include '../includes/header.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = '';
if (!empty($search)) {
  $where = "WHERE m.name LIKE '%$search%' 
              OR mt.name LIKE '%$search%'";
}

$query = "SELECT m.*, mt.name as type_name 
          FROM medicines m
          LEFT JOIN medicine_types mt ON m.type_id = mt.id
          $where 
          ORDER BY m.id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="medicines margin--top">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold text-primary">
      <i class="fas fa-pills me-2"></i>Quản lý thuốc
    </h2>
    <a href="/medicines/create.php" class="btn btn-primary">
      <i class="fas fa-plus me-2"></i>Thêm thuốc
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
            <input type="text" name="search" class="form-control"
              placeholder="Tìm theo tên thuốc hoặc loại thuốc"
              value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <?php if (!empty($search)): ?>
              <a href="index.php" class="btn btn-outline-secondary">Xóa tìm kiếm</a>
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
              <th>Tên thuốc</th>
              <th>Loại thuốc</th>
              <th>Số lượng</th>
              <th>Đơn giá</th>
              <th>Ngày nhập</th>
              <th class="text-end px-4">Thao tác</th>
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
                        <i class="fas fa-capsules text-info"></i>
                      </div>
                      <?php echo $row['name']; ?>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-primary">
                      <?php echo $row['type_name'] ?? 'Chưa phân loại'; ?>
                    </span>
                  </td>
                  <td>
                    <?php if ($row['quantity'] <= 100): ?>
                      <span class="badge bg-danger"><?php echo $row['quantity']; ?></span>
                    <?php elseif ($row['quantity'] <= 500): ?>
                      <span class="badge bg-warning"><?php echo $row['quantity']; ?></span>
                    <?php else: ?>
                      <span class="badge bg-success"><?php echo $row['quantity']; ?></span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo number_format($row['price'], 0, ',', '.'); ?> đ</td>
                  <td><?php echo date('d/m/Y', strtotime($row['import_date'])); ?></td>
                  <td class="text-end px-4">
                    <a href="/medicines/edit.php?id=<?php echo $row['id']; ?>"
                      class="btn btn-sm btn-outline-primary me-2">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="/medicines/delete.php?id=<?php echo $row['id']; ?>"
                      class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Bạn có chắc chắn muốn xóa thuốc này không?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-4">
                  <div class="text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p class="mb-0">Không tìm thấy thuốc nào</p>
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