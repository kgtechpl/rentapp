<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie – RENTAPP Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a5276 0%, #2980b9 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-sm-8">
            <div class="card login-card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-tools fa-3x text-primary mb-3"></i>
                        <h3 class="fw-bold">RENTAPP</h3>
                        <p class="text-muted">Panel administracyjny</p>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control form-control-lg"
                                   value="{{ old('email') }}" autofocus required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Hasło</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Zapamiętaj mnie</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Zaloguj się
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('home') }}" class="text-muted small">
                            <i class="fas fa-arrow-left me-1"></i>Powrót do strony
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
