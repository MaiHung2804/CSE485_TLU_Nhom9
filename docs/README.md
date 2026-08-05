# Bo tai lieu nop bai

Thu muc `docs` chua bo khung tai lieu cho de tai:

- De tai 6: Dat phong hoc nhom, phong may va san the thao
- Huong trien khai da chon: `San the thao`
- Pham vi hien tai: `Vong 1`

## Danh sach file

- `bao-cao-vong-1-outline.md`
  - Khung noi dung bao cao de chinh sua nhanh
- `erd-dat-san-the-thao.mmd`
  - So do ERD dang Mermaid, co the dua vao draw.io, Markdown hoac render thanh anh
- `data-dictionary.md`
  - Mo ta bang, cot, kieu du lieu, rang buoc va y nghia nghiep vu
- `checklist-nop-bai.md`
  - Checklist doi chieu voi barem truoc khi demo
- `bao-cao-vong-1.docx`
  - File bao cao Word duoc sinh tu script
- `tools/build_report_docx.py`
  - Script tao file DOCX
- `tools/render_docx.py`
  - Script render DOCX ra PNG de kiem tra bo cuc

## Cach dung nhanh

1. Sua thong tin ca nhan trong `bao-cao-vong-1-outline.md` neu can.
2. Neu muon chinh sua noi dung nguon de tao lai file Word, sua trong `tools/build_report_docx.py`.
3. Tao lai file Word:

```bash
python docs/tools/build_report_docx.py
```

4. Render kiem tra bo cuc:

```bash
python docs/tools/render_docx.py docs/bao-cao-vong-1.docx --output_dir docs/render
```

## Luu y

- File DOCX hien tai da duoc dien san noi dung theo project Laravel dang co.
- Cac cho can bo sung thu cong:
  - Ho ten sinh vien
  - Ma sinh vien
  - Lop
  - Ten giang vien
  - Anh chup giao dien neu muon dua vao bao cao chinh thuc
- Neu can nop nhanh, co the dung ngay file DOCX hien tai va chi sua lai thong tin ca nhan.
