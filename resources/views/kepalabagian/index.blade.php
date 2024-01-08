@extends('layouts.appdashboardkabag')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="css/home.css">

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="small-box">
                    <div class="inner" style="text-align: center">
                        <h3>{{ $countUsers }}</h3>
                        <p>Pengguna</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('KBprofile.user') }}" class="small-box-footer">Jumlah Pengguna <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
    
            <div class="col-lg-3 col-12">
                <div class="small-box">
                    <div class="inner" style="text-align: center">
                        <h3>{{ $countSuratMasuk }}</h3>
                        <p>Surat Masuk</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('kbsuratmasuk.index') }}" class="small-box-footer">Jumlah Surat Masuk <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
    
            <div class="col-lg-3 col-12">
                <div class="small-box">
                    <div class="inner" style="text-align: center">
                        <h3>{{ $countSuratKeluar }}</h3>
                        <p>Surat Keluar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('kbsuratkeluar.index') }}" class="small-box-footer">Jumlah Surat Keluar <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    

        <!-- Sisipkan script untuk Chart.js (jika belum ada) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        {{-- <script>
            // Mengambil data dari database (contoh: menggunakan format JSON)
            var suratData = {!! json_encode($suratData) !!};
             var suratDataJson = {!! $suratDataJson !!};

            // alert("The Data: " + suratDataJson);

            // Jika suratData bukan array, Anda perlu menyesuaikan langkah-langkah berikutnya
            if (!Array.isArray(suratData)) {
                console.error("Format data tidak sesuai. Pastikan data yang diterima dari server berupa array.");
            }

            // Lanjutkan dengan memeriksa struktur data dan melakukan langkah-langkah sesuai
            // ...

            // Membuat array untuk label bulan
            var monthLabels = suratData.map(function (data) {
                return data.month;
            });

            // Membuat array untuk data surat masuk
            var suratMasukData = suratData.map(function (data) {
                return data.surat_masuk;
            });

            // Membuat array untuk data surat keluar
            var suratKeluarData = suratData.map(function (data) {
                return data.surat_keluar;
            });

            // Data yang akan ditampilkan pada grafik
            var data = {
                labels: monthLabels,
                datasets: [{
                    label: 'Surat Masuk',
                    backgroundColor: 'rgba(0, 123, 255, 0.7)', // Warna latar belakang
                    borderColor: 'rgba(0, 123, 255, 1)',       // Warna garis tepi
                    borderWidth: 1,
                    data: suratMasukData
                },
                {
                    label: 'Surat Keluar',
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1,
                    data: suratKeluarData
                }]
            };

            // Konfigurasi grafik
            var options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        barPercentage: 0.8,
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 25
                        }
                    }]
                }
            };

            // Membuat grafik
            var ctx = document.getElementById('barChart').getContext('2d');
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        </script> --}}



    </div>
@endsection
