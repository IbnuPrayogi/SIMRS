@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css" />
    <script src="https://unpkg.com/cropperjs/dist/cropper.js"></script>
</head>
<body>
    
    <div class="container py-5" style="background-color: blue; border-radius: 25px;">
        
        <div class="container py-6">
            <div class="card-header" style="background-color: blue; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="display: flex; align-items: center;">
                        <span class="font-weight-bold" style="font-size: 30px;">Detail Pengguna</span>
                    </div>                    
                </div>
          </div>
    </div>
    <div class="row py-6">
        <div class="col-lg-12 mx-auto"> 
            <div class="card rounded shadow border-2"> 
                <div class="card-body p-5 bg-white rounded">

    <div class="container light-style flex-grow-1 container-p-y">
        <div class="card overflow-hidden"style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
            <div class="card-header" style="background-color: blue;color:white;text-align:center;border-radius:10px;">
                <h4>Detail Pengguna</h4>
            </div>
            <div class="row no-gutters row-bordered row-border-light" style="justify-content: center">
                <div class="col-md-9">

                    
                        <div class="profile-picture">
                            <img src="{{ asset('assets/profil/'.$user->foto) }}" alt="Logo" style="width:40%" class="rounded-circle">
                        </div>
                        <div class="profile-details">
                            <p><label>Nama           :</label> {{ $user->nama_karyawan }}</p>
                            <p><label>Nama Bagian    :</label> {{ $user->nama_bagian }}</p>
                            <p><label>Jabatan        :</label> {{ $user->jabatan }}</p>
                            <p><label>NIK            :</label> {{ $user->nik }}</p>
                            <p><label>Alamat         :</label> {{ $user->alamat }}</p>
                            <p><label>No Handphone   :</label> {{ $user->nomor_hp }}</p>
                            <p><label>Izin           :</label> {{ $user->jumlah_izin }}</p>
                            <p><label>Cuti           :</label> {{ $user->jumlah_cuti }}</p>
                            <p><label>Tukar Jaga     :</label> {{ $user->jumlah_cuti }}</p>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
       </div></div></div></div>


</body>
</html>


@endsection