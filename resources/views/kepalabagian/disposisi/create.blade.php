@extends('layouts.appdashboardkabag')

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
                                        <span class="font-weight-bold" style="font-size: 30px;">Teruskan Surat</span>
                                    </div>
                                </div>
                            </div><br>
                                <div class="card">
                                        <div class="card-body">
                                            <div class="modal-body">Apakah anda yakin ingin
                                                Meneruskan Surat?
                                                <span
                                                    class="badge bg-secondary">{{ $surat->nama_surat }}</span>
                                            </div>
                                             
                                               
                                    
                

                                            <form method="POST" action="{{route('kbdisposisi.tambahdisposisi' , ['id'=>$surat->id,'jenis'=> $jenis])}}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('POST')
                                                    <label for="status">Teruskan Ke</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" id="lokasiArsip" name="status" style="background-color: #E0E0E0;">
                                                            <option value="HRD">HRD</option>
                                                            <option value="Kepala Bagian">Kepala Bagian</option>
                                                            <option value="Manajer">Manajer</option>
                                                            <option value="Direktur RS">Direktur RS</option>
                                                            <option value="Direktur PT">Direktur PT</option>
                                                        </select>
                                                    </div>

                                                    <label for="deskripsi" class="col-md-4 col-form-label">Tambahkan Deskripsi / Alasan</label>
                                    
                                                    <div class="col-md-8">
                                                        <input type="textarea" class="form-control" id="deskripsi" placeholder="Deskripsi" style="background-color:#EBF1FA"
                                                        name="deskripsi" 
                                                        placeholder="Deskripsi">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <button type="submit" class="btn btn-primary" style="background-color: #338BFD;color:white">Setujui</button>
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
