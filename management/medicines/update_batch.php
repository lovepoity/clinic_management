<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $batch_id = $_POST['batch_id'];
  $medicine_id = $_POST['medicine_id'];
  $batch_number = $_POST['batch_number'];
  $quantity = $_POST['quantity'];
  $import_date = $_POST['import_date'];
  $expiry_date = $_POST['expiry_date'];

  $check_query = "SELECT COUNT(*) as count FROM medicine_batches 
                 WHERE batch_number = ? AND id != ?";
  $stmt = mysqli_prepare($conn, $check_query);
  mysqli_stmt_bind_param($stmt, "si", $batch_number, $batch_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $count = mysqli_fetch_assoc($result)['count'];

  if ($count > 0) {
    http_response_code(400);
    echo "Mã lô này đã tồn tại";
    exit;
  }

  $query = "UPDATE medicine_batches SET 
            batch_number = ?,
            quantity = ?,
            import_date = ?,
            expiry_date = ?
            WHERE id = ? AND medicine_id = ?";

  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sissii", $batch_number, $quantity, $import_date, $expiry_date, $batch_id, $medicine_id);

  if (mysqli_stmt_execute($stmt)) {
    http_response_code(200);
    echo "Cập nhật lô thuốc thành công";
  } else {
    http_response_code(500);
    echo "Lỗi: " . mysqli_error($conn);
  }
}
