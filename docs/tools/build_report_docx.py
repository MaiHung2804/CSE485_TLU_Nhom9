from __future__ import annotations

from datetime import datetime
from pathlib import Path

from docx import Document
from docx.enum.section import WD_SECTION
from docx.enum.table import WD_ALIGN_VERTICAL, WD_TABLE_ALIGNMENT
from docx.enum.text import WD_ALIGN_PARAGRAPH, WD_BREAK
from docx.oxml import OxmlElement
from docx.oxml.ns import qn
from docx.shared import Inches, Pt, RGBColor

from table_geometry import apply_table_geometry, column_widths_from_weights


BASE_DIR = Path(__file__).resolve().parents[1]
OUTPUT_PATH = BASE_DIR / "bao-cao-vong-1.docx"

COLOR_BLUE = RGBColor(0x2E, 0x74, 0xB5)
COLOR_DARK_BLUE = RGBColor(0x1F, 0x4D, 0x78)
COLOR_NAVY = RGBColor(0x0B, 0x25, 0x45)
COLOR_MUTED = RGBColor(0x66, 0x66, 0x66)
COLOR_LIGHT_FILL = "F2F4F7"
COLOR_NOTE_FILL = "F7F9FC"
COLOR_BORDER = "D7DEE8"

REPORT_META = {
    "de_tai": "De tai 6 - Dat phong hoc nhom, phong may va san the thao",
    "huong_chon": "San the thao",
    "cong_nghe": "Laravel 12, PHP 8.2, Blade, Bootstrap 5, MySQL, phpMyAdmin",
    "mo_hinh": "MVC",
    "sinh_vien": "[Dien ho ten]",
    "ma_sinh_vien": "[Dien ma sinh vien]",
    "lop": "[Dien lop]",
    "giang_vien": "[Dien ten giang vien]",
    "thoi_gian": datetime.now().strftime("Thang %m/%Y"),
}

USE_CASES = [
    ("UC01", "Dang nhap he thong", "Admin, Sinh vien", "Nguoi dung dang nhap de truy cap dung pham vi chuc nang."),
    ("UC02", "Quan ly mon the thao", "Admin", "Them, sua, xoa danh muc mon the thao phuc vu khai bao san."),
    ("UC03", "Quan ly san", "Admin", "Them, sua, xoa san, cap nhat suc chua, vi tri va trang thai."),
    ("UC04", "Quan ly ca gio", "Admin", "Khai bao cac khung gio su dung cho dat san."),
    ("UC05", "Quan ly lich mo san", "Admin", "Gan lich mo theo thu trong tuan va tung ca gio."),
    ("UC06", "Tao phieu dat san", "Sinh vien", "Nhap muc dich, ngay dat, ca gio, san va thong tin lien he."),
    ("UC07", "Kiem tra xung dot", "He thong", "Chan dat san neu trung lich, san bao tri hoac khong mo lich."),
    ("UC08", "Duyet hoac tu choi booking", "Admin", "Cap nhat trang thai booking va ly do tu choi neu co."),
    ("UC09", "Huy booking", "Sinh vien", "Sinh vien huy phieu dat cua chinh minh khi chua hoan tat."),
    ("UC10", "Cap nhat nhat ky su dung", "Admin", "Ghi nhan used, no_show, cancelled sau ca dat san."),
    ("UC11", "Xem bao cao", "Admin", "Tong hop thong ke booking, top san va nhat ky su dung."),
]

BUSINESS_RULES = [
    ("BR01", "San dang bao tri khong duoc phep dat.", "Kiem tra `courts.status = active` truoc khi tao booking."),
    ("BR02", "So nguoi tham gia khong duoc vuot qua suc chua cua san.", "So sanh `player_count` va `courts.capacity`."),
    ("BR03", "San chi duoc dat trong khung gio da mo.", "Doi chieu `court_schedules` theo `court_id`, `day_of_week`, `time_slot_id`."),
    ("BR04", "Khong duoc co hai booking giao nhau cung san, cung ngay, cung ca gio.", "Tra cuu `booking_details` va booking co trang thai `pending` hoac `approved`."),
    ("BR05", "Sinh vien chi duoc thao tac tren phieu dat cua chinh minh.", "Policy kiem tra `booking.user_id === current_user.id`."),
    ("BR06", "Chi admin moi duoc CRUD danh muc va duyet booking.", "Route staff-only duoc bao ve boi middleware `role:admin`."),
    ("BR07", "Mot booking detail toi da co mot usage log.", "Rang buoc unique tren `usage_logs.booking_detail_id`."),
]

