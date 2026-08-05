@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h1 class="h4 mb-1">Đăng nhập hệ thống</h1>
                    <p class="text-muted mb-0">Sử dụng tài khoản sinh viên hoặc quản trị viên để truy cập đúng phạm vi chức năng.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" @checked(old('remember'))>
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <button class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">Tài khoản demo</h2>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Mật khẩu chung:</strong> <code>password</code></p>
                    <ul class="mb-0">
                        <li><code>admin@campus.local</code> - Quản trị viên</li>
                        <li><code>student1@campus.local</code> - Sinh viên</li>
                        <li><code>student2@campus.local</code> - Sinh viên</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
