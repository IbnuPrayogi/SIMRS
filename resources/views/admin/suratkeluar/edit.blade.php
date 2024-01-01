@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/buatsuratkeluar.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-5" style="background-color: blue; border-radius: 25px;">
                        <div class="container py-6">
                            <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div style="display: flex; align-items: center;">
                                        <a href="{{route('suratkeluar.index')}}" style="text-decoration: none; margin-right: 10px;color:white">
                                            <i class="fa-sharp fa-solid fa-arrow-left" style="font-size: 30px;"></i>
                                        </a>
                                        <span class="font-weight-bold" style="font-size: 30px;">Edit Surat Keluar</span>
                                    </div>
                                </div>
                            </div><br>
                                <div class="card">
                                        <div class="card-body">
                                            <form method="POST" action="{{route('suratkeluar.update' , $suratkeluarr->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group row">
                                                    <label for="namaSurat" class="col-md-4 col-form-label">Nama Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="namaSurat" style="background-color:#EBF1FA"
                                                        name="nama_surat" value="{{$suratkeluarr->nama_surat}}"
                                                        placeholder="{{ $suratkeluarr->nama_surat }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kategoriSurat" class="col-md-4 col-form-label">Kategori</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="kategori" style="background-color:#EBF1FA"
                                                        name="kategori_surat" value="{{$suratkeluarr->kategori_surat }}"
                                                        placeholder="{{ $suratkeluarr->kategori_surat }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggal" class="col-md-4 col-form-label">Tanggal Dibuat </label>
                                                    <div class="col-md-8">
                                                        <input type="date" class="form-control" id="tanggal"style="background-color: #E0E0E0;"
                                                        name="tanggal_dibuat" value="{{$suratkeluarr->tanggal_dibuat}}"
                                                        placeholder="{{$suratkeluarr->tanggal_dibuat}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggal" class="col-md-4 col-form-label">Jenis Surat </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="tanggal" style="background-color: #E0E0E0;"
                                                        name="jenis_surat" value="{{$suratkeluarr->jenis_surat}}"
                                                        placeholder="{{$suratkeluarr->jenis_surat}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tujuanSurat" class="col-md-4 col-form-label">Tujuan Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="tujuanSurat" placeholder="Tujuan Surat" style="background-color:#EBF1FA"
                                                        name="tujuan_surat" value="{{ $suratkeluarr->tujuan_surat }}"
                                                        placeholder="{{$suratkeluarr->tujuan_surat }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kodeSurat" class="col-md-4 col-form-label">Kode Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="kodeSurat" placeholder="Kode Surat" style="background-color:#EBF1FA"
                                                        name="kode_surat" value="{{ $suratkeluarr->kode_surat }}"
                                                        placeholder="{{ $suratkeluarr->kode_surat }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row" hidden>
                                                    <label for="nomorSurat" class="col-md-4 col-form-label">status</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="nomorSurat" placeholder="Nomor Surat" style="background-color:#EBF1FA"
                                                        name="status" value="{{ $suratkeluarr->status }}"
                                                        placeholder="{{ $suratkeluarr->status }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nomorSurat" class="col-md-4 col-form-label">Jenis Surat</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" id="lokasiArsip" name="jenis_surat" style="background-color: #E0E0E0;">
                                                            <option value="" disabled selected>{{$suratkeluarr->jenis_surat}}</option>
                                                            <option value="Karyawan" {{$suratkeluarr->jenis_surat == 'karyawan' ? 'selected' : ''}}>Karyawan</option>
                                                            <option value="LuarInstansi" {{$suratkeluarr->jenis_surat == 'LuarInstansi' ? 'selected' : ''}}>Luar Instansi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-8">
                                                        <button type="submit" class="btn btn-default"
                                            style="background-color: blue;color:white">Submit</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>




    </div>

<!-- Sisipkan script untuk jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Sisipkan script untuk DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Sisipkan script untuk file JavaScript Anda -->
<script src="js/kelolasuratkeluar.js"></script>

</body>
</html>
@endsection
