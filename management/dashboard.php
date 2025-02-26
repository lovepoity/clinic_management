<?php
include './config/database.php';
include './includes/header.php';

$patients_query = "SELECT COUNT(*) as total FROM patients";
$patients_result = mysqli_query($conn, $patients_query);
$patients_count = mysqli_fetch_assoc($patients_result)['total'];

$staff_query = "SELECT COUNT(*) as total FROM staff";
$staff_result = mysqli_query($conn, $staff_query);
$staff_count = mysqli_fetch_assoc($staff_result)['total'];

$medicines_query = "SELECT COUNT(*) as total FROM medicines";
$medicines_result = mysqli_query($conn, $medicines_query);
$medicines_count = mysqli_fetch_assoc($medicines_result)['total'];

$prescriptions_query = "SELECT COUNT(*) as total FROM prescriptions";
$prescriptions_result = mysqli_query($conn, $prescriptions_query);
$prescriptions_count = mysqli_fetch_assoc($prescriptions_result)['total'];

$recent_prescriptions = mysqli_query($conn, "
    SELECT p.*, pt.full_name as patient_name, s.full_name as doctor_name 
    FROM prescriptions p
    JOIN patients pt ON p.patient_id = pt.id
    JOIN staff s ON p.staff_id = s.id
    ORDER BY p.prescription_date DESC LIMIT 5
");
?>

<div class="dashboard margin--top">
  <div class="row mb-4">
    <div class="col-12">
      <h1 class="dashboard__title text-primary fw-bold">
        <i class="fas fa-chart-line me-2"></i>Bảng điều khiển
      </h1>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card dashboard__card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="dashboard__card-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
              <i class="fas fa-user-injured fa-2x"></i>
            </div>
            <div>
              <h6 class="card-subtitle mb-1 text-muted">Tổng số bệnh nhân</h6>
              <h2 class="card-title mb-0 fw-bold"><?php echo $patients_count; ?></h2>
            </div>
          </div>
          <a href="/patients" class="stretched-link"></a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
      <div class="card dashboard__card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="dashboard__card-icon bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
              <i class="fas fa-user-md fa-2x"></i>
            </div>
            <div>
              <h6 class="card-subtitle mb-1 text-muted">Tổng số nhân viên</h6>
              <h2 class="card-title mb-0 fw-bold"><?php echo $staff_count; ?></h2>
            </div>
          </div>
          <a href="/staff" class="stretched-link"></a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
      <div class="card dashboard__card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="dashboard__card-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
              <i class="fas fa-pills fa-2x"></i>
            </div>
            <div>
              <h6 class="card-subtitle mb-1 text-muted">Tổng số thuốc</h6>
              <h2 class="card-title mb-0 fw-bold"><?php echo $medicines_count; ?></h2>
            </div>
          </div>
          <a href="/medicines" class="stretched-link"></a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
      <div class="card dashboard__card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="dashboard__card-icon bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
              <i class="fas fa-prescription fa-2x"></i>
            </div>
            <div>
              <h6 class="card-subtitle mb-1 text-muted">Tổng số đơn thuốc</h6>
              <h2 class="card-title mb-0 fw-bold"><?php echo $prescriptions_count; ?></h2>
            </div>
          </div>
          <a href="/prescriptions" class="stretched-link"></a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-clock me-2"></i>Đơn thuốc gần đây
          </h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Ngày</th>
                  <th>Bệnh nhân</th>
                  <th>Bác sĩ</th>
                  <th>Trạng thái</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($prescription = mysqli_fetch_assoc($recent_prescriptions)): ?>
                  <tr>
                    <td><?php echo date('d M Y', strtotime($prescription['prescription_date'])); ?></td>
                    <td><?php echo $prescription['patient_name']; ?></td>
                    <td><?php echo $prescription['doctor_name']; ?></td>
                    <td>
                      <span class="badge bg-success">Đã hoàn thành</span>
                    </td>
                    <td>
                      <a href="/management/prescriptions/view.php?id=<?php echo $prescription['id']; ?>"
                        class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>