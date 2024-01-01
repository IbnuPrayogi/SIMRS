@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="css/kelolasuratkeluar.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>

    <div class="container py-5" style="background-color: blue; border-radius: 25px;">

        <div class="container py-6">
            <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="font-weight-bold" style="font-size: 30px;">Kelola Surat</span>
                    </div>
                    <div>
                        <button class="btn btn-primary" style="font-size: 15px;border-radius:20px;">Tambah Surat Baru</button>
                    </div>
                </div>
                <br>
            <div class="row py-6">
                <div class="col-lg-12 mx-auto">
                    <div class="card rounded shadow border-2">
                        <div class="card-body p-5 bg-white rounded">
                            <div class="button-container">
                                <div class="button" id="suratMasuk">Surat Masuk</div>
                                <div class="button" id="suratKeluar">Surat Keluar</div>
                              </div>

                              <script>
                                // JavaScript untuk mengubah warna tombol saat diklik
                                const suratMasukButton = document.getElementById('suratMasuk');
                                const suratKeluarButton = document.getElementById('suratKeluar');

                                suratMasukButton.addEventListener('click', () => {
                                  suratMasukButton.classList.add('active-button');
                                  suratKeluarButton.classList.remove('active-button');
                                });

                                suratKeluarButton.addEventListener('click', () => {
                                  suratKeluarButton.classList.add('active-button');
                                  suratMasukButton.classList.remove('active-button');
                                });
                              </script>

                              <br><br>
                            <div class="table-responsive">
                                <table id="example" style="width: 100%" class="table table-striped table-bordered">

                        <thead>
                          <tr>
                            <th>Nama Surat</th>
                            <th>Kategori</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th>Tanggal dibuat</th>
                            <th>Kode Surat</th>
                            <th>Tujuan</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($suratkeluar as $suratkeluarr) --}}
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>karyawan</td>
                                <td>Ditandatangani</td>
                                <td>2011/04/25</td>
                                <td>25</td>
                                <td>Arab Saudi</td>
                                <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                              </tr>
                            {{-- @endforeach --}}
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>

<!-- Sisipkan script untuk jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Sisipkan script untuk DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Sisipkan script untuk file JavaScript Anda -->
<script src="js/kelolasuratkeluar.js"></script>
</body>
</html>


@endsection
