<?php
include '../config/database.php';
include '../includes/header.php';

$id = $_GET['id'];
<<<<<<< HEAD

function formatDate($date)
{
  if (!$date) return 'N/A';
  return date('d/m/Y', strtotime($date) ?: time());
}

$query = "SELECT p.*, 
          pt.full_name as patient_name,
          pt.birth_date as date_of_birth,
          pt.address,
          pt.phone,
          COALESCE(s.full_name, 'N/A') as staff_name
          FROM prescriptions p
          LEFT JOIN patients pt ON p.patient_id = pt.id 
          LEFT JOIN staff s ON p.staff_id = s.id
          WHERE p.id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$prescription = mysqli_stmt_get_result($stmt)->fetch_assoc();

$details_query = "SELECT pd.*, 
                 m.name as medicine_name,
                 m.price,
                 mt.name as type_name
                 FROM prescription_details pd
                 LEFT JOIN medicines m ON pd.medicine_id = m.id
                 LEFT JOIN medicine_types mt ON m.type_id = mt.id
                 WHERE pd.prescription_id = $id";

$medicines_result = mysqli_query($conn, $details_query);
?>

<div class="container-fluid margin--top">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold text-primary">
          <i class="fas fa-prescription me-2"></i>Chi tiết đơn thuốc #<?php echo $id; ?>
        </h2>
        <div>
          <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Sửa đơn thuốc
          </a>
          <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
          </a>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title mb-0">
                <i class="fas fa-user me-2"></i>Thông tin bệnh nhân
              </h5>
            </div>
            <div class="card-body">
              <div class="patient-info">
                <h5>Thông tin bệnh nhân</h5>
                <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($prescription['patient_name']); ?></p>
                <p><strong>Ngày sinh:</strong> <?php echo formatDate($prescription['date_of_birth']); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($prescription['address']); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($prescription['phone']); ?></p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title mb-0">
                <i class="fas fa-user-md me-2"></i>Thông tin bác sĩ
              </h5>
            </div>
            <div class="card-body">
              <div class="doctor-info">
                <h5>Thông tin bác sĩ</h5>
                <p><strong>Bác sĩ:</strong> <?php echo htmlspecialchars($prescription['staff_name']); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-bold text-primary">
              <i class="fas fa-prescription me-2"></i>Chi tiết đơn thuốc
            </h5>
            <div>
              <button onclick="window.print()" class="btn btn-outline-primary">
                <i class="fas fa-print me-2"></i>In đơn thuốc
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <!-- Thông tin chung -->
          <div class="row mb-4">
            <div class="col-md-6">
              <h6 class="fw-bold mb-3">Thông tin bệnh nhân:</h6>
              <p class="mb-1"><strong>Họ tên:</strong> <?php echo htmlspecialchars($prescription['patient_name']); ?></p>
              <p class="mb-1"><strong>Ngày sinh:</strong> <?php echo formatDate($prescription['date_of_birth']); ?></p>
              <p class="mb-1"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($prescription['address']); ?></p>
              <p class="mb-1"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($prescription['phone']); ?></p>
            </div>
            <div class="col-md-6">
              <h6 class="fw-bold mb-3">Thông tin đơn thuốc:</h6>
              <p class="mb-1"><strong>Mã đơn:</strong> #<?php echo str_pad($id, 6, '0', STR_PAD_LEFT); ?></p>
              <p class="mb-1"><strong>Ngày kê đơn:</strong> <?php echo date('d/m/Y', strtotime($prescription['prescription_date'])); ?></p>
              <p class="mb-1"><strong>Bác sĩ kê đơn:</strong> <?php echo htmlspecialchars($prescription['staff_name']); ?></p>
            </div>
          </div>

          <div class="mb-4">
            <h6 class="fw-bold mb-3">Chẩn đoán:</h6>
            <p class="border rounded p-3 bg-light"><?php echo nl2br($prescription['diagnosis']); ?></p>
          </div>

          <h6 class="fw-bold mb-3">Chi tiết đơn thuốc:</h6>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>STT</th>
                  <th>Tên thuốc</th>
                  <th>Số lượng</th>
                  <th>Đơn giá</th>
                  <th>Thành tiền</th>
                  <th>Cách dùng</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total = 0;
                $stt = 1;
                while ($detail = mysqli_fetch_assoc($medicines_result)):
                  $amount = $detail['quantity'] * $detail['price'];
                  $total += $amount;
                ?>
                  <tr>
                    <td><?php echo $stt++; ?></td>
                    <td>
                      <?php echo $detail['medicine_name']; ?>
                      <br>
                      <small class="text-muted">(<?php echo $detail['type_name']; ?>)</small>
                    </td>
                    <td><?php echo $detail['quantity']; ?></td>
                    <td><?php echo number_format($detail['price'], 0, ',', '.'); ?> đ</td>
                    <td><?php echo number_format($amount, 0, ',', '.'); ?> đ</td>
                    <td><?php echo nl2br($detail['notes']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                  <td colspan="2" class="fw-bold text-primary"><?php echo number_format($total, 0, ',', '.'); ?> đ</td>
                </tr>
              </tfoot>
            </table>
          </div>

          <!-- Chữ ký -->
          <div class="row mt-5">
            <div class="col-md-6 text-center">
              <p class="mb-5">Người bệnh</p>
              <p><em>(Ký và ghi rõ họ tên)</em></p>
            </div>
            <div class="col-md-6 text-center">
              <p class="mb-5">Bác sĩ kê đơn</p>
              <p><em>(Ký và ghi rõ họ tên)</em></p>
              <p class="mt-4 fw-bold"><?php echo htmlspecialchars($prescription['staff_name']); ?></p>
            </div>
          </div>
        </div>
      </div>
=======
$query = "SELECT p.*, 
          pt.full_name as patient_name,
          pt.gender as patient_gender,
          pt.birth_date as patient_birth_date,
          pt.phone as patient_phone,
          pt.address as patient_address,
          s.full_name as staff_name,
          s.position as staff_position,
          m.name as medicine_name,
          m.price as medicine_price
          FROM prescriptions p
          LEFT JOIN patients pt ON p.patient_id = pt.id
          LEFT JOIN staff s ON p.staff_id = s.id
          LEFT JOIN medicines m ON p.medicine_id = m.id
          WHERE p.id = $id";

$result = mysqli_query($conn, $query);
$prescription = mysqli_fetch_assoc($result);
?>

<div style="padding: 0 300px;" class="prescription-detail margin--top">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="prescription-detail__title fw-bold text-primary">
      <i class="fas fa-file-prescription me-2"></i>Chi tiết đơn thuốc
    </h2>
    <div>
      <a href="/management/prescriptions/index.php" class="btn btn-light me-2">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
      </a>
      <a href="/management/prescriptions/edit.php?id=<?php echo $id; ?>" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Sửa
      </a>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
      <h5 class="card-title mb-0 fw-bold text-primary">Thông tin bệnh nhân</h5>
    </div>
    <div class="card-body">
      <p><strong>Tên:</strong> <?php echo $prescription['patient_name']; ?></p>
      <p><strong>Giới tính:</strong> <?php echo $prescription['patient_gender']; ?></p>
      <p><strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($prescription['patient_birth_date'])); ?></p>
      <p><strong>Số điện thoại:</strong> <?php echo $prescription['patient_phone']; ?></p>
      <p><strong>Địa chỉ:</strong> <?php echo $prescription['patient_address']; ?></p>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
      <h5 class="card-title mb-0 fw-bold text-primary">Thông tin đơn thuốc</h5>
    </div>
    <div class="card-body">
      <p><strong>Bác sĩ:</strong> <?php echo $prescription['staff_name']; ?> (<?php echo $prescription['staff_position']; ?>)</p>
      <p><strong>Thuốc:</strong> <?php echo $prescription['medicine_name']; ?></p>
      <p><strong>Số lượng:</strong> <?php echo $prescription['quantity']; ?></p>
      <p><strong>Tổng giá:</strong> <?php echo number_format($prescription['price'], 0, ',', '.'); ?> VNĐ</p>
      <p><strong>Ngày:</strong> <?php echo date('d/m/Y', strtotime($prescription['prescription_date'])); ?></p>
      <p><strong>Chẩn đoán:</strong> <?php echo $prescription['diagnosis']; ?></p>
      <p><strong>Ghi chú bác sĩ:</strong> <?php echo $prescription['doctor_notes']; ?></p>
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>