TABLES_OVERVIEW = [
    ("users", "Luu tai khoan dang nhap va phan quyen", "Lien ket 1-N voi bookings va usage_logs"),
    ("sport_types", "Danh muc mon the thao", "Lien ket 1-N voi courts"),
    ("courts", "Thong tin tung san", "Lien ket voi sport_types, court_schedules, booking_details"),
    ("time_slots", "Danh muc ca gio", "Lien ket voi court_schedules va booking_details"),
    ("court_schedules", "Lich mo cua tung san theo thu va ca", "Rang buoc unique theo san-thu-ca"),
    ("bookings", "Phieu dat san cap header", "Lien ket voi users va booking_details"),
    ("booking_details", "Chi tiet ngay dat, san dat va ca gio", "Dung de kiem tra trung lich"),
    ("usage_logs", "Nhat ky su dung thuc te", "Lien ket 1-1 voi booking_details"),
]

RELATIONSHIPS = [
    ("users", "bookings", "1 - N", "Mot nguoi dung co the tao nhieu phieu dat."),
    ("users", "bookings (approved_by)", "1 - N", "Mot admin co the duyet nhieu phieu dat."),
    ("sport_types", "courts", "1 - N", "Mot mon the thao co nhieu san."),
    ("courts", "court_schedules", "1 - N", "Mot san co nhieu lich mo theo thu va ca."),
    ("time_slots", "court_schedules", "1 - N", "Mot ca gio co the ap dung cho nhieu san."),
    ("bookings", "booking_details", "1 - N", "Mot phieu dat co the mo rong thanh nhieu dong chi tiet."),
    ("courts", "booking_details", "1 - N", "Mot san co nhieu lan duoc dat."),
    ("time_slots", "booking_details", "1 - N", "Mot ca gio xuat hien trong nhieu booking detail."),
    ("booking_details", "usage_logs", "1 - 1", "Moi booking detail co toi da mot nhat ky su dung."),
    ("users", "usage_logs", "1 - N", "Admin cap nhat nhat ky su dung."),
]

MODULES = [
    ("Module danh muc", "sport_types, courts, time_slots", "CRUD danh muc mon, san va ca gio"),
    ("Module lich mo", "court_schedules", "Khai bao lich mo cua san theo tung thu va ca gio"),
    ("Module booking", "bookings, booking_details", "Tao, sua, huy, duyet va tu choi phieu dat"),
    ("Module nhat ky su dung", "usage_logs", "Ghi nhan ket qua su dung thuc te va dong bo trang thai"),
    ("Module bao cao", "bookings, booking_details, usage_logs", "Thong ke booking, top san, top sinh vien, xu huong"),
    ("Module xac thuc va phan quyen", "users", "Dang nhap, dang xuat, middleware, policy"),
]

