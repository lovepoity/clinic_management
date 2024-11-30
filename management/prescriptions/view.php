<?php
include '../config/database.php';
include '../includes/header.php';

$id = $_GET['id'];
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
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>