<?php
include '../config/database.php';
include '../includes/header.php';
include '../includes/check_admin.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = '';
if (!empty($search)) {
  $where = "WHERE s.full_name LIKE '%$search%' 
              OR s.position LIKE '%$search%' 
              OR d.name LIKE '%$search%'";
}

$query = "SELECT s.*, d.name as department_name 
          FROM staff s
          LEFT JOIN departments d ON s.department_id = d.id
          $where 
          ORDER BY s.id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="staff margin--top">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold text-primary">
      <i class="fas fa-user-md me-2"></i>Quản lý nhân viên
    </h2>
    <a href="/management/staff/create.php" class="btn btn-primary">
      <i class="fas fa-plus me-2"></i>Thêm nhân viên
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
              placeholder="Tìm theo tên, chức vụ hoặc phòng ban"
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
              <th>Họ và tên</th>
              <th>Chức vụ</th>
              <th>Phòng ban</th>
              <th>Giới tính</th>
              <th>Năm sinh</th>
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
                      <div class="avatar-sm bg-success bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-user-md text-success"></i>
                      </div>
                      <?php echo $row['full_name']; ?>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-primary">
                      <?php echo $row['position']; ?>
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-info">
                      <?php echo $row['department_name'] ?? 'Chưa phân công'; ?>
                    </span>
                  </td>
                  <td><?php echo $row['gender']; ?></td>
                  <td><?php echo $row['birth_year']; ?></td>
                  <td class="text-end px-4">
                    <a href="/management/staff/edit.php?id=<?php echo $row['id']; ?>"
                      class="btn btn-sm btn-outline-primary me-2">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="/management/staff/delete.php?id=<?php echo $row['id']; ?>"
                      class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này không?')">
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
                    <p class="mb-0">Không tìm thấy nhân viên nào</p>
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