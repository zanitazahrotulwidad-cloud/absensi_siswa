<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Absensi Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f3f5fb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #fff;
        }

        .brand {
            color: #0d6efd;
            font-weight: 600;
            text-decoration: none;
        }

        main {
            flex: 1;
        }

        .login-card {
            width: 100%;
            max-width: 310px;
            border: none;
            border-radius: 5px;
        }

        .form-control {
            font-size: 14px;
        }

        footer {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <nav class="navbar border-bottom shadow-sm">
        <div class="container">
            <a href="{{ url('/') }}" class="brand">Absensi Siswa</a>

            <a href="{{ url('/') }}"
               class="btn btn-outline-primary btn-sm">
                Kembali ke beranda
            </a>
        </div>
    </nav>

    <main class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12">

                @if ($errors->any())
                    <div class="alert alert-danger py-3 mx-auto"
                         style="max-width: 760px;"
                         role="alert">
                        <strong>Periksa kembali data Anda:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success mx-auto"
                         style="max-width: 760px;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card login-card shadow-sm mx-auto mt-2">
                    <div class="card-body p-3">
                        <h4 class="text-center mb-1">Masuk</h4>

                        <p class="text-center text-muted small mb-4">
                            Gunakan akun yang diberikan admin sekolah.
                        </p>

                        <form action="{{ route('login.process') }}"
                              method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email"
                                       class="form-label small mb-1">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Masukkan email"
                                    autocomplete="username"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password"
                                       class="form-label small mb-1">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required
                                >
                            </div>

                            <div class="form-check mb-3">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    value="1"
                                >
                                <label class="form-check-label small"
                                       for="remember">
                                    Ingat saya
                                </label>
                            </div>

                            <button type="submit"
                                    class="btn btn-primary w-100 btn-sm py-2">
                                Masuk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-4">
        Absensi Siswa · Sistem Absensi Siswa
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
