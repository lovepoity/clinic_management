<?php
include '../config/database.php';

<<<<<<< HEAD
=======

>>>>>>> 0695859d63a820c859be24892da491c533d353aa
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  mysqli_begin_transaction($conn);

  try {
<<<<<<< HEAD
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
=======
    $query = "SELECT medicine_id, quantity FROM prescriptions WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $prescription = mysqli_fetch_assoc($result);
    $update_medicine = "UPDATE medicines 
                          SET quantity = quantity + {$prescription['quantity']} 
                          WHERE id = {$prescription['medicine_id']}";
    mysqli_query($conn, $update_medicine);

    $delete_query = "DELETE FROM prescriptions WHERE id = $id";
    mysqli_query($conn, $delete_query);

    mysqli_commit($conn);
    header('Location: index.php');
    exit();
  } catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error deleting record: " . $e->getMessage();
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
  }
}
