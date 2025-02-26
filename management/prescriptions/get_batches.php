<?php
include '../config/database.php';

$medicine_id = $_GET['medicine_id'];

$query = "SELECT b.*, 
          (b.quantity - COALESCE(SUM(pd.quantity), 0)) as remaining
          FROM medicine_batches b
          LEFT JOIN prescription_details pd ON b.id = pd.batch_id
          WHERE b.medicine_id = $medicine_id
          GROUP BY b.id
          HAVING remaining > 0
          ORDER BY b.import_date ASC";

$result = mysqli_query($conn, $query);
$batches = mysqli_fetch_all($result, MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($batches);
