<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="/css/arsip.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/previewsurat.css') }}">
    <link rel="stylesheet" href="/css/tambaharsip.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <!-- Sisipkan script untuk jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Sisipkan script untuk DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Sisipkan script untuk file JavaScript Anda -->
    <script src="js/arsip.js"></script>
</head>

<body>
    <div id="app">
        <div class="content">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

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
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span class="navbar-toggler-icon"></span>
                                    {{ Auth::user()->name }}
                                 </a>
                                 
                                    
                                    <div class="dropdown-menu">
                                            <div class="menu-box">
                                                <ul class="menu">
                                                    <li><a href="/home"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                                    <li><a href="{{ route('KBprofile.user') }}"><i class="fas fa-user"></i> Profile</a></li>
                                                    <li><a href="{{ route('kbsuratkeluar.index') }}"><i class="fas fa-envelope"></i> Surat Keluar</a></li>
                                                    <li><a href="{{ route('kbsuratmasuk.index') }}"><i class="fas fa-envelope-open"></i> Surat Masuk</a></li>
                                                    <li><a href="{{ route('DaftarPermohonan.indexCuti') }}"><i class="fas fa-bed"></i> Cuti</a></li>
                                                    <li><a href="{{ route('DaftarPermohonan.indexIzin') }}"><i class="fas fa-clock"></i> Izin</a></li>
                                                    <li><a href="{{ route('DaftarPermohonan.indexTukarJaga') }}"><i class="fas fa-exchange-alt"></i> Tukar Jaga</a></li>
                                                    </li>
                                                </ul>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>
                                                {{ __('Logout') }}
                                                </a>
    
                                                 <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                </form>
                                            </div>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
