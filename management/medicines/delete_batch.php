<?php
include '../config/database.php';

if (isset($_GET['id'])) {
  $batch_id = $_GET['id'];

  $check_query = "SELECT COUNT(*) as count 
                    FROM prescription_details 
                    WHERE batch_id = ?";

  $stmt = mysqli_prepare($conn, $check_query);
  mysqli_stmt_bind_param($stmt, "i", $batch_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $count = mysqli_fetch_assoc($result)['count'];

  if ($count > 0) {
    http_response_code(400);
    echo "Không thể xóa lô thuốc này vì đang được sử dụng trong đơn thuốc!";
  } else {
    $delete_query = "DELETE FROM medicine_batches WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $batch_id);

    if (mysqli_stmt_execute($stmt)) {
      http_response_code(200);
      echo "Xóa lô thuốc thành công";
    } else {
      http_response_code(500);
      echo "Lỗi: " . mysqli_error($conn);
    }
  }
}
