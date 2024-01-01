@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/buatsurattemplate.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container py-5" style="background-color: blue; border-radius: 25px;">
    <div class="container py-6">
        <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="font-weight-bold" style="font-size: 30px;">Buat Surat</span>
                </div>
            </div>
        </div><br>

        <div class="row py-6">
            <div class="col-lg-12 mx-auto">
                <div class="card rounded shadow border-2">
                    <div class="card-body p-5 bg-white rounded">
                        <div class="button-container">
                            <div class="button" id="template">Gunakan Template</div>
                            <div class="button" id="upload">Upload <br> Surat</div>
                          </div>
                        
                          <script>
                            // JavaScript untuk mengubah warna tombol saat diklik
                            const templateButton = document.getElementById('template');
                            const uploadButton = document.getElementById('upload');
                        
                            templateButton.addEventListener('click', () => {
                                templateButton.classList.add('active-button');
                                uploadButton.classList.remove('active-button');
                            });
                        
                            uploadButton.addEventListener('click', () => {
                                uploadButton.classList.add('active-button');
                              templateButton.classList.remove('active-button');
                            });
                          </script>

                        <div class="row">
                            <div class="col-md-3" >
                                <div class="card">
                                    <div class="card-header" style="background-color: #0051B9; color: white;">
                                        <p class="card-title" style="text-align: center">Tujuan Surat</p>
                                    </div>
                                    <div class="card-body">
                                        <button>Luar Instansi</button>
                                        <button>Karyawan</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group row">
                                                <label for="kategoriSurat" class="col-md-4 col-form-label">Kategori Surat</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="kategoriSurat" name="kategoriSurat" style="background-color:#EBF1FA">
                                                        <option value="option1">Pilih Kategori</option>
                                                        <option value="option2">Kategori 1</option>
                                                        <option value="option3">Kategori 2</option>
                                                        <option value="option4">Kategori 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="namaSurat" class="col-md-4 col-form-label">Nama Surat</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="namaSurat" placeholder="Nama Surat" style="background-color:#EBF1FA">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kodeSurat" class="col-md-4 col-form-label">Kode Surat</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="kodeSurat" placeholder="Tode Surat" style="background-color:#EBF1FA">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tujuanSurat" class="col-md-4 col-form-label">Tujuan Surat</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="tujuanSurat" placeholder="Tujuan Surat" style="background-color:#EBF1FA">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="perihalSurat" class="col-md-4 col-form-label">Perihal Surat</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="perihalSurat" placeholder="Perihal Surat" style="background-color:#EBF1FA">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sisipkan script untuk jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</body>
</html>
@endsection
