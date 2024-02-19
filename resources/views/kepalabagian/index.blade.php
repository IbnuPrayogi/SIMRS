@extends('layouts.appdashboardkabag')

@section('content')
    <link rel="stylesheet" href="css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      canvas {
        max-width: 100%;
        margin: 20px 0;
      }
    </style>


    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>{{ $jumlahKaryawan }}</h3>
                        <p>Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('user.index') }}" class="small-box-footer">Jumlah Karyawan<i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>{{ $jumlahCuti }}</h3>
                        <p>Cuti</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('DaftarPermohonan.indexCuti') }}" class="small-box-footer">Jumlah Cuti <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>{{ $jumlahIzin }}</h3>
                        <p>Izin</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('DaftarPermohonan.indexCuti') }}" class="small-box-footer">Jumlah Izin <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h3>1</h3>
                        <p>{{ $jumlahTukarJaga }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('DaftarPermohonan.indexTukarJaga') }}" class="small-box-footer">Jumlah Tukar Jaga <i class="fas fa-arrow-circle-right"></i></a>
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
                        <div class="card-body">
                            <table class="table" >
                                <thead style="background-color: #0051B9;color:white"">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Bagian</th>
                                        <th>Shift</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>1</td>
                                            <td>Agus</td>
                                            <td>Dokter</td>
                                            <td>Pagi</td>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button class="btn" style="background-color: rgb(33, 0, 219);color:aliceblue;">&#8594;</button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #0051B9;color:white">
                            <h4 class="card-title">Karyawan Cuti/Izin</h4>
                        </div>
                        <div style="text-align: center;">
                            <!-- Tambahkan elemen canvas sebagai tempat diagram batang -->
                            <canvas id="barChart"></canvas>
                          </div>
                        
                          <script>
                            // Data untuk diagram batang
                            var dynamicData = @json($dynamicsData);
                            var data = {
                              labels: ["Cuti", "Izin"],
                              datasets: [{
                                label: 'Karyawan',
                                data: dynamicData, // Tinggi untuk setiap kategori
                                backgroundColor: [
                                  'rgba(255, 99, 132, 0.7)',
                                  'rgba(54, 162, 235, 0.7)',
                                ],
                                borderColor: [
                                  'rgba(255, 99, 132, 1)',
                                  'rgba(54, 162, 235, 1)',
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


        
    </div>
@endsection
