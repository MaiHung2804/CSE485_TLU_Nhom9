# BAO CAO PHAN TICH VA THIET KE

## 1. Thong tin chung

- Ten de tai: He thong dat san the thao trong khuon vien truong
- Chu de goi y cua giang vien: De tai 6 - Dat phong hoc nhom, phong may va san the thao
- Huong chon de trien khai: San the thao
- Cong nghe su dung: PHP, Laravel, Blade, Bootstrap, MySQL, phpMyAdmin
- Mo hinh kien truc: MVC
- Sinh vien thuc hien: `[Dien ho ten]`
- Ma sinh vien: `[Dien ma sinh vien]`
- Lop: `[Dien lop]`
- Giang vien huong dan: `[Dien ten giang vien]`

## 2. Boi canh bai toan

Trong khuon vien truong, nhu cau dat san bong da, bong chuyen, bong ro hoac cau long dien ra thuong xuyen. Neu khong co he thong quan ly tap trung thi viec dat san de bi trung lich, kho theo doi tinh trang san va kho tong hop thong ke muc do su dung. Vi vay can xay dung mot he thong dat san co kha nang quan ly danh muc san, lich mo, yeu cau dat san, quy trinh duyet va bao cao su dung.

## 3. Muc tieu

- So hoa quy trinh dat san the thao trong truong
- Tranh trung lich dat san
- Theo doi duoc san nao dang mo, san nao dang bao tri
- Phan quyen ro rang giua quan tri vien va sinh vien
- Co du lieu mau va bao cao de phuc vu demo, van dap va nghiem thu

## 4. Pham vi vong 1

He thong hien tai trien khai 8 bang nghiep vu:

- `users`
- `sport_types`
- `courts`
- `time_slots`
- `court_schedules`
- `bookings`
- `booking_details`
- `usage_logs`

## 5. Tac nhan va phan quyen

### 5.1. Quan tri vien

- Dang nhap vao he thong
- Quan ly mon the thao
- Quan ly san
- Quan ly ca gio
- Quan ly lich mo cua san
- Xem toan bo phieu dat
- Duyet hoac tu choi phieu dat
- Cap nhat nhat ky su dung
- Xem bao cao thong ke

### 5.2. Sinh vien

- Dang nhap vao he thong
- Tao phieu dat san
- Xem phieu dat cua chinh minh
- Sua phieu dat cua chinh minh khi chua hoan tat hoac chua huy
- Huy phieu dat cua chinh minh

## 6. Workflow nghiep vu chinh

### 6.1. Khai bao danh muc san

Quan tri vien tao mon the thao, tao tung san, khai bao suc chua, vi tri, ma san va trang thai san.

### 6.2. Khai bao lich mo

Quan tri vien gan lich mo cho tung san theo thu trong tuan va ca gio. Moi cap `san - thu - ca gio` chi ton tai toi da mot ban ghi.

### 6.3. Gui yeu cau dat san

Sinh vien chon san, ngay dat, ca gio, muc dich su dung, so nguoi tham gia va so dien thoai lien he. He thong tao phieu dat o trang thai `pending`.

### 6.4. Kiem tra rang buoc

He thong tu dong kiem tra:

- San phai o trang thai `active`
- So nguoi choi khong vuot qua suc chua
- San phai mo o dung ngay va ca gio duoc chon
- Khong ton tai booking `pending` hoac `approved` trung san, ngay va ca gio

### 6.5. Duyet hoac tu choi

Quan tri vien xem danh sach phieu dat va thuc hien:

- Duyet phieu dat
- Tu choi phieu dat va ghi ly do
- Theo doi lich su trang thai

### 6.6. Ghi nhan su dung

Sau khi den lich, quan tri vien cap nhat nhat ky su dung:

- `used`
- `no_show`
- `cancelled`

Neu cap nhat nhat ky thi he thong dong bo trang thai booking phu hop.

### 6.7. Bao cao

Quan tri vien loc theo khoang ngay de xem:

- Tong booking
- So booking theo trang thai
- Top san duoc dat nhieu
- Top sinh vien dat san nhieu
- Xu huong booking theo ngay
- Nhat ky su dung gan nhat

## 7. Quy tac nghiep vu

- Mot san khong duoc co hai booking giao nhau trong cung ngay va cung ca gio
- San dang bao tri thi khong duoc dat
- Sinh vien chi thao tac duoc tren phieu dat cua chinh minh
- Quan tri vien co the quan ly toan bo du lieu
- Xoa hoac huy booking phai dung method POST/DELETE, khong dung GET
- Password luu duoi dang hash

## 8. Thiet ke CSDL

### 8.1. Nhom bang danh muc

- `sport_types`
- `courts`
- `time_slots`
- `court_schedules`

### 8.2. Nhom bang giao dich

- `bookings`
- `booking_details`

### 8.3. Nhom bang he thong va theo doi

- `users`
- `usage_logs`

## 9. Mo ta module

### 9.1. Module tai nguyen va lich

Quan ly mon the thao, san, ca gio va lich mo san.

### 9.2. Module dat san

Tao, xem, sua, huy va duyet phieu dat san.

### 9.3. Module nhat ky su dung

Cap nhat ket qua su dung sau buoi dat san.

### 9.4. Module bao cao

Tong hop thong ke khai thac san theo khoang thoi gian.

## 10. Kien truc MVC

- Model:
  - Quan ly du lieu va relationship giua cac bang
- View:
  - Giao dien Blade cho dashboard, form CRUD, booking, bao cao
- Controller:
  - Xu ly request, validation, nghiep vu va dieu huong

## 11. Tai khoan demo

- Quan tri vien:
  - `admin@campus.local / password`
- Sinh vien:
  - `student1@campus.local / password`
  - `student2@campus.local / password`

## 12. Cach cai dat va demo

1. Bat `Apache` va `MySQL` trong XAMPP
2. Tao file `.env` tu `.env.example`
3. Chay `php artisan key:generate`
4. Chay `php artisan migrate:fresh --seed`
5. Chay `php artisan serve`
6. Truy cap `http://127.0.0.1:8000`
7. Dang nhap bang tai khoan demo

## 13. Minh chung can chen them neu nop ban chinh thuc

- Anh dashboard sau khi dang nhap admin
- Anh dashboard cua sinh vien
- Anh form tao booking
- Anh bao cao thong ke
- Anh so do ERD xuat thanh PNG hoac PDF
- Bang phan cong neu giang vien yeu cau theo mau

## 14. Huong mo rong sau vong 1

- Gioi han so lan dat san theo tuan
- Them lich bao tri san chi tiet
- Them thong bao email hoac toast khi booking duoc duyet
- Them xuat bao cao PDF/Excel
- Them lich su thao tac va audit log
