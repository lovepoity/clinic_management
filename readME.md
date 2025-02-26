<<<<<<< HEAD
Mô tả chi tiết dự án
Clinic Management System (CMS) là một hệ thống quản lý dành cho phòng khám, giúp tối ưu hóa các quy trình từ quản lý bệnh nhân, nhân viên, kho thuốc đến xử lý đơn thuốc. Hệ thống này không chỉ cung cấp giao diện quản lý dễ sử dụng mà còn tích hợp các API giúp các hệ thống bên thứ ba có thể mở rộng và tích hợp.

Mục tiêu của dự án
Tăng cường hiệu quả làm việc:

Giảm thời gian thao tác thủ công.
Tăng khả năng xử lý dữ liệu nhanh chóng, chính xác.
Cải thiện chất lượng dịch vụ y tế:

Cung cấp thông tin bệnh nhân và lịch sử điều trị một cách chi tiết.
Hỗ trợ nhân viên y tế trong việc kê đơn thuốc chính xác.
Quản lý tập trung:

Đồng bộ hóa dữ liệu bệnh nhân, nhân viên và thuốc.
Phân quyền rõ ràng, bảo mật thông tin.
Các tính năng nâng cao
Theo dõi lịch sử điều trị:

Hiển thị toàn bộ quá trình điều trị, bao gồm đơn thuốc và các chẩn đoán.
Báo cáo & Thống kê:

Báo cáo số lượng bệnh nhân, nhân viên, thuốc đã sử dụng trong khoảng thời gian cụ thể.
Thống kê doanh thu từ việc khám chữa bệnh.
Quản lý lịch làm việc của nhân viên:

Lập lịch trực cho nhân viên y tế.
Gửi thông báo lịch làm việc qua email.
Nhắc nhở tái khám:

Gửi thông báo tự động qua SMS/Email cho bệnh nhân cần tái khám.
Kiến trúc hệ thống

1. Backend:
   Framework: Laravel hoặc Symfony để tăng cường bảo mật và dễ dàng mở rộng.
   Database:
   Sử dụng MySQL với các tối ưu về chỉ mục và quan hệ để đảm bảo hiệu năng khi dữ liệu tăng trưởng.
   Kết hợp Redis để cache dữ liệu truy vấn thường xuyên.
2. Frontend:
   Framework: React hoặc Vue.js để tạo giao diện người dùng tương tác, hiện đại.
   UI/UX: Sử dụng thư viện Bootstrap hoặc Tailwind CSS.
3. API:
   Chuẩn RESTful:
   API được xây dựng theo chuẩn RESTful, dễ dàng tích hợp.
   Bảo mật API bằng OAuth 2.0 hoặc JWT.
   Định dạng trả về: JSON.
4. Hạ tầng:
   Docker: Container hóa để triển khai dễ dàng trên các môi trường khác nhau.
   CI/CD: Tích hợp Jenkins hoặc GitHub Actions để tự động hóa việc triển khai và kiểm tra.
   Tài liệu kỹ thuật (Technical Documentation)
5. Quản lý phân quyền:
   Admin:
   Toàn quyền quản lý tất cả các chức năng.
   Có quyền tạo, sửa, xóa người dùng.
   Staff:
   Chỉ được quản lý bệnh nhân, kê đơn thuốc.
   Không có quyền truy cập vào phần cấu hình hệ thống.
6. Các bảng bổ sung:
   appointments: Quản lý lịch hẹn bệnh nhân.
   logs: Lưu trữ log hệ thống để theo dõi các thay đổi.
   Lộ trình phát triển (Roadmap)
   Giai đoạn 1: MVP (Minimum Viable Product)
   Hoàn thành các tính năng cơ bản như quản lý bệnh nhân, nhân viên, thuốc và kê đơn thuốc.
   Giai đoạn 2: Tính năng nâng cao
   Thêm module báo cáo, thống kê và lịch làm việc.
   Giai đoạn 3: Triển khai & bảo trì
   Đưa hệ thống vào hoạt động chính thức.
   Cập nhật và sửa lỗi định kỳ.

=======
>>>>>>> 0695859d63a820c859be24892da491c533d353aa
# Clinic Management System

Hệ thống quản lý phòng khám với các chức năng quản lý bệnh nhân, nhân viên, thuốc và đơn thuốc.

## Tính năng chính

- Quản lý thông tin bệnh nhân
- Quản lý nhân viên và phòng ban
- Quản lý kho thuốc và loại thuốc
- Kê đơn thuốc và theo dõi điều trị
- Phân quyền người dùng (Admin/Staff)

## Cấu trúc Database

### Bảng chính:

- **departments**: Quản lý thông tin các khoa
- **staff**: Thông tin nhân viên y tế
- **patients**: Thông tin bệnh nhân
- **medicines**: Danh mục thuốc
- **medicine_types**: Phân loại thuốc
- **prescriptions**: Đơn thuốc
- **users**: Tài khoản người dùng

### Quan hệ:

- Nhân viên thuộc về một khoa (staff -> departments)
- Thuốc thuộc về một loại thuốc (medicines -> medicine_types)
- Đơn thuốc liên kết với bệnh nhân, nhân viên và thuốc

## Công nghệ sử dụng

- MySQL 8.0+
- PHP 8.2
- Apache/Nginx

## Cài đặt

1. Import file SQL vào MySQL/MariaDB
2. Cấu hình kết nối database trong file config
3. Tài khoản mặc định:
   - Admin: username: admin / password: 123
   - Staff: username: staff / password: 123

## API Documentation

### Patients API

`GET /api/patients`

- Lấy danh sách bệnh nhân

`POST /api/patients`

- Thêm bệnh nhân mới

### Prescriptions API

`GET /api/prescriptions`

- Lấy danh sách đơn thuốc

`POST /api/prescriptions`

- Tạo đơn thuốc mới

## License

[MIT](https://choosealicense.com/licenses/mit/)
