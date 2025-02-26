<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $medicine_id = $_POST['medicine_id'];
  $batch_number = $_POST['batch_number'];
  $quantity = $_POST['quantity'];
  $import_date = $_POST['import_date'];
  $expiry_date = $_POST['expiry_date'];

  $check_query = "SELECT COUNT(*) as count FROM medicine_batches WHERE batch_number = '$batch_number'";
  $check_result = mysqli_query($conn, $check_query);
  $count = mysqli_fetch_assoc($check_result)['count'];

  if ($count > 0) {
    http_response_code(400);
    echo "Mã lô này đã tồn tại";
    exit;
  }

  $query = "INSERT INTO medicine_batches (medicine_id, batch_number, quantity, import_date, expiry_date) 
            VALUES (?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "isiss", $medicine_id, $batch_number, $quantity, $import_date, $expiry_date);

  if (mysqli_stmt_execute($stmt)) {
    http_response_code(200);
    echo "Thêm lô thuốc thành công";
  } else {
    http_response_code(500);
    echo "Lỗi: " . mysqli_error($conn);
  }
}
