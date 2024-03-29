@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/perubahansuratmasuk.css">
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
                                        <span class="font-weight-bold" style="font-size: 30px;">Perubahan Surat Masuk</span>
                                    </div> 
                                </div>
                            </div><br>
                                <div class="card">
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('suratmasuk.update',$surat->id) }}" enctype="multipart/form-data"> 
                                                @csrf
                                                @method('PUT')  
                                                <div class="form-group row">
                                                    <label for="namaSurat" class="col-md-4 col-form-label">Nama Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="namaSurat" name="nama_surat" placeholder="{{ $surat->nama_surat }}" value="{{ $surat->nama_surat }}" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kategoriSurat" class="col-md-4 col-form-label">Kategori</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="{{ $surat->kategori }}" value="{{ $surat->kategori }}" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="perihal" class="col-md-4 col-form-label">Perihal</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="perihal" name="perihal" placeholder="{{ $surat->perihal }}" value="{{ $surat->perihal }}" style="background-color:#EBF1FA">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggal" class="col-md-4 col-form-label">Tanggal</label>
                                                    <div class="col-md-8">
                                                        <input type="date" class="form-control" id="tanggal" placeholder="{{ $surat->tanggal_dibuat }}" value="{{ $surat->tanggal_dibuat }}" name="tanggal_dibuat" style="background-color: #E0E0E0;">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="asalSurat" class="col-md-4 col-form-label">Asal Surat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="asalSurat" name="asal_surat" placeholder="{{ $surat->asal_surat }}" value="{{ $surat->asal_surat }}" style="background-color:#EBF1FA">
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

</body>
</html>
@endsection