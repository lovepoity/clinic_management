<?php
include '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

<<<<<<< HEAD
  $check_prescription = "SELECT COUNT(*) as count 
                       FROM prescription_details 
                       WHERE medicine_id = $id";

  $check_batches = "SELECT COUNT(*) as count 
                  FROM medicine_batches 
                  WHERE medicine_id = $id";

  $result_prescription = mysqli_query($conn, $check_prescription);
  $result_batches = mysqli_query($conn, $check_batches);

  $prescription_count = mysqli_fetch_assoc($result_prescription)['count'];
  $batches_count = mysqli_fetch_assoc($result_batches)['count'];

  if ($prescription_count > 0 || $batches_count > 0) {
    header('Location: index.php');
    exit();
  } else {
    $delete_query = "DELETE FROM medicines WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
      header('Location: index.php');
      exit();
    } else {
      header('Location: index.php');
      exit();
    }
=======
  $check_query = "SELECT COUNT(*) as count FROM prescriptions WHERE medicine_id = $id";
  $result = mysqli_query($conn, $check_query);
  $row = mysqli_fetch_assoc($result);

  if ($row['count'] > 0) {
    echo "<script>
            alert('Error: This medicine is in use in prescriptions. Cannot delete.');
            window.location.href = 'index.php';
          </script>";
    exit();
  }

  $query = "DELETE FROM medicines WHERE id = $id";

  if (mysqli_query($conn, $query)) {
    header('Location: index.php');
    exit();
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
  }
}
