<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: /login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hệ thống quản lý phòng khám</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="/management/css/style.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../css/favicon.ico">
</head>

<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="/management/dashboard.php">
        <i class="fas fa-hospital me-2"></i>Quản lý phòng khám
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/management/dashboard.php">
              <i class="fas fa-home me-2"></i>Trang chủ
            </a>
          </li>

          <?php if ($_SESSION['role'] === 'admin'): ?>
            <!-- Menu chỉ dành cho admin -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-cogs me-2"></i>Cài đặt hệ thống
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="/management/departments/index.php">
                    <i class="fas fa-building me-2"></i>Quản lý phòng ban
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="/management/staff/index.php">
                    <i class="fas fa-user-md me-2"></i>Quản lý nhân viên
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>

          <!-- Menu chung cho cả admin và staff -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-pills me-2"></i>Quản lý thuốc
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="/management/medicine_types/index.php">
                  <i class="fas fa-tags me-2"></i>Danh mục loại thuốc
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/management/medicines/index.php">
                  <i class="fas fa-pills me-2"></i>Danh sách thuốc
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-clipboard-list me-2"></i>Quản lý nghiệp vụ
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="/management/patients/index.php">
                  <i class="fas fa-user-injured me-2"></i>Quản lý bệnh nhân
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/management/prescriptions/index.php">
                  <i class="fas fa-file-prescription me-2"></i>Quản lý đơn thuốc
                </a>
              </li>
            </ul>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle me-2"></i><?php echo $_SESSION['full_name']; ?>
              <span class="badge bg-<?php echo $_SESSION['role'] === 'admin' ? 'danger' : 'info'; ?> ms-2">
                <?php echo $_SESSION['role']; ?>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="/management/logout.php">
                  <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="content-wrapper">
    <div class="container-fluid p-4">