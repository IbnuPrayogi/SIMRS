@extends('layouts.app')

@section('content')

    <body>

        <div class="container py-5" style="background-color: blue; border-radius: 25px;">
            <section>
                <div class="container py-6">
                    <div class="card-header" style="background-color: blue; color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="display: flex; align-items: center;">
                                <a href="/arsip" style="text-decoration: none; margin-right: 10px;color:white">
                                    <i class="fa-sharp fa-solid fa-arrow-left" style="font-size: 30px;"></i>
                                </a>
                                <span class="font-weight-bold" style="font-size: 30px;">Edit Arsip</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>

                <body>
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('arsip.update', $arsip->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <label for="namaArsip" class="col-md-4 col-form-label">Nama Arsip</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="namaArsip"
                                                        name="nama_arsip" style="background-color: #E0E0E0;"
                                                        value="{{ $arsip->nama_arsip }}"
                                                        placeholder="{{ $arsip->nama_arsip }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kodeArsip" class="col-md-4 col-form-label">Kode Arsip</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="kodeArsip"
                                                        name="kode_arsip" placeholder="{{ $arsip->kode_arsip }}"
                                                        value="{{ $arsip->kode_arsip }}" style="background-color: #E0E0E0;">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="perihal" class="col-md-4 col-form-label">Perihal</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="perihal" name="perihal"
                                                        placeholder="{{ $arsip->perihal }}" value="{{ $arsip->perihal }}"
                                                        style="background-color: #E0E0E0;">
                                                </div>
                                            </div>
                                            <div class="form-group row" hidden>
                                                <label for="tanggalSelesai" class="col-md-4 col-form-label">Tanggal
                                                    terbit</label>
                                                <div class="col-md-8">
                                                    <input type="date" class="form-control" id="tanggalSelesai"
                                                        name="tanggal_terbit" style="background-color: #E0E0E0;"
                                                        placeholder="{{ $arsip->tanggal_terbit }}"
                                                        value="{{ $arsip->tanggal_terbit }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tanggalSelesai" class="col-md-4 col-form-label">Tanggal
                                                    Selesai</label>
                                                <div class="col-md-8">
                                                    <input type="date" class="form-control" id="tanggalSelesai"
                                                        name="tanggal_selesai" style="background-color: #E0E0E0;"
                                                        placeholder="{{ $arsip->tanggal_selesai }}"
                                                        value="{{ $arsip->tanggal_selesai }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="lokasiArsip" class="col-md-4 col-form-label">Lokasi
                                                    Arsip</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="lokasiArsip" name="lokasi_arsip"
                                                        style="background-color: #E0E0E0;" name="lokasi_arsip">
                                                        <option value="" disabled selected>{{ $arsip->lokasi_arsip }}
                                                        </option>
                                                        <option value="Lemari"
                                                            {{ $arsip->lokasi_arsip == 'Lemari' ? 'selected' : '' }}>Lemari
                                                        </option>
                                                        <option value="Rak"
                                                            {{ $arsip->lokasi_arsip == 'Rak' ? 'selected' : '' }}>Rak
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kategori" class="col-md-4 col-form-label">Kategori</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="kategori" name="kategori"
                                                        style="background-color: #E0E0E0;" name="kategori">
                                                        <option value="" disabled selected>{{ $arsip->kategori }}
                                                        </option>
                                                        <option value="Perizinan"
                                                            {{ $arsip->kategori == 'Perizinan' ? 'selected' : '' }}>
                                                            Perizinan</option>
                                                        <option value="SIP"
                                                            {{ $arsip->kategori == 'SIP' ? 'selected' : '' }}>SIP (Surat
                                                            Izin Praktik)</option>
                                                        <option value="STR"
                                                            {{ $arsip->kategori == 'STR' ? 'selected' : '' }}>STR (Surat
                                                            Tanda Regist)</option>
                                                        <option value="PKWT"
                                                            {{ $arsip->kategori == 'PKWT' ? 'selected' : '' }}>PKWT
                                                        </option>
                                                        <option value="MoU Spesialis"
                                                            {{ $arsip->kategori == 'MoU Spesialis' ? 'selected' : '' }}>MoU
                                                            Spesialis</option>
                                                        <option value="Kontrak Part Time"
                                                            {{ $arsip->kategori == 'Kontrak Part Time' ? 'selected' : '' }}>
                                                            Kontrak Part Time</option>
                                                    </select>
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
                </body>
            </section>
    </body>
@endsection
