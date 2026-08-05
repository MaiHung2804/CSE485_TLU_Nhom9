<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Đặt Sân Thể Thao')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --app-shell-width: min(1680px, calc(100vw - 32px));
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(13, 110, 253, 0.16), transparent 32%),
                linear-gradient(180deg, #eef5ff 0%, #f8fbff 40%, #f3f6fb 100%);
            color: #17324d;
            font-family: "Segoe UI", Tahoma, Verdana, sans-serif;
            font-size: 1.05rem;
        }

        .navbar {
            background: linear-gradient(135deg, #0b4aa9, #0d6efd 62%, #2b8cff) !important;
        }

        .navbar .container-fluid,
        .app-shell {
            width: var(--app-shell-width);
            margin: 0 auto;
        }

        .navbar-brand {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .nav-link {
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.75rem;
            padding-inline: 0.85rem !important;
        }

        .nav-link.active,
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.12);
        }

        .nav-user {
            color: #fff;
            line-height: 1.2;
        }

        .nav-user small {
            display: block;
            opacity: 0.82;
        }

        main {
            padding: 2rem 0 3rem;
        }

        .app-shell {
            padding: 0 0.25rem;
        }

        .page-title {
            font-size: clamp(1.9rem, 2vw, 2.6rem);
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            color: #5f7288;
            font-size: 1.02rem;
        }

        .alert {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            font-size: 0.92rem;
            font-weight: 700;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
        }

        .card,
        .card-stat {
            border: 0;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .card-header {
            padding: 1rem 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th {
            white-space: nowrap;
            font-size: 0.94rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #4d6480;
            padding: 1rem 1.1rem;
        }

        .table tbody td {
            padding: 1rem 1.1rem;
        }

        .form-control,
        .form-select,
        .btn {
            border-radius: 0.9rem;
        }

        .form-control,
        .form-select {
            min-height: 48px;
        }

        .form-label {
            margin-bottom: 0.6rem;
            color: #23476d;
            font-weight: 600;
        }

        .btn {
            min-height: 48px;
            font-weight: 600;
            padding: 0.7rem 1rem;
        }

        .btn-sm {
            min-height: auto;
            border-radius: 0.75rem;
            padding: 0.45rem 0.75rem;
        }

        .pagination {
            gap: 0.4rem;
        }

        .page-link {
            border: 0;
            border-radius: 0.8rem !important;
            color: #0d5cd7;
            padding: 0.65rem 0.95rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
        }

        @media (max-width: 991.98px) {
            .navbar .container-fluid,
            .app-shell {
                width: min(100%, calc(100vw - 20px));
            }

            .nav-user {
                padding: 0.75rem 0;
            }

            main {
                padding-top: 1.25rem;
            }

            .page-title {
                font-size: 1.65rem;
            }
        }
    </style>
</head>
<body>
    @php($currentUser = auth()->user())

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid px-0">
            <a class="navbar-brand" href="{{ $currentUser ? route('dashboard') : route('login') }}">ĐẶT SÂN TLU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                @if ($currentUser)
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-1">
                        <li class="nav-item"><a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">Tổng quan</a></li>
                        <li class="nav-item"><a class="nav-link @if(request()->routeIs('bookings.*')) active @endif" href="{{ route('bookings.index') }}">Đặt sân</a></li>

                        @if ($currentUser->isStaff())
                            <li class="nav-item"><a class="nav-link @if(request()->routeIs('sport-types.*')) active @endif" href="{{ route('sport-types.index') }}">Môn thể thao</a></li>
                            <li class="nav-item"><a class="nav-link @if(request()->routeIs('courts.*')) active @endif" href="{{ route('courts.index') }}">Sân</a></li>
                            <li class="nav-item"><a class="nav-link @if(request()->routeIs('time-slots.*')) active @endif" href="{{ route('time-slots.index') }}">Ca giờ</a></li>
                            <li class="nav-item"><a class="nav-link @if(request()->routeIs('court-schedules.*')) active @endif" href="{{ route('court-schedules.index') }}">Lịch mở</a></li>
                            <li class="nav-item"><a class="nav-link @if(request()->routeIs('usage-logs.*')) active @endif" href="{{ route('usage-logs.index') }}">Nhật ký sử dụng</a></li>
                            <li class="nav-item"><a class="nav-link @if(request()->routeIs('reports.*')) active @endif" href="{{ route('reports.index') }}">Báo cáo</a></li>
                        @endif
                    </ul>

                    <div class="d-lg-flex align-items-center gap-3 ms-lg-4">
                        <div class="nav-user text-lg-end">
                            <strong>{{ $currentUser->name }}</strong>
                            <small>{{ $currentUser->role_label }}</small>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-light btn-sm">Đăng xuất</button>
                        </form>
                    </div>
                @else
                    <div class="ms-auto">
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm">Đăng nhập</a>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <main>
        <div class="app-shell">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
