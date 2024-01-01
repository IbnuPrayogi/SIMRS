@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
        <link rel="stylesheet" href="css/kelolapengguna.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    </head>

    <body>

        <div class="container py-5" style="background-color: blue; border-radius: 25px;">
            <div class="container py-6">
                <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="font-weight-bold" style="font-size: 30px;">Kelola Pengguna</span>
                        </div>
                        <div style="text-align: right">
                     
                            <a href="{{ route('user.create') }}"><button class="button"
                                    style="font-size: 15px;border-radius:20px;">Tambah Pengguna</button></a>
                        </div>
                    </div>

                    <div class="row py-6">
                        <div class="col-lg-12 mx-auto">
                            <div class="card rounded shadow border-2">
                                <div class="card-body p-5 bg-white rounded">



                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="example" style="width: 100%"
                                                    class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>Bagian</th>
                                                            <th>Jabatan</th>
                                                            <th>Nik</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($users as $user)
                                                            <tr>
                                                                <td>{{ $user->nama_karyawan }}</td>
                                                                <td>{{ $user->nama_bagian }}</td>
                                                                <td>{{ $user->jabatan }}</td>
                                                                <td>{{ $user->nik }}</td>
                                                                <td> <a href="{{ route('user.show', $user->id) }}"><button
                                                                            class="btn btn-info"style="padding: 0.25rem 0.5rem;font-size: 10px;"><i
                                                                                class="fas fa-eye"></i></button></a>
                                                                    <a href="{{ route('user.edit', $user->nik) }}"><button
                                                                            class="btn btn-warning"><i
                                                                                class="fas fa-edit"></i></button></a>
                                                                    <a role="button" class="delete-button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target=".bd-example-modal-sm{{ $user->id }}"><button
                                                                            class="btn btn-danger" data-toggle="modal"
                                                                            data-target="#hapusModal">
                                                                            <i class="fas fa-trash"></i></button></a>


                                                                    <div class="modal fade bd-example-modal-sm{{ $user->id }}"
                                                                        tabindex="-1" role="dialog" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"><strong>Hapus
                                                                                            Data</strong></h5>
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal">
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">Apakah anda yakin
                                                                                    ingin menghapus data?</div>
                                                                                <div class="modal-footer"
                                                                                    style="left:0px; height: 80px;">
                                                                                    <form
                                                                                        action="{{ route('user.destroy', $user->id) }}"
                                                                                        method="POST">
                                                                                        @method('DELETE')
                                                                                        @csrf
                                                                                        <div
                                                                                            style="display: flex; justify-content: space-between;">
                                                                                            <button type="button"
                                                                                                class="btn submit-btn submit-btn-yes"
                                                                                                data-bs-dismiss="modal"
                                                                                                style="width: 49%;">Tidak</button>
                                                                                            <input type="submit"
                                                                                                class="btn submit-btn submit-btn-no"
                                                                                                name=""
                                                                                                id=""
                                                                                                value="Hapus"
                                                                                                style="width: 49%;">
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
                </div>
            </div>
        </div>

        <!-- Sisipkan script untuk jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- Sisipkan script untuk DataTables -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <!-- Sisipkan script untuk file JavaScript Anda -->
        <script src="js/kelolapengguna.js"></script>
    </body>

    </html>
@endsection
