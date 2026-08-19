<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Realisasi Retribusi BAPENDA</title>
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
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
        }
        .login-header {
            background: #991b1b;
            color: white;
            padding: 32px 24px;
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

    <div class="login-card">
        <div class="login-header">
            <div class="mb-3 d-inline-flex align-items-center justify-content-center bg-white text-danger rounded-circle shadow-sm" style="width: 60px; height: 60px; font-size: 26px;">
                <i class="fas fa-building-columns"></i>
            </div>
            <h4 class="fw-bold mb-1">SITRIBU RED</h4>
            <p class="small text-white-50 mb-0">Sistem Realisasi Retribusi Daerah</p>
        </div>
        <div class="p-4 p-md-5">

            @if(session('info'))
                <div class="alert alert-info rounded-3 small py-2">
                    <i class="fas fa-info-circle me-1"></i> {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-3 small py-2">
                    <i class="fas fa-exclamation-triangle me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Email / Username Resmi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="admin@retribusi.go.id" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-muted">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-red w-100 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Sistem
                </button>
            </form>

            <div class="border-top pt-3 text-center">
                <span class="small text-muted">Belum memiliki akun resmi?</span>
                <a href="{{ route('register') }}" class="small fw-bold text-danger ms-1 text-decoration-none">Daftar Akun Operator</a>
            </div>

        </div>
    </div>

</body>
</html>
