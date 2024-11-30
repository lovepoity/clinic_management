<?php
session_start();
include 'config/database.php';

if (isset($_SESSION['user_id'])) {
  header('Location: ./dashboard.php');
  exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($user = mysqli_fetch_assoc($result)) {
    if ($password === $user['password']) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['full_name'] = $user['full_name'];
      $_SESSION['role'] = $user['role'];

      header('Location: ./dashboard.php');
      exit();
    } else {
      $error = 'Sai mật khẩu';
    }
  } else {
    $error = 'Tài khoản không tồn tại';
  }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập - Hệ thống quản lý bệnh viện</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-4">
              <i class="fas fa-hospital text-primary" style="font-size: 3rem;"></i>
              <h4 class="mt-3 mb-4 fw-bold text-primary">Đăng nhập hệ thống</h4>
            </div>

            <?php if ($error): ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
              </div>
            <?php endif; ?>

            <form method="POST" class="needs-validation" novalidate>
              <div class="mb-3">
                <label class="form-label fw-bold">Tên đăng nhập</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-user text-primary"></i>
                  </span>
                  <input type="text" name="username" class="form-control" required>
                  <div class="invalid-feedback">
                    Vui lòng nhập tên đăng nhập
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Mật khẩu</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="fas fa-lock text-primary"></i>
                  </span>
                  <input type="password" name="password" class="form-control" required>
                  <div class="invalid-feedback">
                    Vui lòng nhập mật khẩu
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>

</html>