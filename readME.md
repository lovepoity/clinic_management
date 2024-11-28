# Hospital Management System

Hệ thống quản lý bệnh viện với các chức năng quản lý bệnh nhân, nhân viên, thuốc và đơn thuốc.

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