DATA_DICTIONARY = [
    {
        "name": "users",
        "note": "Bang luu thong tin tai khoan dang nhap va vai tro nguoi dung.",
        "columns": [
            ("id", "bigint", "PK, auto increment", "Ma nguoi dung"),
            ("name", "varchar(255)", "not null", "Ho ten hien thi"),
            ("email", "varchar(255)", "unique, not null", "Email dang nhap"),
            ("email_verified_at", "timestamp", "nullable", "Moc xac minh email"),
            ("password", "varchar(255)", "not null", "Mat khau da hash"),
            ("role", "varchar(20)", "default student, index", "Vai tro admin/student"),
            ("remember_token", "varchar(100)", "nullable", "Token ghi nho dang nhap"),
            ("created_at", "timestamp", "nullable", "Thoi gian tao"),
            ("updated_at", "timestamp", "nullable", "Thoi gian cap nhat"),
        ],
    },
    {
        "name": "sport_types",
        "note": "Danh muc mon the thao de gan cho tung san.",
        "columns": [
            ("id", "bigint", "PK, auto increment", "Ma mon the thao"),
            ("name", "varchar(255)", "unique, not null", "Ten mon"),
            ("description", "text", "nullable", "Mo ta ngan"),
            ("created_at", "timestamp", "nullable", "Thoi gian tao"),
            ("updated_at", "timestamp", "nullable", "Thoi gian cap nhat"),
        ],
    },
    {
        "name": "courts",
        "note": "Thong tin san the thao va tinh trang khai thac.",
        "columns": [
            ("id", "bigint", "PK, auto increment", "Ma san"),
            ("sport_type_id", "bigint", "FK -> sport_types.id", "Mon the thao cua san"),
            ("name", "varchar(255)", "not null", "Ten san"),
            ("code", "varchar(255)", "unique, not null", "Ma san"),
            ("location", "varchar(255)", "not null", "Vi tri san"),
            ("capacity", "unsigned int", "not null", "Suc chua toi da"),
            ("status", "varchar(20)", "default active, index", "active/maintenance"),
            ("description", "text", "nullable", "Mo ta bo sung"),
            ("created_at", "timestamp", "nullable", "Thoi gian tao"),
            ("updated_at", "timestamp", "nullable", "Thoi gian cap nhat"),
        ],
    },
    {
        "name": "time_slots",
        "note": "Danh muc cac khung gio dat san.",
        "columns": [
            ("id", "bigint", "PK, auto increment", "Ma ca gio"),
            ("label", "varchar(255)", "unique, not null", "Nhan hien thi"),
            ("start_time", "time", "not null", "Gio bat dau"),
            ("end_time", "time", "not null", "Gio ket thuc"),
            ("created_at", "timestamp", "nullable", "Thoi gian tao"),
            ("updated_at", "timestamp", "nullable", "Thoi gian cap nhat"),
        ],
    },
    {
        "name": "court_schedules",
        "note": "Lich mo cua san theo thu trong tuan va ca gio.",
        "columns": [
            ("id", "bigint", "PK, auto increment", "Ma lich mo"),
            ("court_id", "bigint", "FK -> courts.id", "San duoc gan lich"),
            ("day_of_week", "tinyint unsigned", "not null", "Thu trong tuan"),
            ("time_slot_id", "bigint", "FK -> time_slots.id", "Ca gio duoc mo"),
            ("is_open", "boolean", "default true", "Co mo hay khong"),
            ("created_at", "timestamp", "nullable", "Thoi gian tao"),
            ("updated_at", "timestamp", "nullable", "Thoi gian cap nhat"),
        ],
    },
    {
        "name": "bookings",
        "note": "Phieu dat san cap tong quat, the hien nguoi dat va trang thai xu ly.",
        "columns": [
            ("id", "bigint", "PK, auto increment", "Ma booking"),
            ("user_id", "bigint", "FK -> users.id", "Nguoi tao booking"),
            ("purpose", "varchar(255)", "not null", "Muc dich dat san"),
            ("player_count", "unsigned int", "not null", "So nguoi tham gia"),
            ("contact_phone", "varchar(20)", "not null", "So dien thoai lien he"),
            ("status", "varchar(20)", "default pending, index", "pending/approved/rejected/cancelled/completed"),
            ("approved_by", "bigint", "FK -> users.id, nullable", "Admin duyet"),
            ("approved_at", "timestamp", "nullable", "Thoi diem duyet"),
            ("rejection_reason", "text", "nullable", "Ly do tu choi"),
            ("cancel_reason", "text", "nullable", "Ly do huy"),
            ("cancelled_at", "timestamp", "nullable", "Thoi diem huy"),
            ("created_at", "timestamp", "nullable", "Thoi gian tao"),
            ("updated_at", "timestamp", "nullable", "Thoi gian cap nhat"),
        ],
    },
    {
        "name": "booking_details",
        "note": "Chi tiet dat san theo ngay su dung, san va ca gio.",
        "columns": [
            ("id", "bigint", "PK, auto increment", "Ma dong chi tiet"),
            ("booking_id", "bigint", "FK -> bookings.id", "Thuoc booking nao"),
            ("court_id", "bigint", "FK -> courts.id", "San duoc dat"),
            ("booking_date", "date", "index, not null", "Ngay su dung san"),
            ("time_slot_id", "bigint", "FK -> time_slots.id", "Ca gio dat"),
            ("created_at", "timestamp", "nullable", "Thoi gian tao"),
            ("updated_at", "timestamp", "nullable", "Thoi gian cap nhat"),
        ],
    },
    {
        "name": "usage_logs",
        "note": "Nhat ky ghi nhan ket qua su dung thuc te sau buoi dat san.",
        "columns": [
            ("id", "bigint", "PK, auto increment", "Ma nhat ky"),
            ("booking_detail_id", "bigint", "unique, FK -> booking_details.id", "Moi booking detail toi da mot nhat ky"),
            ("checked_by", "bigint", "FK -> users.id, nullable", "Nguoi cap nhat"),
            ("used_status", "varchar(20)", "default used", "used/no_show/cancelled"),
            ("checked_in_at", "timestamp", "nullable", "Moc bat dau"),
            ("checked_out_at", "timestamp", "nullable", "Moc ket thuc"),
            ("note", "text", "nullable", "Ghi chu bo sung"),
            ("created_at", "timestamp", "nullable", "Thoi gian tao"),
            ("updated_at", "timestamp", "nullable", "Thoi gian cap nhat"),
        ],
    },
]

