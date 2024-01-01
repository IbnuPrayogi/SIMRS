@extends('layouts.appdashboardkabag')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="css/kelolasuratmasuk.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
    <body>
        <div class="container py-5" style="background-color: blue; border-radius: 25px;">
            <div class="container py-6">
                <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="font-weight-bold" style="font-size: 30px;">Kelola Surat</span>
                        </div>
       
                    </div>
                    <br>
                    <div class="row py-6">
                        <div class="col-lg-12 mx-auto">
                            <div class="card rounded shadow border-2">
                                <div class="card-body p-5 bg-white rounded">
                 

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
                                                        {{-- <td hidden>{{ $suratkeluarr->id }}</td> --}}
                                                        <td>{{ $suratkeluarr->nama_surat }}</td>
                                                        <td>{{ $suratkeluarr->tanggal_dibuat }}</td>
                                                        <td>{{ $suratkeluarr->tujuan_surat }}</td>
                                                        <td>{{ $suratkeluarr->status }}</td>
                                                        {{-- <td> --}}

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
                                                       
                                                                {{-- <a href="#"><button
                                                                    class="btn btn-success">
                                                                    Setuju</button></a>
                                                                <a href="#"><button
                                                                    class="btn btn-danger">
                                                                    Tolak</i></button></a>
                                                   
                                                        </td> --}}
                                                        <td>
                                                      

                                                        @if (auth()->user()->jabatan == "Direktur RS" && $suratkeluarr->jenis_surat=="Template" && $suratkeluarr->status != 'disetujui'    )
                                                        <a href="{{ route('kbtemplateSK.priview', $suratkeluarr->id) }}"><button
                                                            class="btn btn-warning" style="background:#1AACAC">
                                                            <i class="fa-solid fa-file-signature"></i></button></a>
                                                        @endif
                                                        @if ($suratkeluarr->file)
                                                        <a href="{{ route('kbsuratkeluar.download', ['id' => $suratkeluarr->id, 'file' => $suratkeluarr->file]) }}"
                                                            class="btn btn-success" target="_blank"><i
                                                                class="fas fa-download"></i></a>
                                                        @endif
                                                        <a href="{{ route('kbdisposisi.showsurat', ['id' => $suratkeluarr->id, 'nama' => $suratkeluarr->nama_surat]) }}"><button
                                                                class="btn btn-primary"><i
                                                                    class="fa-regular fa-note-sticky"></i></button></a>

                                                        @if ($suratkeluarr->status == auth()->user()->jabatan)
                                                        <a
                                                            href="{{ route('kbdisposisi.tambah', ['id' => $suratkeluarr->id, 'jenis' => "surat keluar"]) }}"><button
                                                                class="btn btn-secondary"style="padding: 0.25rem 0.5rem;font-size: 10px;"><i
                                                                    class="fa-solid fa-share-from-square"></i></button></a>
                                                        @endif

                                                           


                       

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
                                                                                action=""
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

            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <!-- Sisipkan script untuk DataTables -->
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="js/kelolasuratkeluar.js"></script>
           

              <!-- Bootstrap v5 JavaScript -->
  <script src="https://unpkg.com/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
            
        </body>
    </html>
        @endsection
