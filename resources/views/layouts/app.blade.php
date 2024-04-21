<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Styles -->
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{route('home')}}">Demo Project</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs('home') ? 'active' : ''}}" href="{{route('home')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs('companies') ? 'active' : ''}}" href="{{route('company.list')}}">Εταιρείες</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs('employs') ? 'active' : ''}}" href="{{route('employee.list')}}">Εργαζόμενοι</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs('categories') ? 'active' : ''}}" href="#">Κατηγορίες</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Modal -->
    <div class="modal modal-lg fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3">
        <div class="container">
            &copy; {{ date('Y') }} Demo Project. All rights reserved.
        </div>
    </footer>

    <!-- Example using JavaScript to display flash message -->
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
        @endif
        @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
