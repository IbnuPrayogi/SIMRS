@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
        <link rel="stylesheet" href="css/kelolasuratkeluar.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <style>
            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }

            .dropdown-item {
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                color: #333;
            }

            .dropdown-item:hover {
                background-color: #ddd;
            }
        </style>
    </head>

    <body>
        <div class="container py-5" style="background-color: blue; border-radius: 25px;">
            <div class="container py-6">
                <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="font-weight-bold" style="font-size: 30px;">Kelola Surat Keluar</span>
                        </div>

                        <div class="">
                            <a href="{{ route('suratkeluar.create') }}"><button  type="button" class="button"
                                style="font-size: 15px; border-radius: 20px;">Tambah Surat Baru</button></a>
    
                        </div>

                    </div>

                    <br>
                    <div class="row py-6">
                        <div class="col-lg-12 mx-auto">
                            <div class="card rounded shadow border-2">
                                <div class="card-body p-5 bg-white rounded">
                                    <div class="button-container">
                                        <a href="{{ route('suratmasuk.index') }}">
                                            <div class="button" id="suratMasuk">Surat Masuk</div>
                                        </a>
                                        <a href="{{ route('suratkeluar.index') }}">
                                            <div class="button" id="suratMasuk">Surat Keluar</div>
                                        </a>
                                    </div>

                                    <script>
                                        // JavaScript untuk mengubah warna tombol saat diklik
                                        const suratMasukButton = document.getElementById('suratMasuk');
                                        const suratKeluarButton = document.getElementById('suratKeluar');

                                        suratMasukButton.addEventListener('click', () => {
                                            suratMasukButton.classList.add('active-button');
                                            suratKeluarButton.classList.remove('active-button');
                                        });

                                        suratKeluarButton.addEventListener('click', () => {
                                            suratKeluarButton.classList.add('active-button');
                                            suratMasukButton.classList.remove('active-button');
                                        });
                                    </script>

                                    <br><br>
                                    <div class="table-responsive">
                                        <table id="example" style="width: 100%"
                                            class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Surat</th>
                                                    <th>Tanggal dibuat</th>
                                                    <th>Jenis Surat</th>
                                                    <th>Tujuan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($suratkeluar as $suratkeluarr)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $suratkeluarr->nama_surat }}</td>
                                                        <td>{{ $suratkeluarr->tanggal_dibuat }}</td>
                                                        <td>{{ $suratkeluarr->jenis_surat }}</td>
                                                        <td>{{ $suratkeluarr->tujuan_surat }}</td>
                                                        <td>{{ $suratkeluarr->status }}</td>
                                                    

                                                            {{-- <a role="button" class="success-button" data-bs-toggle="modal"
                                                            data-bs-target=".modal1{{ $suratkeluarr->id }}">
                                                            <button class="btn btn-success">
                                                                Setuju
                                                            </button>
                                                            </a> --}}

                                                            {{-- <div class="modal fade modal1{{ $suratkeluarr->id }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"><strong>Setujui Surat</strong></h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">Apakah anda yakin ingin
                                                                            Menyetujui Surat?
                                                                            <span
                                                                                class="badge bg-secondary">{{ $suratkeluarr->nama_surat }}</span>
                                                                        </div>
                                                                        <div class="modal-footer"
                                                                            style="left:0px; height: 80px;">
                                                                            <form
                                                                                action="{{ route('suratkeluar.setujui', $suratkeluarr->id) }}"
                                                                                method="POST">
                                                                                @method('POST')
                                                                                @csrf
                                                                                <label for="namaSurat" class="col-md-4 col-form-label">Deskripsi</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="textarea" class="form-control" id="deskripsi" style="background-color:#EBF1FA"
                                                                                    name="deskripsi" placeholder="Deskripsi">
                                                                                </div>
                                                                                <div
                                                                                    style="display: flex; justify-content: space-between;">
                                                                                    <button type="button"
                                                                                        class="btn submit-btn submit-btn-yes"
                                                                                        data-bs-dismiss="modal"
                                                                                        style="width: 49%;">Tidak</button>
                                                                                    <input type="submit"
                                                                                        class="btn submit-btn submit-btn-no"
                                                                                        value="Hapus" style="width: 49%;">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            {{-- <form action="{{ route('suratkeluar.setujui', ['id' => $suratkeluarr->id]) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                               <button class="btn btn-success">Setuju</button>
                                                            </form>
                                                            <form action="{{ route('suratkeluar.tolak', ['id' => $suratkeluarr->id]) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                               <button class="btn btn-danger">Tolak</button>
                                                            </form> --}}
                                                            {{-- @if ($suratkeluarr->status == 'menunggu disetujui')
                                                                <a
                                                                    href="{{ route('suratkeluar.approved', $suratkeluarr->id) }}"><button
                                                                        class="btn btn-success">
                                                                        Setuju</button></a>
                                                                <a
                                                                    href="{{ route('suratkeluar.rejected', $suratkeluarr->id) }}"><button
                                                                        class="btn btn-danger">
                                                                        Tolak</i></button></a>
                                                            @endif



                                                        </td> --}}
                                                        <td>
                                                            <a href="{{ route('suratkeluar.edit', $suratkeluarr->id) }}"><button
                                                                    class="btn btn-warning">
                                                                    <i class="fas fa-edit"></i></button></a>
                                                            
                                                            @if (auth()->user()->jabatan == "Direktur RS" && $suratkeluarr->jenis_surat=="Template" && $suratkeluarr->status != 'disetujui')
                                                            <a href="{{ route('templateSK.priview', $suratkeluarr->id) }}"><button
                                                                class="btn btn-warning" style="background:#1AACAC">
                                                                <i class="fa-solid fa-file-signature"></i></button></a>
                                                            @endif

                                            
                                                            @if ($suratkeluarr->file)
                                                                <a href="{{ route('suratkeluar.download', ['id' => $suratkeluarr->id, 'file' => $suratkeluarr->file]) }}"
                                                                    class="btn btn-success" target="_blank"><i
                                                                        class="fas fa-download"></i></a>
                                                            @endif
                                                            <a href="{{ route('disposisi.showsurat', ['id' => $suratkeluarr->id, 'nama' => $suratkeluarr->nama_surat]) }}"><button
                                                                    class="btn btn-primary"><i
                                                                        class="fa-regular fa-note-sticky"></i></button></a>

                                                            @if ($suratkeluarr->status == auth()->user()->jabatan)
                                                                <a
                                                                    href="{{ route('disposisi.tambah', ['id' => $suratkeluarr->id, 'jenis' => "surat keluar"]) }}"><button
                                                                        class="btn btn-success"><i
                                                                            class="fa-solid fa-share-from-square"></i></button></a>
                                                            @endif
                                                            <a role="button" class="delete-button" data-bs-toggle="modal"
                                                                data-bs-target=".modal2{{ $suratkeluarr->id }}">
                                                                <button class="btn btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </a>



                                                            <div class="modal fade modal2{{ $suratkeluarr->id }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"><strong>Hapus
                                                                                    Data</strong></h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">Apakah anda yakin ingin
                                                                            menghapus data?
                                                                            <span
                                                                                class="badge bg-secondary">{{ $suratkeluarr->nama_surat }}</span>
                                                                        </div>
                                                                        <div class="modal-footer"
                                                                            style="left:0px; height: 80px;">
                                                                            <form
                                                                                action="{{ route('suratkeluar.destroy', $suratkeluarr->id) }}"
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
                                                                                        value="Setujui" style="width: 49%;">
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

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

            <script src="{{ asset('js/kelolasuratkeluar.js') }}"></script>

    </body>

    </html>
@endsection