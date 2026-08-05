# Checklist nop bai

## 1. Tai lieu

- [ ] Co `README.md` huong dan cai dat va chay
- [ ] Co file bao cao Word `docs/bao-cao-vong-1.docx`
- [ ] Co ERD dang anh hoac file nguon Mermaid
- [ ] Co data dictionary
- [ ] Da dien thong tin sinh vien, ma sinh vien, lop, giang vien

## 2. CSDL

- [ ] Chay duoc `php artisan migrate:fresh --seed`
- [ ] Co file SQL backup `database/cse485_sports_booking.sql`
- [ ] Du lieu mau hop ly, khong co orphan
- [ ] Quan he PK/FK dung nhu bao cao

## 3. Chuc nang

- [ ] CRUD mon the thao
- [ ] CRUD san
- [ ] CRUD ca gio
- [ ] CRUD lich mo san
- [ ] Tao booking
- [ ] Duyet va tu choi booking
- [ ] Huy booking
- [ ] Cap nhat nhat ky su dung
- [ ] Loc va xem bao cao

## 4. Bao mat va rang buoc

- [ ] Form co CSRF
- [ ] Delete khong dung GET
- [ ] Password duoc hash
- [ ] Sinh vien khong vao duoc route admin
- [ ] Sinh vien khong xem sua duoc booking cua nguoi khac
- [ ] Khong dat duoc san bao tri
- [ ] Khong dat duoc neu trung lich

## 5. Demo truoc khi nop

- [ ] Bat `Apache`
- [ ] Bat `MySQL`
- [ ] Chay `php artisan serve`
- [ ] Dang nhap bang `admin@campus.local`
- [ ] Dang nhap bang `student1@campus.local`
- [ ] Demo ca `allow` va `deny`
- [ ] Demo bao cao thong ke

## 6. Git

- [ ] Da commit theo tung moc ro rang
- [ ] Co it nhat 4-6 commit co y nghia
- [ ] Commit cuoi cung chua trang thai on dinh de demo

## 7. Van dap

- [ ] Giai thich duoc route -> controller -> model -> view
- [ ] Giai thich duoc quan he giua 8 bang
- [ ] Giai thich duoc ly do tach `bookings` va `booking_details`
- [ ] Giai thich duoc vi sao can `usage_logs`
- [ ] Giai thich duoc middleware va policy dang dung
