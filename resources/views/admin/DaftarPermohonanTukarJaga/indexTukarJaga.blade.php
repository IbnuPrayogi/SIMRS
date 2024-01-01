@extends('layouts.appdashboardkabag')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
        <link rel="stylesheet" href="css/daftarpermohonancuti.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    </head>

    <body>

        <div class="container py-5" style="background-color: blue; border-radius: 25px;">

            <div class="container py-6">
                <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="font-weight-bold" style="font-size: 30px;">Daftar Permohonan Tukar Jaga</span>
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
                                                    <th>Nama Pengaju</th>
                                                    <th>Target Tukar Jaga</th>
                                                    <th>Keterangan</th>
                                                    <th>jadwal asli</th>
                                                    <th>jadwal dirubah</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($TukarJagas as $TukarJaga)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $TukarJaga->nama_pengaju }}</td>
                                                        <td>{{ $TukarJaga->target_tukar_jaga }}</td>
                                                        <td>{{ $TukarJaga->keterangan }}</td>
                                                        <td>{{ $TukarJaga->jadwal_asli }}</td>
                                                        <td>{{ $TukarJaga->jadwal_dirubah }}</td>
                                                        <td>{{ $TukarJaga->status }}</td>

                                                        <td>
                                                            @if ($TukarJaga->status== auth()->user()->jabatan)
                                                            <a href="{{ route('PermohonanTukarJaga.priview', $TukarJaga->id) }}"><button
                                                                class="btn btn-warning" style="background:#1AACAC">
                                                                <i class="fa-solid fa-file-signature"></i></button></a>
                                                                
                                                            @endif
                                                            
                                                            @if ($TukarJaga->file)
                                                                <a href="{{ route('PermohonanTukarJaga.download', ['id' => $TukarJaga->id, 'file' => $TukarJaga->file]) }}"
                                                                    class="btn btn-success" target="_blank"><i
                                                                        class="fas fa-download"></i></a>
                                                            @endif

                                                            <a href="{{ route('kbdisposisi.showsurat', ['id' => $TukarJaga->id, 'nama' => $TukarJaga->nama_surat]) }}"><button
                                                                class="btn btn-primary"><i
                                                                    class="fa-regular fa-note-sticky"></i></button></a>

                                                            {{-- @if ($TukarJaga->status == auth()->user()->jabatan)
                                                            <a
                                                                href="{{ route('kbdisposisi.tambah', ['id' => $TukarJaga->id, 'jenis' => "surat keluar"]) }}"><button
                                                                    class="btn btn-success"><i
                                                                        class="fa-solid fa-share-from-square"></i></button></a>
                                                            @endif --}}
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
            <script src="js/daftarpermohonancuti.js"></script>
    </body>

    </html>
@endsection