DEMO_STEPS = [
    ("Buoc 1", "Bat Apache va MySQL trong XAMPP", "Dam bao database co the ket noi truoc khi chay Laravel."),
    ("Buoc 2", "Chay php artisan migrate:fresh --seed", "Tai lap CSDL va du lieu demo."),
    ("Buoc 3", "Chay php artisan serve", "Mo he thong tai dia chi localhost."),
    ("Buoc 4", "Dang nhap bang admin@campus.local", "Demo CRUD danh muc, duyet booking va bao cao."),
    ("Buoc 5", "Dang nhap bang student1@campus.local", "Demo tao booking va gioi han quyen so huu."),
    ("Buoc 6", "Mo route quan tri bang tai khoan sinh vien", "Chung minh middleware deny."),
    ("Buoc 7", "Mo booking cua user khac", "Chung minh policy deny."),
]

CHECKLIST_ROWS = [
    ("A1", "Can bo sung anh ERD va diem mot vai tro cua tung bang trong doc chinh thuc.", "Chua hoan tat"),
    ("A2", "Da co migration + seeder + SQL backup.", "Dat"),
    ("A3", "Da co du lieu demo admin, sinh vien, san, lich mo, booking, usage log.", "Dat"),
    ("A4", "Da co Eloquent model va relationship.", "Dat"),
    ("A5", "Da co CRUD danh muc, workflow booking, dashboard va bao cao.", "Dat"),
    ("A6", "Da co backend validation, CSRF, auth, middleware, policy.", "Dat"),
    ("A7", "Kien truc MVC ro rang, tach controller/model/view.", "Dat"),
    ("A8", "Co giao dien responsive co thong bao va empty state co ban.", "Dat"),
    ("A9", "Can commit theo tung moc de tang minh chung Git.", "Can bo sung"),
    ("A10", "Can dien thong tin sinh vien va chot tai lieu nop bai.", "Can bo sung"),
]


def set_run_font(run, name: str = "Calibri", size: float = 11, color: RGBColor | None = None, bold: bool | None = None, italic: bool | None = None) -> None:
    run.font.name = name
    run._element.rPr.rFonts.set(qn("w:ascii"), name)
    run._element.rPr.rFonts.set(qn("w:hAnsi"), name)
    run.font.size = Pt(size)
    if color is not None:
        run.font.color.rgb = color
    if bold is not None:
        run.bold = bold
    if italic is not None:
        run.italic = italic


def set_cell_shading(cell, fill: str) -> None:
    tc_pr = cell._tc.get_or_add_tcPr()
    shd = tc_pr.find(qn("w:shd"))
    if shd is None:
        shd = OxmlElement("w:shd")
        tc_pr.append(shd)
    shd.set(qn("w:fill"), fill)


def set_cell_border(cell, color: str = COLOR_BORDER, size: str = "8") -> None:
    tc_pr = cell._tc.get_or_add_tcPr()
    tc_borders = tc_pr.find(qn("w:tcBorders"))
    if tc_borders is None:
        tc_borders = OxmlElement("w:tcBorders")
        tc_pr.append(tc_borders)
    for edge in ("top", "bottom", "left", "right"):
        edge_el = tc_borders.find(qn(f"w:{edge}"))
        if edge_el is None:
            edge_el = OxmlElement(f"w:{edge}")
            tc_borders.append(edge_el)
        edge_el.set(qn("w:val"), "single")
        edge_el.set(qn("w:sz"), size)
        edge_el.set(qn("w:space"), "0")
        edge_el.set(qn("w:color"), color)


