@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      canvas {
        max-width: 100%;
        margin: 20px 0;
      }
    </style>

    @php
        
    @endphp


    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>{{ $jumlahAdmin }}</h3>
                        <p>Admin</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('user.index') }}" class="small-box-footer">Jumlah Admin <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>{{ $jumlahUser }}</h3>
                        <p>Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('arsip.index') }}" class="small-box-footer">Jumlah Karyawan <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>{{ $jumlahShift }}</h3>
                        <p>Shift</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('suratkeluar.index') }}" class="small-box-footer">Jumlah Shift <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>{{ $jumlahShift }}</h3>
                        <p>Telat</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('suratmasuk.index') }}" class="small-box-footer">Jumlah Telat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- {{-- <div class="container"> --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #0051B9;color:white">
                            <h4 class="card-title">Telat Hari Ini</h4>
                        </div>
                        <div class="card rounded shadow border-2">
                            <div class="card-body p-9 bg-white rounded">
                        <div class="table-responsive">
                            <table id="example" style="width: 100%"
                                class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                       
                                        <th>Nama</th>
                                        <th>Bagian</th>
                                        <th>Shift</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTerlambat as $terlambat)
                                    <tr>
                                        @php
                                            $shift= \App\Models\Shift::where('id',$terlambat->shift_id)->first();
                                            $user=\App\Models\User::where('nama_karyawan',$terlambat->nama_karyawan)->first();
                                        @endphp
                                     
                                        <td>{{ $terlambat->nama_karyawan }}</td>
                                        <td>{{ $user->nama_bagian }}</td>
                                        <td>{{ $shift->nama_shift }}</td>
                                        <td>{{ $terlambat->waktu_terlambat }}</td>
                                    </tr>
                                        
                                    @endforeach
                                        
                                </tbody>
                            </table>
                        </div>  
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #0051B9;color:white">
                            <h4 class="card-title">Karyawan Sesuai Shift</h4>
                        </div>
                        <div style="text-align: center;">
                            <!-- Tambahkan elemen canvas sebagai tempat diagram batang -->
                            <canvas id="barChart"></canvas>
                          </div>
                        
                          <script>
                            // Data untuk diagram batang
                            var dynamicData = @json($dynamicsData);
                            var data = {
                              labels: ["Pagi", "Sore", "Malam", "Pagi/Sore", "Pagi/Malam"],
                              datasets: [{
                                label: 'Shift Karyawan',
                                data: dynamicData, // Tinggi untuk setiap kategori
                                backgroundColor: [
                                  'rgba(255, 99, 132, 0.7)',
                                  'rgba(54, 162, 235, 0.7)',
                                  'rgba(255, 206, 86, 0.7)',
                                  'rgba(75, 192, 192, 0.7)',
                                  'rgba(153, 102, 255, 0.7)',
                                ],
                                borderColor: [
                                  'rgba(255, 99, 132, 1)',
                                  'rgba(54, 162, 235, 1)',
                                  'rgba(255, 206, 86, 1)',
                                  'rgba(75, 192, 192, 1)',
                                  'rgba(153, 102, 255, 1)',
                                ],
                                borderWidth: 1
                              }]
                            };
                        
                            // Konfigurasi untuk diagram batang
                            var options = {
                              scales: {
                                y: {
                                  beginAtZero: true
                                }
                              }
                            };
                        
                            // Mengambil elemen canvas
                            var ctx = document.getElementById('barChart').getContext('2d');
                        
                            // Membuat objek diagram batang
                            var barChart = new Chart(ctx, {
                              type: 'bar',
                              data: data,
                              options: options
                            });
                          </script>
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
