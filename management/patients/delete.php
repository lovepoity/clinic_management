<?php
include '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $check_query = "SELECT COUNT(*) as count FROM prescriptions WHERE patient_id = $id";
  $result = mysqli_query($conn, $check_query);
  $row = mysqli_fetch_assoc($result);

  if ($row['count'] > 0) {
    echo "Cannot delete this patient as they have prescriptions in the system.";
    echo "<br><a href='index.php'>Back to List</a>";
    exit();
  }

  $query = "DELETE FROM patients WHERE id = $id";

  if (mysqli_query($conn, $query)) {
    header('Location: index.php');
    exit();
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }
}
