@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="css/daftarpermohonanizin.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>

    <div class="container py-5" style="background-color: blue; border-radius: 25px;">

        <div class="container py-6">
            <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="font-weight-bold" style="font-size: 30px;">Daftar Permohonan</span>
                    </div>
                </div><br>
            <div class="row py-6">
                <div class="col-lg-12 mx-auto">
                    <div class="card rounded shadow border-2">
                        <div class="card-body p-5 bg-white rounded">
                          <div class="button-container">
                            <select id="menuDropdown" style="background-color: #EBF1FA">
                                <option value="suratMasuk">Surat Masuk</option>
                                <option value="suratKeluar">Surat Keluar</option>
                                <option value="izin">Izin</option>
                                <option value="cuti">Cuti</option>
                                <option value="tukarJaga">Tukar Jaga</option>
                            </select>
                        </div>
                              <br><br>
                            <div class="table-responsive">
                                <table id="example" style="width: 100%" class="table table-striped table-bordered">

                        <thead>
                          <tr>
                            <th>Nama Pengaju</th>
                            <th>Waktu</th>
                            <th>Durasi</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
                          <tr>
                            <td>Agus</td>
                            <td>Oktober</td>
                            <td>1 Minggu</td>
                            <td>Melahirkan</td>
                            <td>ditandatangani</td>
                            <td><button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              <button class="btn btn-success"><i class="fas fa-download"></i></button></td>
                          </tr>
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
<script src="js/daftarpermohonanizin.js"></script>
</body>
</html>


@endsection
