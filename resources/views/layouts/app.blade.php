<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Đặt sân thể thao TLU')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-950: #0d1b2f;
            --brand-900: #163455;
            --brand-800: #1f4f80;
            --brand-700: #2563eb;
            --brand-600: #2f80ed;
            --brand-100: #eef5ff;
            --brand-050: #f6f9ff;
            --accent: #22c1c3;
            --accent-soft: rgba(34, 193, 195, 0.14);
            --surface: rgba(255, 255, 255, 0.88);
            --surface-strong: #ffffff;
            --surface-border: rgba(148, 163, 184, 0.18);
            --text-main: #16314d;
            --text-soft: #67809b;
            --shadow-soft: 0 20px 45px rgba(15, 23, 42, 0.08);
            --shadow-strong: 0 28px 60px rgba(15, 23, 42, 0.14);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            position: relative;
            overflow-x: hidden;
            background:
                radial-gradient(circle at top left, rgba(47, 128, 237, 0.22), transparent 28%),
                radial-gradient(circle at top right, rgba(34, 193, 195, 0.16), transparent 26%),
                linear-gradient(180deg, #f3f8ff 0%, #edf4fc 46%, #f8fbff 100%);
            color: var(--text-main);
            font-family: "Be Vietnam Pro", "Segoe UI", sans-serif;
            font-size: 1.02rem;
            line-height: 1.6;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            z-index: -1;
            pointer-events: none;
            filter: blur(10px);
        }

        body::before {
            width: 360px;
            height: 360px;
            right: -120px;
            top: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(34, 193, 195, 0.18), transparent 68%);
        }

        body::after {
            width: 420px;
            height: 420px;
            left: -140px;
            bottom: -160px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(47, 128, 237, 0.16), transparent 70%);
        }

        a {
            text-decoration: none;
        }

        .dashboard-layout {
            min-height: 100vh;
            display: flex;
            gap: 1.5rem;
            padding: 1.35rem;
        }

        .dashboard-sidebar {
            width: 380px !important;
            max-width: 380px;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.16), transparent 34%),
                linear-gradient(180deg, #122845 0%, #15365c 50%, #1b4e7d 100%);
            color: #fff;
            border: 0;
            border-radius: 30px;
            box-shadow: var(--shadow-strong);
            overflow: hidden;
        }

        .sidebar-inner {
            min-height: calc(100vh - 2.7rem);
            display: flex;
            flex-direction: column;
            gap: 1.6rem;
            padding: 2rem 1.85rem;
        }

        .brand-panel {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 1rem;
            align-items: start;
        }

        .brand-mark {
            width: 72px;
            height: 72px;
            display: grid;
            place-items: center;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 1.9rem;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
        }

        .brand-chip,
        .topbar-pill,
        .info-chip,
        .user-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border-radius: 999px;
            font-size: 0.83rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            padding: 0.45rem 0.85rem;
        }

        .brand-chip {
            color: #dcecff;
            background: rgba(255, 255, 255, 0.12);
            margin-bottom: 0.65rem;
        }

        .brand-title {
            margin: 0;
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1.18;
        }

        .brand-subtitle,
        .sidebar-user-email {
            margin: 0.55rem 0 0;
            color: rgba(230, 239, 255, 0.78);
            font-size: 1rem;
            line-height: 1.75;
        }

        .sidebar-section-label {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(222, 236, 255, 0.7);
        }

        .sidebar-nav {
            display: grid;
            gap: 0.55rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 1rem 1.05rem;
            border-radius: 18px;
            color: rgba(241, 246, 255, 0.88);
            font-size: 1.02rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
            transform: translateX(2px);
        }

        .nav-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.1);
            font-size: 1.05rem;
        }

        .sidebar-note,
        .sidebar-user-card {
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
        }

        .sidebar-note {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 0.9rem;
            padding: 1.15rem 1.15rem 1.2rem;
        }

        .sidebar-note-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.16);
            color: #fff8d2;
        }

        .sidebar-note h2,
        .sidebar-user-name {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
        }

        .sidebar-note p {
            margin: 0.35rem 0 0;
            color: rgba(237, 244, 255, 0.78);
            font-size: 0.92rem;
        }

        .sidebar-user-card {
            margin-top: auto;
            padding: 1rem;
        }

        .sidebar-user-label,
        .topbar-label,
        .page-kicker,
        .panel-kicker {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .sidebar-user-label {
            color: rgba(222, 236, 255, 0.72);
        }

        .user-role-badge {
            color: #083560;
            background: #dff2ff;
        }

        .sidebar-user-email {
            font-size: 0.9rem;
        }

        .dashboard-main {
            min-width: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .dashboard-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.25rem;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.56);
            backdrop-filter: blur(18px);
            box-shadow: var(--shadow-soft);
        }

        .topbar-label {
            margin: 0 0 0.2rem;
            color: var(--text-soft);
        }

        .topbar-title {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .topbar-pill {
            color: var(--brand-900);
            background: rgba(47, 128, 237, 0.12);
        }

        .topbar-pill--soft {
            background: rgba(255, 255, 255, 0.8);
        }

        .topbar-menu {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: var(--brand-700);
            border: 1px solid rgba(37, 99, 235, 0.14);
            background: rgba(37, 99, 235, 0.08);
        }

        .dashboard-content {
            padding-bottom: 1.25rem;
        }

        .guest-main {
            min-height: 100vh;
            display: grid;
            align-items: center;
            padding: 2.5rem 1.1rem;
        }

        .guest-shell {
            width: min(1480px, calc(100vw - 28px));
            margin: 0 auto;
        }

        .alert {
            border: 0;
            border-radius: 22px;
            padding: 1rem 1.2rem;
            box-shadow: var(--shadow-soft);
        }

        .page-hero,
        .surface-card,
        .card {
            background: var(--surface);
            border: 1px solid var(--surface-border);
            border-radius: 28px;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(14px);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .page-hero {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: 1.6rem;
            margin-bottom: 1.4rem;
            background:
                radial-gradient(circle at top right, rgba(34, 193, 195, 0.18), transparent 28%),
                linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(242, 248, 255, 0.92));
        }

        .page-hero::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            right: -70px;
            bottom: -120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(47, 128, 237, 0.14), transparent 68%);
            z-index: -1;
        }

        .page-hero.compact {
            padding: 1.35rem 1.45rem;
        }

        .page-hero-grid {
            display: grid;
            gap: 1.35rem;
        }

        .page-kicker,
        .panel-kicker {
            color: var(--brand-700);
            margin-bottom: 0.55rem;
        }

        .page-title,
        .section-title {
            color: var(--brand-950);
            letter-spacing: -0.03em;
        }

        .page-title {
            margin: 0 0 0.5rem;
            font-size: clamp(2rem, 2.6vw, 3rem);
            font-weight: 800;
            line-height: 1.12;
        }

        .section-title {
            font-weight: 700;
        }

        .section-subtitle {
            margin: 0;
            color: var(--text-soft);
            font-size: 1rem;
            max-width: 760px;
        }

        .hero-actions,
        .hero-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .hero-meta {
            margin-top: 1rem;
        }

        .info-chip {
            color: var(--brand-900);
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(37, 99, 235, 0.12);
        }

        .metric-card {
            position: relative;
            height: 100%;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            padding: 1.35rem;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(241, 247, 255, 0.92));
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .metric-card::after {
            content: "";
            position: absolute;
            inset: auto -40px -75px auto;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(47, 128, 237, 0.12), transparent 68%);
        }

        .metric-icon {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            border-radius: 18px;
            font-size: 1.25rem;
            color: var(--brand-700);
            background: rgba(37, 99, 235, 0.12);
        }

        .metric-label {
            display: block;
            color: var(--text-soft);
            font-size: 0.94rem;
            margin-bottom: 0.35rem;
        }

        .metric-card h2 {
            margin: 0;
            font-size: clamp(1.8rem, 2vw, 2.4rem);
            font-weight: 800;
            line-height: 1.1;
        }

        .metric-card p {
            margin: 0.5rem 0 0;
            color: var(--text-soft);
            font-size: 0.92rem;
        }

        .surface-card,
        .card {
            overflow: hidden;
        }

        .table-card .table-toolbar,
        .panel-header,
        .surface-header,
        .card-header {
            padding: 1.2rem 1.35rem;
            background: transparent;
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        .panel-body,
        .surface-body,
        .card-body {
            padding: 1.35rem;
        }

        .table-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .table-responsive {
            padding-bottom: 0.25rem;
        }

        .table,
        .data-table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th,
        .data-table thead th {
            border: 0;
            background: #f6f9ff;
            color: #58718d;
            font-size: 0.86rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 1rem 1.15rem;
        }

        .table tbody td,
        .data-table tbody td {
            border-top: 1px solid rgba(148, 163, 184, 0.16);
            padding: 1rem 1.15rem;
        }

        .table tbody tr:hover,
        .data-table tbody tr:hover {
            background: rgba(47, 128, 237, 0.05);
        }

        .table-secondary-text {
            color: var(--text-soft);
            font-size: 0.92rem;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.5rem 0.85rem;
            font-size: 0.85rem;
            font-weight: 700;
            line-height: 1;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .detail-item {
            padding: 1rem 1.05rem;
            border-radius: 20px;
            background: rgba(246, 249, 255, 0.92);
            border: 1px solid rgba(37, 99, 235, 0.08);
        }

        .detail-label {
            display: block;
            color: var(--text-soft);
            font-size: 0.88rem;
            margin-bottom: 0.35rem;
        }

        .detail-value {
            font-weight: 700;
            color: var(--brand-950);
        }

        .form-panel .panel-body {
            padding-top: 1.2rem;
        }

        .side-note-card {
            height: 100%;
            padding: 1.35rem;
        }

        .rule-list,
        .workflow-list {
            margin: 0;
            padding-left: 1.15rem;
            color: var(--text-soft);
        }

        .rule-list li,
        .workflow-list li {
            margin-bottom: 0.7rem;
        }

        .workflow-list strong,
        .rule-list strong {
            color: var(--brand-950);
        }

        .quick-list {
            display: grid;
            gap: 0.85rem;
        }

        .quick-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.9rem 1rem;
            border-radius: 18px;
            background: rgba(246, 249, 255, 0.96);
            border: 1px solid rgba(37, 99, 235, 0.08);
        }

        .quick-item + .quick-item {
            margin-top: 0;
        }

        .progress-soft {
            height: 10px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.12);
            overflow: hidden;
        }

        .progress-soft .progress-bar {
            border-radius: 999px;
            background: linear-gradient(90deg, #2f80ed, #22c1c3);
        }

        .empty-state {
            padding: 2.4rem 1.5rem;
            text-align: center;
            color: var(--text-soft);
        }

        .btn {
            border-radius: 16px;
            min-height: 48px;
            font-weight: 700;
            padding: 0.75rem 1rem;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease, border-color 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-sm {
            min-height: auto;
            border-radius: 14px;
            padding: 0.5rem 0.82rem;
            font-weight: 600;
        }

        .btn-primary {
            border: 0;
            background: linear-gradient(135deg, #2157d5, #2f80ed 65%, #22c1c3);
            box-shadow: 0 18px 32px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(135deg, #1949b6, #256fe4 65%, #1cb1b3);
        }

        .btn-outline-secondary,
        .btn-outline-primary,
        .btn-outline-danger {
            background: rgba(255, 255, 255, 0.86);
        }

        .form-control,
        .form-select {
            min-height: 52px;
            border-radius: 16px;
            border: 1px solid rgba(37, 99, 235, 0.14);
            background: rgba(255, 255, 255, 0.92);
            padding-inline: 1rem;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(37, 99, 235, 0.34);
            box-shadow: 0 0 0 0.28rem rgba(47, 128, 237, 0.12);
        }

        .form-control-sm,
        .form-select-sm {
            min-height: 42px;
            border-radius: 14px;
        }

        .form-control::placeholder {
            color: #8ca0b6;
        }

        textarea.form-control {
            min-height: 120px;
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }

        .form-label {
            margin-bottom: 0.55rem;
            color: var(--brand-900);
            font-weight: 700;
        }

        .pagination {
            gap: 0.45rem;
        }

        .page-link {
            border: 0;
            border-radius: 14px !important;
            color: var(--brand-700);
            padding: 0.7rem 0.95rem;
            box-shadow: var(--shadow-soft);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #2157d5, #2f80ed);
        }

        .auth-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.24fr) minmax(480px, 0.9fr);
            gap: 2rem;
            align-items: stretch;
        }

        .auth-showcase,
        .auth-panel {
            border-radius: 32px;
            box-shadow: var(--shadow-strong);
            overflow: hidden;
        }

        .auth-showcase {
            position: relative;
            min-height: 820px;
            padding: 2.8rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 30%),
                radial-gradient(circle at 18% 18%, rgba(34, 193, 195, 0.14), transparent 22%),
                linear-gradient(135deg, #0f2340 0%, #17375b 45%, #1f6ca8 100%);
        }

        .auth-showcase::before,
        .auth-showcase::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .auth-showcase::before {
            width: 240px;
            height: 240px;
            right: -70px;
            top: -40px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.22), transparent 66%);
        }

        .auth-showcase::after {
            width: 180px;
            height: 180px;
            left: -45px;
            bottom: -30px;
            background: radial-gradient(circle, rgba(34, 193, 195, 0.24), transparent 70%);
        }

        .auth-showcase h1 {
            margin: 0 0 0.8rem;
            font-size: clamp(3.2rem, 4.3vw, 5.25rem);
            font-weight: 800;
            line-height: 1.02;
            letter-spacing: -0.04em;
        }

        .auth-showcase p {
            max-width: 760px;
            color: rgba(237, 244, 255, 0.82);
            font-size: 1.08rem;
            line-height: 1.8;
        }

        .auth-showcase-copy {
            max-width: 860px;
        }

        .auth-badge-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1.35rem;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 0.95rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #eef6ff;
            font-size: 0.92rem;
            font-weight: 600;
            letter-spacing: 0.01em;
            backdrop-filter: blur(8px);
        }

        .auth-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .mini-stat {
            position: relative;
            padding: 1.1rem 1rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.14), rgba(255, 255, 255, 0.08));
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            overflow: hidden;
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .mini-stat::after {
            content: "";
            position: absolute;
            inset: auto -10px -42px auto;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.16), transparent 68%);
        }

        .mini-stat span {
            display: block;
            font-size: 0.84rem;
            color: rgba(230, 239, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .mini-stat strong {
            display: block;
            margin-top: 0.35rem;
            font-size: 1.55rem;
        }

        .mini-stat small {
            display: block;
            margin-top: 0.35rem;
            color: rgba(237, 244, 255, 0.8);
        }

        .auth-feature-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .auth-feature {
            display: flex;
            flex-direction: column;
            gap: 0.95rem;
            align-items: flex-start;
            min-height: 100%;
            padding: 1.15rem 1.15rem 1.25rem;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.13), rgba(255, 255, 255, 0.08));
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .auth-feature-icon {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.14);
            font-size: 1.05rem;
        }

        .auth-feature h2 {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 700;
        }

        .auth-feature p {
            margin: 0.25rem 0 0;
            font-size: 0.96rem;
        }

        .auth-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(247, 250, 255, 0.92));
            border: 1px solid rgba(255, 255, 255, 0.62);
        }

        .auth-panel-header {
            padding: 2.2rem 2.1rem 0.55rem;
        }

        .auth-panel-body {
            padding: 1.25rem 2.1rem 2.1rem;
        }

        .auth-panel .section-title {
            font-size: 2.2rem;
        }

        .auth-input-shell {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            min-height: 58px;
            padding: 0.1rem 1rem;
            border-radius: 18px;
            border: 1px solid rgba(37, 99, 235, 0.14);
            background: rgba(255, 255, 255, 0.94);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.68);
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .auth-input-shell:focus-within {
            border-color: rgba(37, 99, 235, 0.34);
            box-shadow: 0 0 0 0.28rem rgba(47, 128, 237, 0.12);
        }

        .auth-input-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(47, 128, 237, 0.08);
            color: var(--brand-700);
            font-size: 1rem;
        }

        .auth-input-control,
        .auth-input-control:focus {
            min-height: auto;
            border: 0;
            background: transparent;
            box-shadow: none;
            padding: 0;
        }

        .auth-remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .auth-inline-note {
            color: var(--text-soft);
            font-size: 0.92rem;
        }

        .auth-panel-footnote {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-top: 1.3rem;
            padding: 1rem 1.05rem;
            border-radius: 20px;
            background: rgba(246, 249, 255, 0.92);
            border: 1px solid rgba(37, 99, 235, 0.08);
            color: var(--text-soft);
        }

        .auth-panel-footnote i {
            color: var(--brand-700);
            font-size: 1rem;
            margin-top: 0.12rem;
        }

        .page-hero:hover,
        .surface-card:hover,
        .metric-card:hover,
        .mini-stat:hover,
        .auth-feature:hover {
            transform: translateY(-2px);
            box-shadow: 0 26px 52px rgba(15, 23, 42, 0.11);
        }

        @media (max-width: 1199.98px) {
            .auth-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1399.98px) {
            .auth-feature-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .dashboard-layout {
                padding: 0.9rem;
            }

            .dashboard-sidebar {
                width: min(94vw, 390px) !important;
                max-width: none;
                border-radius: 0;
            }

            .sidebar-inner {
                min-height: 100%;
                padding: 1.25rem;
            }

            .dashboard-topbar {
                border-radius: 22px;
            }

            .topbar-actions {
                display: none;
            }

            .page-hero,
            .surface-card,
            .card,
            .auth-showcase,
            .auth-panel {
                border-radius: 24px;
            }
        }

        @media (max-width: 767.98px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .auth-showcase,
            .auth-panel-header,
            .auth-panel-body {
                padding-inline: 1.2rem;
            }

            .auth-showcase {
                padding-block: 1.5rem;
            }

            .auth-stats {
                grid-template-columns: 1fr;
            }

            .auth-feature-list {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .table-toolbar,
            .dashboard-topbar {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body class="{{ auth()->check() ? 'app-authenticated' : 'app-guest' }}">
    @php
        $currentUser = auth()->user();
        $navItems = [
            ['route' => 'dashboard', 'pattern' => 'dashboard', 'label' => 'Tổng quan', 'icon' => 'bi-grid-1x2-fill'],
            ['route' => 'bookings.index', 'pattern' => 'bookings.*', 'label' => 'Đặt sân', 'icon' => 'bi-calendar2-check-fill'],
        ];

        if ($currentUser?->isStaff()) {
            $navItems = array_merge($navItems, [
                ['route' => 'sport-types.index', 'pattern' => 'sport-types.*', 'label' => 'Môn thể thao', 'icon' => 'bi-dribbble'],
                ['route' => 'courts.index', 'pattern' => 'courts.*', 'label' => 'Sân thể thao', 'icon' => 'bi-bounding-box-circles'],
                ['route' => 'time-slots.index', 'pattern' => 'time-slots.*', 'label' => 'Ca giờ', 'icon' => 'bi-clock-history'],
                ['route' => 'court-schedules.index', 'pattern' => 'court-schedules.*', 'label' => 'Lịch mở', 'icon' => 'bi-calendar3-week-fill'],
                ['route' => 'usage-logs.index', 'pattern' => 'usage-logs.*', 'label' => 'Nhật ký sử dụng', 'icon' => 'bi-clipboard2-data-fill'],
                ['route' => 'reports.index', 'pattern' => 'reports.*', 'label' => 'Báo cáo', 'icon' => 'bi-bar-chart-fill'],
            ]);
        }
    @endphp

    @if ($currentUser)
        <div class="dashboard-layout">
            <aside class="dashboard-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header d-lg-none border-bottom border-white border-opacity-10">
                    <div>
                        <div class="brand-chip">Cổng điều phối</div>
                        <h2 class="offcanvas-title h5 text-white mb-0" id="sidebarMenuLabel">Đặt sân TLU</h2>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Đóng"></button>
                </div>

                <div class="sidebar-inner">
                    <div class="brand-panel">
                        <div class="brand-mark"><i class="bi bi-trophy-fill"></i></div>
                        <div>
                            <span class="brand-chip">Trung tâm vận hành</span>
                            <h1 class="brand-title">Đặt sân thể thao TLU</h1>
                            <p class="brand-subtitle">Quản lý tài nguyên sân bãi, lịch mở theo ca, phê duyệt yêu cầu và thống kê sử dụng trong một giao diện rõ ràng, hiện đại.</p>
                        </div>
                    </div>

                    <div class="sidebar-section-label">Điều hướng nhanh</div>

                    <nav class="sidebar-nav">
                        @foreach ($navItems as $item)
                            <a class="nav-link @if (request()->routeIs($item['pattern'])) active @endif" href="{{ route($item['route']) }}">
                                <span class="nav-icon"><i class="bi {{ $item['icon'] }}"></i></span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>

                    <div class="sidebar-note">
                        <div class="sidebar-note-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                        <div>
                            <h2>Vận hành trực quan</h2>
                            <p>Theo dõi nhanh lịch mở, xử lý booking và cập nhật tình trạng sử dụng sân chỉ trong vài thao tác.</p>
                        </div>
                    </div>

                    <div class="sidebar-user-card">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <p class="sidebar-user-label mb-1">Tài khoản hiện tại</p>
                                <h2 class="sidebar-user-name">{{ $currentUser->name }}</h2>
                            </div>
                            <span class="user-role-badge">{{ $currentUser->role_label }}</span>
                        </div>
                        <p class="sidebar-user-email">{{ $currentUser->email }}</p>

                        <form action="{{ route('logout') }}" method="POST" class="mt-3">
                            @csrf
                            <button class="btn btn-light w-100">
                                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="dashboard-main">
                <header class="dashboard-topbar">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn topbar-menu d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                            <i class="bi bi-list fs-4"></i>
                        </button>

                        <div>
                            <p class="topbar-label">Hệ thống quản lý và đặt sân thể thao TLU</p>
                            <h2 class="topbar-title">@yield('title', 'Tổng quan')</h2>
                        </div>
                    </div>

                    <div class="topbar-actions">
                        <span class="topbar-pill"><i class="bi bi-shield-check"></i>{{ $currentUser->role_label }}</span>
                        <span class="topbar-pill topbar-pill--soft"><i class="bi bi-calendar3"></i>{{ now()->format('d/m/Y') }}</span>
                    </div>
                </header>

                <main class="dashboard-content">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning">{{ session('warning') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Vui lòng kiểm tra lại các lỗi sau:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <main class="guest-main">
            <div class="guest-shell">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Vui lòng kiểm tra lại các lỗi sau:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
