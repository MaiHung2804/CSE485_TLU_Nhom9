# Đặt Sân Thể Thao

Project Laravel MVC cho bài thi cuối kỳ cá nhân với chủ đề:

- quản lý sân thể thao
- quản lý lịch mở sân
- đặt sân và kiểm tra trùng lịch
- duyệt, từ chối, hủy phiếu đặt
- ghi nhận nhật ký sử dụng

Hiện tại project đã được cấu hình chạy với MySQL của XAMPP và xem dữ liệu bằng phpMyAdmin.

## Phạm vi vòng 1

- `users`
- `sport_types`
- `courts`
- `time_slots`
- `court_schedules`
- `bookings`
- `booking_details`
- `usage_logs`

## Chức năng chính

- quản lý môn thể thao, sân, ca giờ và lịch mở sân
- tạo phiếu đặt sân
- kiểm tra xung đột theo sân, ngày và ca giờ
- duyệt, từ chối hoặc hủy phiếu đặt
- cập nhật nhật ký sử dụng cho các phiếu đã duyệt
- đăng nhập, đăng xuất và phân quyền theo vai trò
- policy để sinh viên chỉ thao tác trên phiếu của chính mình
- báo cáo thống kê theo khoảng thời gian cho quản trị viên

## Cấu hình MySQL và phpMyAdmin

- MySQL sử dụng từ XAMPP
- phpMyAdmin: `http://localhost/phpmyadmin`
- Tên database: `cse485_sports_booking`
- Tài khoản MySQL mặc định:

```text
username: root
password: (để trống)
```

## Chạy project local

1. Mở XAMPP Control Panel.
2. Bật `Apache` và `MySQL`.
3. Mở thư mục project.
4. Nếu cần, tạo file môi trường:

```bash
copy .env.example .env
```

5. Tạo khóa ứng dụng:

```bash
php artisan key:generate
```

6. Tạo bảng và nạp dữ liệu mẫu vào MySQL:

```bash
php artisan migrate:fresh --seed
```

7. Chạy server Laravel:

```bash
php artisan serve
```

8. Mở trình duyệt:

```text
http://127.0.0.1:8000
```

9. Đăng nhập bằng một trong các tài khoản demo bên dưới.

## Tài khoản demo

Mật khẩu chung cho tất cả tài khoản:

```text
password
```

Danh sách:

- `admin@campus.local`
- `student1@campus.local`
- `student2@campus.local`

## Phân quyền hiện tại

- `Quản trị viên`
  - quản lý môn thể thao, sân, ca giờ, lịch mở
  - xem toàn bộ phiếu đặt
  - duyệt, từ chối, hủy booking
  - cập nhật nhật ký sử dụng
  - xem báo cáo thống kê
- `Sinh viên`
  - đăng nhập và xem dashboard cá nhân
  - tạo booking mới
  - chỉ xem, sửa, hủy phiếu đặt của chính mình

## Ghi chú

- Project đang dùng MySQL thật nên dữ liệu sẽ hiển thị trực tiếp trong phpMyAdmin.
- Các giá trị `SESSION_DRIVER`, `CACHE_STORE` và `QUEUE_CONNECTION` đã được giữ ở mức đơn giản để tiện demo.
- Giao diện và dữ liệu mẫu đã được Việt hóa để phù hợp bài nộp.
