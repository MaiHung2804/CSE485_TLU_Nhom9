@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
    <div class="auth-grid">
        <section class="auth-showcase">
            <div class="auth-showcase-copy">
                <span class="brand-chip">Không gian thể thao số</span>
                <h1>Hệ thống quản lý và đặt sân thể thao trong khuôn viên Trường Đại học Thủy Lợi</h1>
                <p>Chọn sân phù hợp, xem lịch mở theo ca và theo dõi trạng thái xử lý trên một giao diện hiện đại, sáng rõ và dễ dùng ngay từ lần đầu đăng nhập.</p>

                <div class="auth-badge-row">
                    <span class="auth-badge"><i class="bi bi-calendar2-week"></i>Theo lịch mở</span>
                    <span class="auth-badge"><i class="bi bi-check2-circle"></i>Xử lý rõ ràng</span>
                    <span class="auth-badge"><i class="bi bi-graph-up-arrow"></i>Báo cáo trực quan</span>
                </div>
            </div>

            <div class="auth-stats">
                <div class="mini-stat">
                    <span>Lịch mở</span>
                    <strong>Theo ca</strong>
                    <small>Xem nhanh khung giờ phù hợp cho từng sân.</small>
                </div>
                <div class="mini-stat">
                    <span>Booking</span>
                    <strong>Tập trung</strong>
                    <small>Theo dõi trạng thái xử lý ngay trên một màn hình.</small>
                </div>
                <div class="mini-stat">
                    <span>Báo cáo</span>
                    <strong>Dễ nhìn</strong>
                    <small>Nắm nhanh xu hướng sử dụng sân trong hệ thống.</small>
                </div>
            </div>

            <div class="auth-feature-list">
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="bi bi-calendar2-check-fill"></i></div>
                    <div>
                        <h2>Lịch mở trực quan</h2>
                        <p>Nhìn nhanh sân nào phù hợp theo từng khung giờ.</p>
                    </div>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <h2>Phê duyệt tập trung</h2>
                        <p>Xử lý yêu cầu đặt sân rõ ràng, gọn và dễ kiểm soát.</p>
                    </div>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                    <div>
                        <h2>Thống kê sinh động</h2>
                        <p>Dữ liệu sử dụng sân được tổng hợp gọn mắt và dễ đọc.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-panel-header">
                <span class="page-kicker">Chào mừng quay lại</span>
                <h2 class="section-title mb-2">Đăng nhập hệ thống</h2>
                <p class="section-subtitle">Đăng nhập để truy cập đúng chức năng theo vai trò của bạn trong hệ thống.</p>
            </div>

            <div class="auth-panel-body">
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="auth-input-shell">
                            <span class="auth-input-icon"><i class="bi bi-envelope-paper"></i></span>
                            <input type="email" name="email" class="form-control auth-input-control" value="{{ old('email') }}" placeholder="Nhập email tài khoản" required autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <div class="auth-input-shell">
                            <span class="auth-input-icon"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="password" class="form-control auth-input-control" placeholder="Nhập mật khẩu" required>
                        </div>
                    </div>
                    <div class="auth-remember-row mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" @checked(old('remember'))>
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập trên thiết bị này</label>
                        </div>
                        <span class="auth-inline-note">Đăng nhập bằng tài khoản đã được cấp</span>
                    </div>
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                    </button>
                </form>

                <div class="auth-panel-footnote">
                    <i class="bi bi-shield-check"></i>
                    <span>Giao diện chung cho quản trị viên và sinh viên, hiển thị chức năng theo đúng quyền truy cập.</span>
                </div>
            </div>
        </section>
    </div>
@endsection
