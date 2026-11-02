<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Absensi Siswa')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand mb-0" href="{{ url('/') }}">
                    Absensi Siswa
                </a>

                @auth
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-white">
                            {{ auth()->user()->name }}
                            ({{ ucfirst(auth()->user()->role) }})
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
