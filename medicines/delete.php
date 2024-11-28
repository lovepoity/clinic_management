<?php
include '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

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
  }
}
