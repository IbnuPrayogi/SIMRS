@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (session('successdelete'))
    <div class="alert alert-success">
        {{ session('successdelete') }}
    </div>
    @endif
    <section>
        <body>
            <div class="container py-5" style="background-color: blue; border-radius: 25px;">
                <div class="container py-6">
                    <div class="card-header" style="background-color: blue; color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="display: flex; align-items: center;">
                                <a href="/arsip" style="text-decoration: none; margin-right: 10px;color:white">
                                    <i class="fa-sharp fa-solid fa-arrow-left" style="font-size: 30px;"></i>
                                </a>
                                <span class="font-weight-bold" style="font-size: 30px;">{{ $title }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <section>
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form  method="post" action="{{ route('arsip.store') }}"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="namaArsip" class="col-md-4 col-form-label">Nama Arsip</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="namaArsip"
                                                        placeholder="Nama Arsip" style="background-color: #E0E0E0;" name="nama_arsip">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kodeArsip" class="col-md-4 col-form-label">Kode Arsip</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="kodeArsip"
                                                        placeholder="Kode Arsip" style="background-color: #E0E0E0;" name="kode_arsip">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="perihal" class="col-md-4 col-form-label">Perihal</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="perihal"
                                                        placeholder="Perihal" style="background-color: #E0E0E0;" name="perihal">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display: none;">
                                                <label for="tanggalSelesai" class="col-md-4 col-form-label">Tanggal dibuat</label>
                                                <div class="col-md-8">
                                                    <input type="date" class="form-control" id="tanggal_selesai"
                                                         style="background-color: #E0E0E0;" name="tanggal_terbit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tanggalSelesai" class="col-md-4 col-form-label">Tanggal
                                                    Selesai</label>
                                                <div class="col-md-8">
                                                    <input type="date" class="form-control" id="tanggal_selesai"
                                                         style="background-color: #E0E0E0;" name="tanggal_selesai">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="lokasiArsip" class="col-md-4 col-form-label">Lokasi
                                                    Arsip</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="lokasi_arsip" name="lokasi_arsip"
                                                        style="background-color: #E0E0E0;">
                                                        <option value="Lemari">Lemari</option>
                                                        <option value="Rak">Rak</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kategori" class="col-md-4 col-form-label">Kategori</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="kategori" name="kategori"
                                                        style="background-color: #E0E0E0;">
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
                                                    <input type="file" class="form-control" id="file"
                                                        name="file" style="background-color: #E0E0E0;" required 
                                                        accept=".pdf">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-default"
                                            style="background-color: blue;color:white">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </body>
    </section>
@endsection
