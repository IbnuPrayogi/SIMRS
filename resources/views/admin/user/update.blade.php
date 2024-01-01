@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="css/arsip.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    
    <div class="container py-5" style="background-color: blue; border-radius: 25px;">
        
        <div class="container py-6">
            <div class="card-header" style="background-color: blue; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="display: flex; align-items: center;">
                        <span class="font-weight-bold" style="font-size: 30px;">Kelola Pengguna >></span>
                        <span class="font" style="font-size: 20px;">Edit Pengguna</span>
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
                <h4>Edit Pengguna</h4>
            </div>
            <div class="row no-gutters row-bordered row-border-light" style="justify-content: center">
                <div class="col-md-9">
                    <form action="{{ route('user.update',$user->id) }}" method="post" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="img/profil.jpeg" style="width:20%" class="rounded-circle">
                                <div class="media-body ml-4">
                                    <label for="foto" >Upload Foto</label>
                                    <img id="image-preview" src="#" alt="Preview" style="display:none; max-width: 200px; margin-top: 10px;">
                                    <input name="foto" class="btn btn-outline-primary" title="Upload Foto" type="file" id="photo" onchange="previewImage(event)" accept="image/*" value="{{ $user->foto }}" placeholder="{{ $user->foto }}" >
    
                                
                                </div>
                            </div>
                            <hr class="border-light m-0">
            
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Nama Pengguna</label>
                                    <input type="text" class="form-control mb-1" placeholder="Nama Pengguna" name="nama_karyawan" style="background-color: #CCD9EC" value="{{ $user->nama_karyawan }}" placeholder="{{ $user->nama_karyawan }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control mb-1" placeholder="NIK" name="nik" style="background-color: #CCD9EC" value="{{ $user->nik }}" placeholder="{{ $user->nik }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" class="form-control" placeholder="Alamat" name="alamat" style="background-color: #CCD9EC" value="{{ $user->alamat }}" placeholder="{{ $user->alamat }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nomor Hp</label>
                                    <input type="text" class="form-control" placeholder="Nomor Hp" name="nomor_hp" style="background-color: #CCD9EC" value="{{ $user->nomor_hp }}" placeholder="{{ $user->nomor_hp }}" required>
                                </div>
                                <div class="form-container" style="display: flex;justify-content: space-between;">
                             
                                    <div class="form-group">
                                        <label for="lang1">Nama Bagian</label>
                                        <select  id="lang1" class="form-control" name="nama_bagian" style="background-color: #CCD9EC">
                                            <option value="Dokter">Dokter</option>
                                            <option value="Perawat">Perawat</option>
                                            <option value="IT">IT</option>
                                            <option value="Keamanan">Keamanan</option>
                                            <option value="Teknisi">Teknisi</option>
                                            <!-- Opsi lainnya -->
                                        </select>
                                    </div>
                               
                      
                                    <div class="form-group">
                                        <label for="lang2">Jabatan</label>
                                        <select  id="lang2" name="jabatan" class="form-control" style="background-color: #CCD9EC">
                                            <option value="Direktur">Direktur</option>
                                            <option value="Manajer">Manajer</option>
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
                                        <select  id="lang1" name="role" class="form-control" style="background-color: #CCD9EC">
                                            <option value=1>Kepala Bagian</option>
                                            <option value=2>Admin / HRD</option>
                                            <option value=3>Karyawan / Staff</option>
                                            <!-- Opsi lainnya -->
                                        </select>
                                    </div>
                            
                            
                        
                                    <div class="form-group">
                                        <label for="tanda_tangan">Tanda Tangan</label>
                                        <img id="ttd-preview" src="#" alt="Preview" style="display:none; max-width: 200px; margin-top: 10px;">
                                        <input name="tanda_tangan" class="btn btn-outline-primary" title="Upload Tanda Tangan" type="file" id="tanda_tangan" onchange="previewTTD(event)" accept="image/*">

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
