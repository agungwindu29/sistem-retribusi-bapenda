<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - Sistem Realisasi Retribusi BAPENDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #450a0a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            max-width: 500px;
            width: 100%;
            overflow: hidden;
        }
        .register-header {
            background: #991b1b;
            color: white;
            padding: 28px 24px;
            text-align: center;
        }
        .btn-red {
            background-color: #991b1b;
            color: #ffffff;
            font-weight: 700;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.2s ease;
        }
        .btn-red:hover {
            background-color: #7f1d1d;
            color: white;
            box-shadow: 0 4px 15px rgba(153, 27, 27, 0.4);
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="register-header">
            <div class="mb-2 d-inline-flex align-items-center justify-content-center bg-white text-danger rounded-circle shadow-sm" style="width: 50px; height: 50px; font-size: 22px;">
                <i class="fas fa-user-plus"></i>
            </div>
            <h5 class="fw-bold mb-1">Registrasi Operator</h5>
            <p class="small text-white-50 mb-0">Sistem Realisasi Retribusi Daerah (SITRIBU RED)</p>
        </div>
        <div class="p-4 p-md-5">

            @if($errors->any())
                <div class="alert alert-danger rounded-3 small py-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Nama Lengkap Operator</label>
                    <input type="text" name="name" class="form-control bg-light" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Email Resmi</label>
                    <input type="email" name="email" class="form-control bg-light" placeholder="operator@retribusi.go.id" value="{{ old('email') }}" required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold small text-muted">Peran (Role)</label>
                        <select name="role" class="form-select bg-light" required>
                            <option value="user_opd" selected>Operator OPD</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold small text-muted">Instansi / OPD</label>
                        <select name="opd_name" class="form-select bg-light" required>
                            @foreach($opdList as $opd)
                                <option value="{{ $opd }}">{{ $opd }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold small text-muted">Kata Sandi</label>
                        <input type="password" name="password" class="form-control bg-light" placeholder="••••••••" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold small text-muted">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" class="form-control bg-light" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-red w-100 mb-3">
                    <i class="fas fa-check-circle me-2"></i> Daftar Akun Baru
                </button>
            </form>

            <div class="border-top pt-3 text-center">
                <span class="small text-muted">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="small fw-bold text-danger ms-1 text-decoration-none">Login ke Sistem</a>
            </div>

        </div>
    </div>

</body>
</html>
