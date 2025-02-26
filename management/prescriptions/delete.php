<?php
include '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  mysqli_begin_transaction($conn);

  try {
    $delete_details = "DELETE FROM prescription_details WHERE prescription_id = ?";
    $stmt = mysqli_prepare($conn, $delete_details);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $delete_prescription = "DELETE FROM prescriptions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_prescription);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_commit($conn);

    http_response_code(200);
    echo "Xóa đơn thuốc thành công";
  } catch (Exception $e) {
    mysqli_rollback($conn);
    http_response_code(500);
    echo "Lỗi: " . $e->getMessage();
  }
}