def style_document(doc: Document) -> None:
    section = doc.sections[0]
    section.page_width = Inches(8.5)
    section.page_height = Inches(11)
    section.left_margin = Inches(1)
    section.right_margin = Inches(1)
    section.top_margin = Inches(1)
    section.bottom_margin = Inches(1)
    section.header_distance = Inches(0.492)
    section.footer_distance = Inches(0.492)

    normal = doc.styles["Normal"]
    normal.font.name = "Calibri"
    normal._element.rPr.rFonts.set(qn("w:ascii"), "Calibri")
    normal._element.rPr.rFonts.set(qn("w:hAnsi"), "Calibri")
    normal.font.size = Pt(11)
    normal.paragraph_format.space_after = Pt(6)
    normal.paragraph_format.line_spacing = 1.1

    for style_name, size, color, before, after in [
        ("Heading 1", 16, COLOR_BLUE, 16, 8),
        ("Heading 2", 13, COLOR_BLUE, 12, 6),
        ("Heading 3", 12, COLOR_DARK_BLUE, 8, 4),
    ]:
        style = doc.styles[style_name]
        style.font.name = "Calibri"
        style._element.rPr.rFonts.set(qn("w:ascii"), "Calibri")
        style._element.rPr.rFonts.set(qn("w:hAnsi"), "Calibri")
        style.font.size = Pt(size)
        style.font.color.rgb = color
        style.paragraph_format.space_before = Pt(before)
        style.paragraph_format.space_after = Pt(after)
        style.paragraph_format.line_spacing = 1.1


def add_footer(section) -> None:
    footer_para = section.footer.paragraphs[0]
    footer_para.alignment = WD_ALIGN_PARAGRAPH.CENTER
    footer_para.paragraph_format.space_before = Pt(0)
    footer_para.paragraph_format.space_after = Pt(0)
    run = footer_para.add_run("Du an Laravel MVC - Dat san the thao - Bao cao vong 1")
    set_run_font(run, size=9, color=COLOR_MUTED)


def add_cover(doc: Document) -> None:
    add_footer(doc.sections[0])

    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p.paragraph_format.space_before = Pt(20)
    p.paragraph_format.space_after = Pt(4)
    r = p.add_run("BAO CAO PHAN TICH VA THIET KE HE THONG")
    set_run_font(r, size=20, color=COLOR_NAVY, bold=True)

    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p.paragraph_format.space_after = Pt(6)
    r = p.add_run("HE THONG DAT SAN THE THAO TRONG KHUON VIEN TRUONG")
    set_run_font(r, size=18, color=COLOR_BLUE, bold=True)

    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p.paragraph_format.space_after = Pt(18)
    r = p.add_run("De tai 6 - Nhom 2 - Dich vu sinh vien va khuon vien")
    set_run_font(r, size=12.5, color=COLOR_MUTED, italic=True)

    info_rows = [
        ("Huong trien khai", REPORT_META["huong_chon"]),
        ("Cong nghe", REPORT_META["cong_nghe"]),
        ("Mo hinh", REPORT_META["mo_hinh"]),
        ("Sinh vien thuc hien", REPORT_META["sinh_vien"]),
        ("Ma sinh vien", REPORT_META["ma_sinh_vien"]),
        ("Lop", REPORT_META["lop"]),
        ("Giang vien huong dan", REPORT_META["giang_vien"]),
        ("Thoi gian", REPORT_META["thoi_gian"]),
    ]
    add_table(doc, ["Thong tin", "Noi dung"], info_rows, [1.8, 4.7], header_fill=COLOR_LIGHT_FILL, first_col_bold=True)

    note = (
        "Bo tai lieu nay duoc tao de lam khung nop bai vong 1. "
        "Noi dung da duoc dien san theo project Laravel hien tai; "
        "sinh vien chi can cap nhat thong tin ca nhan, chen anh ERD va anh giao dien neu can."
    )
    add_note_box(doc, note)
    doc.add_page_break()


