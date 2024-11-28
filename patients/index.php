<?php
include '../config/database.php';
include '../includes/header.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = '';
if (!empty($search)) {
  $where = "WHERE full_name LIKE '%$search%' OR DATE_FORMAT(birth_date, '%d/%m/%Y') LIKE '%$search%' OR phone LIKE '%$search%'";
}

$query = "SELECT *, DATE_FORMAT(birth_date, '%d/%m/%Y') as formatted_birth_date FROM patients $where ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="patients margin--top">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold text-primary">
      <i class="fas fa-user-injured me-2"></i>Quản lý bệnh nhân
    </h2>
    <a href="/patients/create.php" class="btn btn-primary">
      <i class="fas fa-plus me-2"></i>Thêm bệnh nhân
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
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, ngày sinh hoặc số điện thoại" value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <?php if (!empty($search)): ?>
              <a href="/patients/index.php" class="btn btn-outline-secondary">Xóa</a>
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
              <th>Tên</th>
              <th>Giới tính</th>
              <th>Ngày sinh</th>
              <th>Số điện thoại</th>
              <th>Địa chỉ</th>
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
                      <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-user text-primary"></i>
                      </div>
                      <?php echo $row['full_name']; ?>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-<?php echo $row['gender'] == 'Male' ? 'info' : 'warning'; ?>">
                      <?php echo $row['gender']; ?>
                    </span>
                  </td>
                  <td><?php echo $row['formatted_birth_date']; ?></td>
                  <td><?php echo $row['phone']; ?></td>
                  <td><?php echo $row['address']; ?></td>
                  <td class="text-end px-4">
                    <a href="/patients/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="/patients/delete.php?id=<?php echo $row['id']; ?>"
                      class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Bạn có chắc chắn muốn xóa bệnh nhân này không?')">
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
                    <p class="mb-0">Không tìm thấy bệnh nhân nào</p>
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