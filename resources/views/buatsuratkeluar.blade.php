@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/buatsuratkeluar.css">
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
                                        <a href="#" style="text-decoration: none; margin-right: 10px;color:white">
                                            <i class="fa-sharp fa-solid fa-arrow-left" style="font-size: 30px;"></i>
                                        </a>
                                        <span class="font-weight-bold" style="font-size: 30px;">Buat Surat Keluar</span>
                                    </div> 
                                </div>
                            </div><br>
                                <div class="card">
                                        <div class="card-body">
                                            <form>   
                                                <div class="form-group row">
                                                    <label for="namaSurat" class="col-md-4 col-form-label">Nama Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="namaSurat" placeholder="Nama Surat" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kategoriSurat" class="col-md-4 col-form-label">Kategori</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="kategori" placeholder="Kategori" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="perihal" class="col-md-4 col-form-label">Perihal</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="perihal" placeholder="Perihal" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggal" class="col-md-4 col-form-label">Tanggal</label>
                                                    <div class="col-md-8">
                                                        <input type="date" class="form-control" id="tanggal" name="tanggal" style="background-color: #E0E0E0;">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tujuanSurat" class="col-md-4 col-form-label">Tujuan Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="tujuanSurat" placeholder="Tujuan Surat" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kodeSurat" class="col-md-4 col-form-label">Kode Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="kodeSurat" placeholder="Kode Surat" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nomorSurat" class="col-md-4 col-form-label">Nomor Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="nomorSurat" placeholder="Nomor Surat" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jenisPengguna" class="col-md-4 col-form-label">Jenis Pengguna</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" id="jenisPengguna" name="lokasiArsip" style="background-color: #E0E0E0;">
                                                            <option value="LuarInstansi">Luar Instansi</option>
                                                            <option value="Karyawan">Karyawan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="uploadSurat" class="col-md-4 col-form-label">Upload Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" id="uploadSurat" name="uploadSurat" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-8">
                                                        <button type="submit" class="btn btn-primary" style="background-color: #338BFD;color:white">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            
                
            
        
    </div>


<!-- Sisipkan script untuk jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</body>
</html>
@endsection
