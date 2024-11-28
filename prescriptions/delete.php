<?php
include '../config/database.php';


if (isset($_GET['id'])) {
  $id = $_GET['id'];

  mysqli_begin_transaction($conn);

  try {
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
  }
}
