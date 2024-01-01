<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'dashboard') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../css/dashboardmobile.css">
    {{-- <link rel="stylesheet" href="css/cutimobile.css"> --}}

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

</head>

<body
    style="background-image: url('{{ asset('img/bg-mobile.png') }}');
             background-size: cover;
             background-position: center;
             background-repeat: no-repeat;">
    <div id="app">
        <div class="upbar">
            <div class="logo_aplikasi">
                <img src="../img/logo.png" alt="logo" style="width:100%; height:100%;" />
            </div>
            <div class="atur_jarak">
                <p>Perizinan</p>
            </div>
            <div class="icon-belt">
                <a href="/permintaantukarjaga"><i class='bx bxs-bell'></i></a>
            </div>
            <div class="elips">
                <a href="/profile"><img src="{{ asset('assets/profil/'.auth()->user()->foto )}}" alt="logo_user"></a>
            </div>
            <div class="dropdown">
                <div class="menu">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="dropdown-content">
                    <div class="notif_text">
                        <h1>Permohonan <b>Tukar Jaga dengan Ningguang</b> telah disetujui</h1>
                    </div>
                    <div class="line"></div>
                    <div class="icon-exit">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                        class="d-none">
                        @csrf
                            <button type="submit" class="submit">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <h1>Keluar</h1>
                            </button>
                       </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar-content">
            <div class="navbar">
                <a href="/home" class="{{ Request::is('/home') ? 'active' : '' }}"><i class='bx bx-home'></i></a>
                <a href="/status" class="{{ Request::is('/status') ? 'active' : '' }}"><i class="fa-solid fa-list-check"></i></a>
                <a href="/profile" class="{{ Request::is('/profile') ? 'active' : '' }}"><i class='bx bxs-user' ></i></a>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
        
    </div>

    <script>
        // Mengambil elemen tombol dropdown
        var dropdownButton = document.querySelector(".menu i");

        // Mengambil elemen isi dropdown
        var dropdownContent = document.querySelector(".dropdown-content");

        // Menambahkan event listener untuk tombol dropdown
        dropdownButton.addEventListener("click", function() {
            // Memeriksa apakah isi dropdown sedang ditampilkan atau tidak
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none"; // Jika ditampilkan, sembunyikan
            } else {
                dropdownContent.style.display = "block"; // Jika tidak ditampilkan, tampilkan
            }
        });
    </script>
</body>

</html>
