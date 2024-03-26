<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tinyus - URL Shortener</title>

    <!-- Meta Tags -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🤏</text></svg>">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Fugaz+One&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-none border-bottom border-3 border-dark bg-milk-punch bg-noise">
        <div class="container">
            <a class="navbar-brand fw-semibold ff-fugaz text-dark" href="{{ route('home') }}">Tinyus! 🤏</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mb-3 mb-lg-0 align-items-center">
                    {{-- Note: Temporarily hide for MVP launch --}}
                    {{-- <li class="nav-item ms-lg-5">
                        <a class="nav-link {{ $navitem['home'] ?? '' }}" aria-current="{{ isset($navitem['home']) ? 'page' : '' }}" href="{{ route('home') }}">Shorten</a>
                    </li>
                    <li class="nav-item ms-lg-5">
                        <a class="nav-link {{ $navitem['stats'] ?? '' }}" aria-current="{{ isset($navitem['stats']) ? 'page' : '' }}" href="{{ route('stats') }}">Analytics</a>
                    </li> --}}
                    <li class="nav-item ms-lg-5">
                        <a href="https://www.buymeacoffee.com/consistentcat" target="_blank">
                            <img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" class="img-fluid btn-shadow-outline border border-3 border-dark" style="height: 35px">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="text-dark">
        @yield('content')
    </main>

    <footer class="bg-highland bg-noise py-5 text-dark text-center">
        <div class="container">
            <p class="ff-fugaz fs-3 mb-3">Tinyus! 🤏</p>
            <p class="mb-3">© 2023 Tinyus. All rights reserved.</p>
            <p class="mb-0">Made with ❤️ by <a href="https://zulkiflizin.com" target="_blank" class="text-decoration-underline text-dark fw-semibold">Consistent Cat</a></p>
        </div>
    </footer>

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
