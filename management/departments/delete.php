<?php
include '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $check_query = "SELECT COUNT(*) as count FROM staff WHERE department_id = $id";
  $result = mysqli_query($conn, $check_query);
  $row = mysqli_fetch_assoc($result);

  if ($row['count'] > 0) {
    echo "<script>
            alert('Không thể xóa phòng ban này vì đang có nhân viên.');
            window.location.href = 'index.php';
          </script>";
    exit();
  }

  $query = "DELETE FROM departments WHERE id = $id";

  if (mysqli_query($conn, $query)) {
    header('Location: index.php');
    exit();
  } else {
    echo "Lỗi khi xóa: " . mysqli_error($conn);
  }
}
