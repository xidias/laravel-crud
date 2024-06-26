<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-secondary-subtle shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if ($loggedInUser)
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('company.list') ? 'active' : ''}}" href="{{route('company.list')}}">Εταιρείες</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('employee.list') ? 'active' : ''}}" href="{{route('employee.list')}}">Εργαζόμενοι</a>
                            </li>
                            @if ($loggedInUser->role=='admin')                                
                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('category.list') ? 'active' : ''}}" href="{{route('category.list')}}">Κατηγορίες</a>
                                </li>
                            @endif
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        <li class="nav-item dropdown">
                            <a id="change-theme" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @include('components.svg', ['name' => 'circle-half'])
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="change-theme">
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-theme-value="light">
                                    <span>@include('components.svg', ['name' => 'sun-fill'])</span> &emsp;Light
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-theme-value="dark">
                                    <span>@include('components.svg', ['name' => 'moon-stars-fill'])</span> &emsp;Dark
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-theme-value="auto">
                                    <span>@include('components.svg', ['name' => 'circle-half'])</span> &emsp;Auto
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Modal -->
    <div class="modal modal-lg fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-secondary-subtle text-center py-3">
        <div class="container">
            &copy; {{ date('Y') }} Demo Project. All rights reserved.
        </div>
    </footer>

    <!-- Example using JavaScript to display flash message -->
{{--      @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
        @endif
        @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif --}}
    <!-- Toast Container -->
    {{-- <div id="toastContainer" class="toast-container"></div> --}}


    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
{{--         <div class="toast-header">
          <img src="..." class="rounded me-2" alt="...">
          <strong class="me-auto">Bootstrap</strong>
          <small>11 mins ago</small>
          <span  class="me-auto">&nbsp;</span>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div> --}}
        <div class="toast-body">
        </div>
      </div>
    </div>

    @if (session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastContainer = document.querySelector('.toast-container');
            var liveToast = document.getElementById('liveToast');
            //var toastHeader = liveToast.querySelector('.toast-header');
            var toastBody = liveToast.querySelector('.toast-body');

            var messageType = @json(session('success') ? 'success' : 'danger');
            var messageText = @json(session('success') ?? session('error'));

            var toast = new bootstrap.Toast(liveToast);
console.log(messageText);
            toastBody.textContent = messageText;
            liveToast.classList.add('bg-' + messageType); // Apply background color based on message type

            toast.show();

            // Hide the toast after a few seconds (optional)
            setTimeout(function () {
                toast.hide();
            }, 5000); // Adjust the delay time as needed (in milliseconds)
        });
    </script>
@endif

</body>
</html>
