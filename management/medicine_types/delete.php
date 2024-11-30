<?php
include '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $check_query = "SELECT COUNT(*) as count FROM medicines WHERE type_id = $id";
  $result = mysqli_query($conn, $check_query);
  $row = mysqli_fetch_assoc($result);

  if ($row['count'] > 0) {
    echo "<script>
            alert('Không thể xóa loại thuốc này vì đang được sử dụng trong danh sách thuốc.');
            window.location.href = 'index.php';
          </script>";
    exit();
  }

  $query = "DELETE FROM medicine_types WHERE id = $id";

  if (mysqli_query($conn, $query)) {
    header('Location: index.php');
    exit();
  } else {
    echo "Lỗi khi xóa: " . mysqli_error($conn);
  }
}
