# Data Dictionary

Tai lieu nay mo ta 8 bang nghiep vu dang duoc su dung trong project vong 1.

## 1. users

| Cot | Kieu du lieu | Rang buoc | Y nghia |
|---|---|---|---|
| id | bigint | PK, auto increment | Ma nguoi dung |
| name | varchar(255) | not null | Ho ten nguoi dung |
| email | varchar(255) | unique, not null | Email dang nhap |
| email_verified_at | timestamp | nullable | Moc xac minh email |
| password | varchar(255) | not null | Mat khau da hash |
| role | varchar(20) | default `student`, index | Vai tro `admin` hoac `student` |
| remember_token | varchar(100) | nullable | Token ghi nho dang nhap |
| created_at | timestamp | nullable | Thoi gian tao |
| updated_at | timestamp | nullable | Thoi gian cap nhat |

## 2. sport_types

| Cot | Kieu du lieu | Rang buoc | Y nghia |
|---|---|---|---|
| id | bigint | PK, auto increment | Ma mon the thao |
| name | varchar(255) | unique, not null | Ten mon the thao |
| description | text | nullable | Mo ta mon the thao |
| created_at | timestamp | nullable | Thoi gian tao |
| updated_at | timestamp | nullable | Thoi gian cap nhat |

## 3. courts

| Cot | Kieu du lieu | Rang buoc | Y nghia |
|---|---|---|---|
| id | bigint | PK, auto increment | Ma san |
| sport_type_id | bigint | FK -> sport_types.id, not null | Mon the thao cua san |
| name | varchar(255) | not null | Ten san |
| code | varchar(255) | unique, not null | Ma dinh danh san |
| location | varchar(255) | not null | Vi tri san trong khuon vien |
| capacity | unsigned int | not null | Suc chua toi da |
| status | varchar(20) | default `active`, index | Trang thai `active` hoac `maintenance` |
| description | text | nullable | Mo ta chi tiet ve san |
| created_at | timestamp | nullable | Thoi gian tao |
| updated_at | timestamp | nullable | Thoi gian cap nhat |

## 4. time_slots

| Cot | Kieu du lieu | Rang buoc | Y nghia |
|---|---|---|---|
| id | bigint | PK, auto increment | Ma ca gio |
| label | varchar(255) | unique, not null | Nhan hien thi cua ca gio |
| start_time | time | not null | Gio bat dau |
| end_time | time | not null | Gio ket thuc |
| created_at | timestamp | nullable | Thoi gian tao |
| updated_at | timestamp | nullable | Thoi gian cap nhat |

## 5. court_schedules

| Cot | Kieu du lieu | Rang buoc | Y nghia |
|---|---|---|---|
| id | bigint | PK, auto increment | Ma lich mo |
| court_id | bigint | FK -> courts.id, cascade delete | San duoc gan lich |
| day_of_week | tinyint unsigned | not null | Thu trong tuan, theo gia tri so |
| time_slot_id | bigint | FK -> time_slots.id | Ca gio duoc mo |
| is_open | boolean | default true | Co mo san o khung nay hay khong |
| created_at | timestamp | nullable | Thoi gian tao |
| updated_at | timestamp | nullable | Thoi gian cap nhat |

Rang buoc bo sung:

- unique (`court_id`, `day_of_week`, `time_slot_id`)

## 6. bookings

| Cot | Kieu du lieu | Rang buoc | Y nghia |
|---|---|---|---|
| id | bigint | PK, auto increment | Ma phieu dat |
| user_id | bigint | FK -> users.id, restrict delete | Nguoi tao booking |
| purpose | varchar(255) | not null | Muc dich dat san |
| player_count | unsigned int | not null | So nguoi tham gia |
| contact_phone | varchar(20) | not null | So dien thoai lien he |
| status | varchar(20) | default `pending`, index | Trang thai xu ly booking |
| approved_by | bigint | FK -> users.id, null on delete | Nguoi duyet hoac tu choi |
| approved_at | timestamp | nullable | Thoi diem duyet |
| rejection_reason | text | nullable | Ly do tu choi |
| cancel_reason | text | nullable | Ly do huy |
| cancelled_at | timestamp | nullable | Thoi diem huy |
| created_at | timestamp | nullable | Thoi gian tao |
| updated_at | timestamp | nullable | Thoi gian cap nhat |

## 7. booking_details

| Cot | Kieu du lieu | Rang buoc | Y nghia |
|---|---|---|---|
| id | bigint | PK, auto increment | Ma dong chi tiet |
| booking_id | bigint | FK -> bookings.id, cascade delete | Thuoc phieu dat nao |
| court_id | bigint | FK -> courts.id, restrict delete | San duoc dat |
| booking_date | date | index, not null | Ngay su dung san |
| time_slot_id | bigint | FK -> time_slots.id, restrict delete | Ca gio duoc dat |
| created_at | timestamp | nullable | Thoi gian tao |
| updated_at | timestamp | nullable | Thoi gian cap nhat |

Rang buoc bo sung:

- index (`court_id`, `booking_date`, `time_slot_id`)

## 8. usage_logs

| Cot | Kieu du lieu | Rang buoc | Y nghia |
|---|---|---|---|
| id | bigint | PK, auto increment | Ma nhat ky su dung |
| booking_detail_id | bigint | unique, FK -> booking_details.id, cascade delete | Moi booking detail toi da mot nhat ky |
| checked_by | bigint | FK -> users.id, null on delete | Nguoi cap nhat nhat ky |
| used_status | varchar(20) | default `used` | Ket qua su dung thuc te |
| checked_in_at | timestamp | nullable | Moc bat dau ghi nhan |
| checked_out_at | timestamp | nullable | Moc ket thuc ghi nhan |
| note | text | nullable | Ghi chu bo sung |
| created_at | timestamp | nullable | Thoi gian tao |
| updated_at | timestamp | nullable | Thoi gian cap nhat |

## Tong hop quan he chinh

- `sport_types` 1 - N `courts`
- `courts` 1 - N `court_schedules`
- `time_slots` 1 - N `court_schedules`
- `users` 1 - N `bookings`
- `bookings` 1 - N `booking_details`
- `courts` 1 - N `booking_details`
- `time_slots` 1 - N `booking_details`
- `booking_details` 1 - 1 `usage_logs`
- `users` 1 - N `usage_logs`

## Rang buoc nghiep vu can neu trong bao cao

- Khong dat san neu san dang bao tri
- Khong dat san neu khung gio do khong mo
- Khong dat san neu trung `court_id + booking_date + time_slot_id` voi booking dang `pending` hoac `approved`
- Sinh vien chi xem, sua, huy duoc phieu dat cua chinh minh
- Quan tri vien co quyen CRUD danh muc va duyet booking
