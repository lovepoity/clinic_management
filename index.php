<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phòng khám Đa khoa Quốc tế Sunao</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="/css/favicon.ico">
  <style>
    * {
      scrollbar-width: none !important;
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Roboto', sans-serif;
    }

    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80');
      background-size: cover;
      background-position: center;
      min-height: 100vh;
      position: relative;
    }

    .hero__content {
      padding-top: 150px;
    }

    .feature-icon {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      transition: transform 0.3s ease;
    }

    .feature-icon:hover {
      transform: scale(1.1);
    }

    .doctor-card {
      transition: transform 0.3s ease;
    }

    .doctor-card img {
      height: 350px;
      object-fit: cover;
    }

    .navbar {
      background-color: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
      padding: 1rem 0;
    }

    .stats-box {
      padding: 2rem;
      text-align: center;
      border-radius: 10px;
      background: white;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .department-card {
      border: none;
      transition: transform 0.3s ease;
    }


    .news-card {
      transition: transform 0.3s ease;
    }

    .contact-info {
      background: linear-gradient(135deg, #0061f2 0%, #00a6e8 100%);
      color: white;
      border-radius: 10px;
      padding: 2rem;
    }

    .emergency-banner {
      background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
      color: white;
      padding: 1rem 0;
    }

    .section-title {
      position: relative;
      padding-bottom: 20px;
      margin-bottom: 40px;
    }

    .section-title:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background: #0061f2;
    }

    .appointment-card {
      background: linear-gradient(135deg, #0061f2 0%, #00a6e8 100%);
      color: white;
      border-radius: 15px;
      padding: 2rem;
    }

    .social-links a {
      width: 40px;
      height: 40px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      transition: background 0.3s ease;
    }

    .social-links a:hover {
      background: rgba(255, 255, 255, 0.2);
    }
  </style>
</head>

<body>
  <!-- Emergency Banner -->
  <div class="emergency-banner">
    <div class="container text-center">
      <i class="fas fa-phone-alt me-2"></i>Đường dây nóng cấp cứu 24/7: <strong>115</strong> hoặc <strong>0123.456.789</strong>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="fas fa-hospital-alt text-primary me-2"></i>
        <span class="fw-bold">SUNAO CLINIC</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#about">Giới thiệu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Dịch vụ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#departments">Chuyên khoa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#doctors">Đội ngũ bác sĩ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#news">Tin tức</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Liên hệ</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero d-flex align-items-center">
    <div class="container text-white hero__content">
      <div class="row">
        <div class="col-lg-8">
          <h1 class="display-3 fw-bold mb-4">Chăm sóc sức khỏe tận tâm</h1>
          <p class="lead mb-4">Với đội ngũ y bác sĩ giàu kinh nghiệm và hệ thống trang thiết bị hiện đại bậc nhất, chúng tôi cam kết mang đến dịch vụ y tế chất lượng cao nhất cho người bệnh.</p>
          <div class="d-flex gap-3">
            <a href="#appointment" class="btn btn-primary btn-lg">Đặt lịch khám</a>
            <a href="#services" class="btn btn-outline-light btn-lg">Tìm hiểu thêm</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-3">
          <div class="stats-box">
            <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
            <h2 class="fw-bold">200+</h2>
            <p class="text-muted mb-0">Bác sĩ chuyên khoa</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stats-box">
            <i class="fas fa-procedures fa-3x text-success mb-3"></i>
            <h2 class="fw-bold">50,000+</h2>
            <p class="text-muted mb-0">Bệnh nhân/năm</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stats-box">
            <i class="fas fa-hospital fa-3x text-info mb-3"></i>
            <h2 class="fw-bold">15+</h2>
            <p class="text-muted mb-0">Chuyên khoa</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stats-box">
            <i class="fas fa-award fa-3x text-warning mb-3"></i>
            <h2 class="fw-bold">20+</h2>
            <p class="text-muted mb-0">Năm kinh nghiệm</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center section-title">Về chúng tôi</h2>
      <div class="row align-items-center">
        <div class="col-lg-6">
          <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Hospital" class="img-fluid rounded-3 shadow">
        </div>
        <div class="col-lg-6">
          <h3 class="mb-4">Phòng khám Đa khoa Quốc tế Sunao</h3>
          <p class="lead">Với sứ mệnh chăm sóc sức khỏe toàn diện cho cộng đồng, chúng tôi không ngừng đầu tư và phát triển để trở thành bệnh viện đa khoa hàng đầu khu vực.</p>
          <div class="row g-4 mt-4">
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <i class="fas fa-check-circle text-primary me-3 fa-2x"></i>
                <div>
                  <h5 class="mb-1">Chất lượng hàng đầu</h5>
                  <p class="mb-0 text-muted">Đạt chuẩn JCI quốc tế</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <i class="fas fa-user-md text-primary me-3 fa-2x"></i>
                <div>
                  <h5 class="mb-1">Chuyên môn cao</h5>
                  <p class="mb-0 text-muted">Đội ngũ bác sĩ giỏi</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <i class="fas fa-microscope text-primary me-3 fa-2x"></i>
                <div>
                  <h5 class="mb-1">Trang thiết bị</h5>
                  <p class="mb-0 text-muted">Công nghệ hiện đại</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <i class="fas fa-heart text-primary me-3 fa-2x"></i>
                <div>
                  <h5 class="mb-1">Tận tâm</h5>
                  <p class="mb-0 text-muted">Chăm sóc chu đáo</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="py-5">
    <div class="container">
      <h2 class="text-center section-title">Dịch vụ nổi bật</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
              <div class="feature-icon bg-primary bg-opacity-10 mx-auto">
                <i class="fas fa-stethoscope text-primary fa-2x"></i>
              </div>
              <h4>Khám tổng quát</h4>
              <p class="text-muted">Gói khám sức khỏe toàn diện với các chuyên gia đầu ngành</p>
              <ul class="list-unstyled text-start">
                <li><i class="fas fa-check text-primary me-2"></i>Khám lâm sàng</li>
                <li><i class="fas fa-check text-primary me-2"></i>Xét nghiệm máu</li>
                <li><i class="fas fa-check text-primary me-2"></i>Chẩn đoán hình ảnh</li>
                <li><i class="fas fa-check text-primary me-2"></i>Tư vấn dinh dưỡng</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
              <div class="feature-icon bg-success bg-opacity-10 mx-auto">
                <i class="fas fa-procedures text-success fa-2x"></i>
              </div>
              <h4>Phẫu thuật</h4>
              <p class="text-muted">Dịch vụ phẫu thuật với công nghệ hiện đại</p>
              <ul class="list-unstyled text-start">
                <li><i class="fas fa-check text-success me-2"></i>Phẫu thuật nội soi</li>
                <li><i class="fas fa-check text-success me-2"></i>Phẫu thuật thẩm mỹ</li>
                <li><i class="fas fa-check text-success me-2"></i>Phẫu thuật tim mạch</li>
                <li><i class="fas fa-check text-success me-2"></i>Chăm sóc hậu phẫu</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
              <div class="feature-icon bg-info bg-opacity-10 mx-auto">
                <i class="fas fa-heartbeat text-info fa-2x"></i>
              </div>
              <h4>Cấp cứu</h4>
              <p class="text-muted">Dịch vụ cấp cứu 24/7 với đội ngũ chuyên nghiệp</p>
              <ul class="list-unstyled text-start">
                <li><i class="fas fa-check text-info me-2"></i>Cấp cứu 24/7</li>
                <li><i class="fas fa-check text-info me-2"></i>Xe cứu thương</li>
                <li><i class="fas fa-check text-info me-2"></i>Đội ngũ trực chuyên môn cao</li>
                <li><i class="fas fa-check text-info me-2"></i>Thiết bị hiện đại</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Appointment Section -->
  <section id="appointment" class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="appointment-card">
            <h2 class="mb-4">Đặt lịch khám</h2>
            <form>
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="Họ và tên">
              </div>
              <div class="mb-3">
                <input type="tel" class="form-control" placeholder="Số điện thoại">
              </div>
              <div class="mb-3">
                <select class="form-select">
                  <option selected>Chọn chuyên khoa</option>
                  <option>Tim mạch</option>
                  <option>Nội tiết</option>
                  <option>Thần kinh</option>
                </select>
              </div>
              <div class="mb-3">
                <input type="date" class="form-control">
              </div>
              <div class="mb-3">
                <textarea class="form-control" rows="3" placeholder="Triệu chứng"></textarea>
              </div>
              <button type="submit" class="btn btn-light">Đặt lịch ngay</button>
            </form>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-info h-100">
            <h2 class="mb-4">Thông tin liên hệ</h2>
            <ul class="list-unstyled">
              <li class="mb-3">
                <i class="fas fa-map-marker-alt me-2"></i>
                123 Nguyễn Văn Linh, Tân Hiệp, Biên Hòa, Đồng Nai
              </li>
              <li class="mb-3">
                <i class="fas fa-phone me-2"></i>
                0123.456.789
              </li>
              <li class="mb-3">
                <i class="fas fa-envelope me-2"></i>
                clinic@sunao.com
              </li>
            </ul>
            <div class="mt-4">
              <h5 class="mb-3">Giờ làm việc</h5>
              <p class="mb-2">Thứ 2 - Thứ 6: 7:00 - 20:00</p>
              <p class="mb-2">Thứ 7: 7:00 - 18:00</p>
              <p class="mb-0">Chủ nhật: 7:00 - 16:00</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <h5 class="mb-4">Về chúng tôi</h5>
          <p>Phòng khám Đa khoa Quốc tế Sunao - Nơi chăm sóc sức khỏe đáng tin cậy cho mọi gia đình</p>
          <div class="social-links mt-4">
            <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
        <div class="col-lg-4">
          <h5 class="mb-4">Liên kết nhanh</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#about" class="text-white text-decoration-none">Về chúng tôi</a></li>
            <li class="mb-2"><a href="#services" class="text-white text-decoration-none">Dịch vụ</a></li>
            <li class="mb-2"><a href="#doctors" class="text-white text-decoration-none">Đội ngũ bác sĩ</a></li>
            <li class="mb-2"><a href="#news" class="text-white text-decoration-none">Tin tức</a></li>
          </ul>
        </div>
        <div class="col-lg-4">
          <h5 class="mb-4">Đăng ký nhận tin</h5>
          <p>Đăng ký để nhận những thông tin mới nhất về sức khỏe</p>
          <form class="mt-4">
            <div class="input-group">
              <input type="email" class="form-control" placeholder="Email của bạn">
              <button class="btn btn-primary" type="submit">Đăng ký</button>
            </div>
          </form>
        </div>
      </div>
      <hr class="my-4">
      <div class="text-center">
        <small>&copy; 2024 Bệnh viện Đa khoa Quốc tế Sunao. All rights reserved.</small>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>