def add_note_box(doc: Document, text: str) -> None:
    table = doc.add_table(rows=1, cols=1)
    apply_table_geometry(table, [9360], table_width_dxa=9360, indent_dxa=120)
    table.alignment = WD_TABLE_ALIGNMENT.LEFT
    cell = table.cell(0, 0)
    set_cell_shading(cell, COLOR_NOTE_FILL)
    set_cell_border(cell)
    paragraph = cell.paragraphs[0]
    paragraph.paragraph_format.space_before = Pt(0)
    paragraph.paragraph_format.space_after = Pt(0)
    run = paragraph.add_run(text)
    set_run_font(run, size=10.5, color=COLOR_NAVY)


def add_paragraph(doc: Document, text: str, *, bold_prefix: str | None = None) -> None:
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.JUSTIFY
    if bold_prefix:
        prefix_run = p.add_run(bold_prefix)
        set_run_font(prefix_run, size=11, color=COLOR_NAVY, bold=True)
        value_run = p.add_run(text)
        set_run_font(value_run, size=11, color=COLOR_NAVY)
    else:
        run = p.add_run(text)
        set_run_font(run, size=11, color=COLOR_NAVY)


def add_heading(doc: Document, text: str, level: int) -> None:
    p = doc.add_paragraph(style=f"Heading {level}")
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    run = p.add_run(text)
    size = {1: 16, 2: 13, 3: 12}[level]
    color = {1: COLOR_BLUE, 2: COLOR_BLUE, 3: COLOR_DARK_BLUE}[level]
    set_run_font(run, size=size, color=color, bold=True)


def add_table(doc: Document, headers: list[str], rows: list[tuple[str, ...]], width_weights: list[float], *, header_fill: str = COLOR_LIGHT_FILL, first_col_bold: bool = False, font_size: float = 10.2) -> None:
    table = doc.add_table(rows=1 + len(rows), cols=len(headers))
    widths = column_widths_from_weights(width_weights, 9360)
    apply_table_geometry(table, widths, table_width_dxa=9360, indent_dxa=120)
    table.alignment = WD_TABLE_ALIGNMENT.LEFT

    header_cells = table.rows[0].cells
    for idx, header in enumerate(headers):
        cell = header_cells[idx]
        cell.vertical_alignment = WD_ALIGN_VERTICAL.CENTER
        set_cell_shading(cell, header_fill)
        set_cell_border(cell)
        paragraph = cell.paragraphs[0]
        paragraph.paragraph_format.space_before = Pt(0)
        paragraph.paragraph_format.space_after = Pt(0)
        paragraph.alignment = WD_ALIGN_PARAGRAPH.CENTER
        run = paragraph.add_run(header)
        set_run_font(run, size=10.2, color=COLOR_NAVY, bold=True)

    for row_idx, row in enumerate(rows, start=1):
        for col_idx, value in enumerate(row):
            cell = table.cell(row_idx, col_idx)
            cell.vertical_alignment = WD_ALIGN_VERTICAL.CENTER
            set_cell_border(cell)
            paragraph = cell.paragraphs[0]
            paragraph.paragraph_format.space_before = Pt(0)
            paragraph.paragraph_format.space_after = Pt(0)
            paragraph.alignment = WD_ALIGN_PARAGRAPH.LEFT
            run = paragraph.add_run(str(value))
            set_run_font(run, size=font_size, color=COLOR_NAVY, bold=(first_col_bold and col_idx == 0))


