@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="css/tambaharsip.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>
    
    <div class="container py-5" style="background-color: blue; border-radius: 25px;">
        
        <div class="container py-6">
            <div class="card-header" style="background-color: blue; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="display: flex; align-items: center;">
                        <a href="#" style="text-decoration: none; margin-right: 10px;color:white">
                            <i class="fa-sharp fa-solid fa-arrow-left" style="font-size: 30px;"></i>
                        </a>
                        <span class="font-weight-bold" style="font-size: 30px;">Tambah Arsip</span>
                    </div>                                        
                </div>
          </div>
    </div>
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="namaArsip" class="col-md-4 col-form-label">Nama Arsip</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="namaArsip" placeholder="Nama Arsip" style="background-color: #E0E0E0;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kodeArsip" class="col-md-4 col-form-label">Kode Arsip</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="kodeArsip" placeholder="Kode Arsip" style="background-color: #E0E0E0;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="perihal" class="col-md-4 col-form-label">Perihal</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="perihal" placeholder="Perihal" style="background-color: #E0E0E0;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggalSelesai" class="col-md-4 col-form-label">Tanggal Selesai</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai" style="background-color: #E0E0E0;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lokasiArsip" class="col-md-4 col-form-label">Lokasi Arsip</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="lokasiArsip" name="lokasiArsip" style="background-color: #E0E0E0;">
                                        <option value="Lemari">Lemari</option>
                                        <option value="Rak">Rak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kategori" class="col-md-4 col-form-label">Kategori</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="kategori" name="kategori" style="background-color: #E0E0E0;">
                                        <option value="Perizinan">Perizinan</option>
                                        <option value="SIP">SIP (Surat Izin Praktik)</option>
                                        <option value="STR">STR (Surat Tanda Regist)</option>
                                        <option value="PKWT">PKWT</option>
                                        <option value="MoU Spesialis">MoU Spesialis</option>
                                        <option value="Kontrak Part Time">Kontrak Part Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="uploadfile" class="col-md-4 col-form-label">Upload File</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control" id="uploadFile" name="uploadFile" style="background-color: #E0E0E0;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color: #00adf1;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

    </div>
</body>
</html>


@endsection
