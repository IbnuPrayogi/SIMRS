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

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
            <link rel="stylesheet" href="css/arsip.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        </head>

        <body>
            <div class="container py-5" style="background-color: blue; border-radius: 25px;">
                <div class="container py-6">
                    <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="font-weight-bold" style="font-size: 30px;">{{ $title }}</span>
                            </div>
                            <div>
                                
                                <a href="{{ route('arsip.create') }}"><button class="button" id="openPopupButton"
                                        style="font-size: 15px; border-radius: 20px;">
                                        Tambah Arsip Baru</button></a>
                            </div>
                        </div>

                    </div><br>
                    <div class="row py-6">
                        <div class="col-lg-12 mx-auto">
                            <div class="card rounded shadow border-2">
                                <div class="card-body p-5 bg-white rounded">
                                    <div class="table-responsive">
                                        <table id="example" style="width: 100%"
                                            class="table table-striped table-bordered">

                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Arsip</th>
                                                    <th>Kode Arsip</th>
                                                    <th>Perihal</th>
                                                    <th>Kategori</th>
                                                    <th>Tanggal Terbit</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Lokasi Arsip</th>
                                                    <th>File</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($arsips as $arsip)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $arsip->nama_arsip }}</td>
                                                        <td>{{ $arsip->kode_arsip }}</td>
                                                        <td>{{ $arsip->perihal }}</td>
                                                        <td>{{ $arsip->kategori }}</td>
                                                        <td>{{ $arsip->created_at->format('Y-m-d') }}</td>
                                                        <td>{{ $arsip->tanggal_selesai }}</td>
                                                        <td>{{ $arsip->lokasi_arsip }}</td>
                                                        <td>{{ $arsip->file }}</td>

                                                        <td>
                                                            <a href="{{ route('arsip.edit', $arsip->id) }}"><button
                                                                    class="btn btn-warning">
                                                                    <i class="fas fa-edit"></i></button></a>
                                                            <a role="button"  class="delete-button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm{{$arsip->id}}"><button
                                                                class="btn btn-danger" data-toggle="modal" data-target="#hapusModal">
                                                                    <i class="fas fa-trash"></i></button></a>
                                                                @if ($arsip->file)
                                                                <a href="{{ route('arsipdownload', ['id' => $arsip->id, 'file' => $arsip->file]) }}" class="btn btn-success" target="_blank"><i class="fas fa-download"></i></a>
                                                            @endif



                                                            <div class="modal fade bd-example-modal-sm{{$arsip->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"><strong>Hapus Data</strong></h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">Apakah anda yakin ingin menghapus data?</div>
                                                                        <div class="modal-footer" style="left:0px; height: 80px;">
                                                                            <form action="{{route('arsip.destroy', $arsip->id)}}" method="POST">
                                                                            @method('DELETE')
                                                                            @csrf
                                                                            <div style="display: flex; justify-content: space-between;">
                                                                                <button type="button" class="btn submit-btn submit-btn-yes" data-bs-dismiss="modal" style="width: 49%;">Tidak</button>
                                                                                <input type="submit" class="btn submit-btn submit-btn-no" name="" id="" value="Hapus" style="width: 49%;">
                                                                            </div>

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Sisipkan script untuk jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- Sisipkan script untuk DataTables -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <!-- Sisipkan script untuk file JavaScript Anda -->
        <script src="js/arsip.js"></script>
        </body>
    </html>
@endsection