def build_report() -> Document:
    doc = Document()
    style_document(doc)
    add_cover(doc)

    add_heading(doc, "1. Gioi thieu de tai", 1)
    add_paragraph(
        doc,
        "Project duoc xay dung theo huong de tai 6 trong nhom Dich vu sinh vien va khuon vien, "
        "tap trung vao bai toan dat san the thao trong truong. He thong nham giai quyet ba nhu cau chinh: "
        "quan ly san va lich mo, tiep nhan va xu ly yeu cau dat san, theo doi khai thac va tong hop bao cao."
    )
    add_paragraph(
        doc,
        "Pham vi vong 1 duoc thiet ke theo huong solo nen uu tien mot luong nghiep vu ro rang, "
        "co quan he du lieu thuc su, co workflow duyet va co kha nang tai lap CSDL bang migration + seeder."
    )

    add_heading(doc, "2. Muc tieu va pham vi", 1)
    add_table(
        doc,
        ["Noi dung", "Mo ta"],
        [
            ("Muc tieu 1", "So hoa quy trinh dat san va tranh trung lich."),
            ("Muc tieu 2", "Phan quyen ro rang giua admin va sinh vien."),
            ("Muc tieu 3", "Quan ly duoc lich mo, san bao tri, usage log va thong ke."),
            ("Pham vi vong 1", "8 bang nghiep vu: users, sport_types, courts, time_slots, court_schedules, bookings, booking_details, usage_logs."),
            ("Cong nghe", REPORT_META["cong_nghe"]),
        ],
        [1.7, 4.8],
        first_col_bold=True,
    )

    add_heading(doc, "3. Tac nhan va use case chinh", 1)
    add_paragraph(doc, "He thong hien tai gom hai nhom tac nhan chinh: admin va sinh vien.")
    add_table(
        doc,
        ["Tac nhan", "Quyen chinh", "Muc tieu su dung"],
        [
            ("Admin", "CRUD danh muc, duyet booking, cap nhat usage log, xem bao cao", "Quan ly toan bo tai nguyen va workflow"),
            ("Sinh vien", "Dang nhap, tao booking, sua/huy booking cua chinh minh", "Dang ky san phu hop nhu cau hoc tap va sinh hoat"),
        ],
        [1.1, 2.8, 2.6],
        first_col_bold=True,
    )
    add_table(
        doc,
        ["Ma", "Use case", "Tac nhan", "Mo ta ngan"],
        USE_CASES,
        [0.7, 1.8, 1.2, 2.8],
        first_col_bold=True,
        font_size=9.8,
    )

    add_heading(doc, "4. Workflow nghiep vu", 1)
    add_heading(doc, "4.1. Quan ly danh muc va lich mo", 2)
    add_paragraph(
        doc,
        "Admin tao mon the thao, tao san, khai bao cac ca gio va gan lich mo theo tung thu trong tuan. "
        "Bang court_schedules giu vai tro cau noi giua san va ca gio, giup he thong xac dinh khi nao san co the dat."
    )
    add_heading(doc, "4.2. Tao booking va kiem tra rang buoc", 2)
    add_paragraph(
        doc,
        "Sinh vien nhap muc dich, so nguoi, so dien thoai, chon san, ngay dat va ca gio. "
        "Truoc khi luu, controller kiem tra san co dang hoat dong hay khong, so nguoi co vuot suc chua hay khong, "
        "khung gio co nam trong lich mo hay khong va co trung voi booking dang pending/approved hay khong."
    )
    add_heading(doc, "4.3. Duyet, tu choi va huy", 2)
    add_paragraph(
        doc,
        "Sau khi booking duoc tao, he thong dua ve trang thai pending. Admin co the duyet hoac tu choi phieu dat. "
        "Sinh vien co the huy booking cua chinh minh khi phieu dat chua hoan tat."
    )
    add_heading(doc, "4.4. Usage log va bao cao", 2)
    add_paragraph(
        doc,
        "Sau buoi dat san, admin cap nhat usage log voi cac gia tri used, no_show hoac cancelled. "
        "Du lieu nay duoc su dung de dong bo trang thai booking va tong hop bao cao thong ke theo khoang thoi gian."
    )

    add_heading(doc, "5. Quy tac nghiep vu", 1)
    add_table(
        doc,
        ["Ma", "Quy tac", "Minh chung thuc hien"],
        BUSINESS_RULES,
        [0.8, 3.0, 2.7],
        first_col_bold=True,
        font_size=9.8,
    )

    add_heading(doc, "6. Thiet ke CSDL", 1)
    add_paragraph(
        doc,
        "He thong su dung 8 bang nghiep vu. Phan tach du lieu theo huong header-detail giup viec xu ly booking ro rang hon, "
        "de mo rong ve sau khi can dat nhieu khung gio trong mot phieu."
    )
    add_table(
        doc,
        ["Bang", "Vai tro", "Quan he chinh"],
        TABLES_OVERVIEW,
        [1.4, 2.8, 2.3],
        first_col_bold=True,
    )

    add_heading(doc, "6.1. Tom tat quan he logic", 2)
    add_table(
        doc,
        ["Bang nguon", "Bang dich", "Kieu", "Y nghia"],
        RELATIONSHIPS,
        [1.3, 1.8, 0.8, 2.6],
        first_col_bold=True,
        font_size=9.8,
    )
    add_note_box(
        doc,
        "ERD nguon duoc dat tai file docs/erd-dat-san-the-thao.mmd. "
        "Khi nop ban chinh thuc, nen render ERD nay thanh PNG hoac PDF de chen vao bao cao."
    )

    doc.add_page_break()
    add_heading(doc, "7. Data dictionary", 1)
    add_paragraph(
        doc,
        "Phan nay tong hop cac cot quan trong, kieu du lieu va rang buoc chinh cua tung bang. "
        "Cac bang framework nhu migrations, cache, sessions, jobs khong nam trong pham vi tinh diem nghiep vu."
    )
    for item in DATA_DICTIONARY:
        add_heading(doc, f"7.{DATA_DICTIONARY.index(item) + 1}. Bang {item['name']}", 2)
        add_paragraph(doc, item["note"])
        add_table(
            doc,
            ["Cot", "Kieu du lieu", "Rang buoc", "Y nghia"],
            item["columns"],
            [1.5, 1.6, 1.8, 2.1],
            first_col_bold=True,
            font_size=9.6,
        )

    doc.add_page_break()
    add_heading(doc, "8. Phan chia module va kien truc MVC", 1)
    add_table(
        doc,
        ["Module", "Bang lien quan", "Chuc nang chinh"],
        MODULES,
        [1.8, 1.9, 2.8],
        first_col_bold=True,
        font_size=9.8,
    )
    add_paragraph(doc, "Model su dung Eloquent relationship de lien ket du lieu giua cac bang.")
    add_paragraph(doc, "Controller thuc hien validation, nghiep vu va dieu huong sau khi xu ly request.")
    add_paragraph(doc, "View su dung Blade de hien thi dashboard, form CRUD, booking detail, usage log va bao cao.")

    add_heading(doc, "9. Xac thuc va phan quyen", 1)
    add_paragraph(
        doc,
        "He thong co chuc nang dang nhap, dang xuat va phan quyen hai nhom vai tro. "
        "Route quan tri duoc bao ve boi middleware role:admin. Doi voi booking, policy cho phep admin thao tac toan bo "
        "va gioi han sinh vien chi duoc xem, sua, huy phieu dat cua chinh minh."
    )
    add_table(
        doc,
        ["Tai khoan demo", "Vai tro", "Muc dich demo"],
        [
            ("admin@campus.local / password", "Admin", "CRUD danh muc, duyet booking, usage log, bao cao"),
            ("student1@campus.local / password", "Sinh vien", "Tao booking va demo allow"),
            ("student2@campus.local / password", "Sinh vien", "Dung de demo deny so huu booking"),
        ],
        [2.8, 1.1, 2.6],
        first_col_bold=True,
        font_size=9.8,
    )

    add_heading(doc, "10. Huong dan cai dat va demo", 1)
    add_table(
        doc,
        ["Buoc", "Thao tac", "Ghi chu"],
        DEMO_STEPS,
        [0.9, 2.4, 3.2],
        first_col_bold=True,
        font_size=9.8,
    )

    add_heading(doc, "11. Danh gia nhanh theo barem", 1)
    add_table(
        doc,
        ["Muc", "Nhan xet", "Trang thai"],
        CHECKLIST_ROWS,
        [0.8, 4.5, 1.2],
        first_col_bold=True,
        font_size=9.8,
    )
    add_note_box(
        doc,
        "De dat muc A cho chac chan, can bo sung ERD dang anh vao bao cao va tao lich su commit Git theo tung moc ro rang."
    )

    add_heading(doc, "12. Huong mo rong", 1)
    add_table(
        doc,
        ["Huong mo rong", "Gia tri"],
        [
            ("Gioi han so lan dat theo tuan", "Dap ung rang buoc booking policy nang cao"),
            ("Lich bao tri chi tiet", "Phan biet ro lich mo va lich khoa san"),
            ("Thong bao tu dong", "Tang trai nghiem khi booking duoc duyet hoac tu choi"),
            ("Xuat bao cao PDF/Excel", "Ho tro tong hop va nop bao cao nhanh hon"),
            ("Audit log", "Theo doi lich su thao tac he thong"),
        ],
        [2.7, 3.8],
        first_col_bold=True,
    )

    return doc


def main() -> None:
    doc = build_report()
    doc.save(OUTPUT_PATH)
    print(f"Created: {OUTPUT_PATH}")


if __name__ == "__main__":
    main()
