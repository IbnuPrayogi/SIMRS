@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/create.css') }}">
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
                        <span class="font-weight-bold" style="font-size: 30px;">Kelola Pengguna >></span>
                        <span class="font" style="font-size: 20px;">Tambah Pengguna</span>
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
                <h4>Tambah Pengguna</h4>
            </div>
            <div class="row no-gutters row-bordered row-border-light" style="justify-content: center">
                <div class="col-md-9">
                    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    @method('POST')
                    <div class="tab-pane fade active show" id="account-general">
                        <div class="card-body media align-items-center">
                            <img src="{{ asset('assets/profil/imhim-low-resolution-logo-black-on-white-background.png') }}" alt="Logo" style="width:20%" class="rounded-circle">
                            <div class="media-body ml-4">
                                <label for="foto" >Upload Foto</label>
                                <img id="image-preview" src="#" alt="Preview" style="display:none; max-width: 200px; margin-top: 10px;">
                                <input name="foto" class="btn btn-outline-primary" title="Upload Foto" type="file" id="photo" onchange="previewImage(event)" accept="image/*">
                            </div>
                        </div>
                        <hr class="border-light m-0">
        
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control mb-1" placeholder="Nama Pengguna" name="nama_karyawan" style="background-color: #CCD9EC" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control mb-1" placeholder="NIK" name="nik" style="background-color: #CCD9EC" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password" style="background-color: #CCD9EC" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" placeholder="Alamat" name="alamat" style="background-color: #CCD9EC">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor Hp</label>
                                <input type="text" class="form-control" placeholder="Nomor Hp" name="nomor_hp" style="background-color: #CCD9EC">
                            </div>
                            <div class="form-container" style="display: flex;justify-content: space-between;">
                             
                                    <div class="form-group">
                                        <label for="lang1">Nama Bagian</label>
                                        <select  id="lang1" class="form-control" name="nama_bagian" style="background-color: #CCD9EC" required>
                                            @foreach ($bagians as $bagian)
                                             <option value="{{ $bagian->nama_bagian }}">{{ $bagian->nama_bagian }}</option>  
                                            @endforeach
                                         
                                            <!-- Opsi lainnya -->
                                        </select>
                                    </div>
                               
                      
                                    <div class="form-group">
                                        <label for="lang2">Jabatan</label>
                                        <select  id="lang2" name="jabatan" class="form-control" style="background-color: #CCD9EC" required>
                                            <option value="Direktur">Direktur</option>
                                            <option value="Kepala Ruangan">Kepala Ruangan</option>
                                            <option value="Kepala Bagian">Kepala Bagian</option>
                                            <option value="HRD">HRD</option>
                                            <option value="Staff">Staff</option>
                                            <!-- Opsi lainnya -->
                                        </select>
                                    </div>
                             
                            </div>
                            
                            <div class="form-container" style="display: flex; justify-content: space-between;">
                         
                                    <div class="form-group">
                                        <label for="lang1">Roles</label>
                                        <select  id="lang1" name="role" class="form-control" style="background-color: #CCD9EC" required>
                                            <option value=2>Kepala Bagian</option>
                                            <option value=1>Admin / HRD</option>
                                            <option value=3>Karyawan / Staff</option>
                                            <!-- Opsi lainnya -->
                                        </select>
                                    </div>
                            
                            
                        
                              
                            </div>
                            
                        </div>
                    </div>
                    <div class="text-center mt-3" >
                        <button type="button" class="btn btn-outline-secondary">Cancel</button>
                        <button type="submit" class="btn btn-default" style="background-color: blue;color:white">Save</button>
                    </div>
                    <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
       </div></div></div></div>

       <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
    
            reader.onload = function () {
                var output = document.getElementById('image-preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
    
            reader.readAsDataURL(input.files[0]);
        }
    </script>
           <script>
            function previewTTD(event) {
                var input = event.target;
                var reader = new FileReader();
        
                reader.onload = function () {
                    var output = document.getElementById('ttd-preview');
                    output.src = reader.result;
                    output.style.display = 'block';
                };
        
                reader.readAsDataURL(input.files[0]);
            }
        </script>
</body>
</html>


@endsection
