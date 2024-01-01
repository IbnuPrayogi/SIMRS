@extends('layouts.app')


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
                        <span class="font-weight-bold" style="font-size: 30px;">Kelola Surat Masuk</span>
                    </div>
                    <div class="">
                      <a href="{{ route('suratmasuk.create') }}"><button  type="button" class="button"
                          style="font-size: 15px; border-radius: 20px;">Tambah Surat Baru</button></a>

                  </div>
                </div>
                <br>
            <div class="row py-6">
                <div class="col-lg-12 mx-auto"> 
                    <div class="card rounded shadow border-2"> 
                        <div class="card-body p-5 bg-white rounded">
                          <div class="button-container">
                            <a href="{{ route('suratmasuk.index') }}"><div class="button" id="suratMasuk">Surat Masuk</div></a> 
                            <a href="{{ route('suratkeluar.index') }}"><div class="button" id="suratMasuk">Surat Keluar</div></a>
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
                                <table id="example" style="width: 100%" class="table table-striped table-bordered">

                        <thead>
                          <tr>
                            <th>Nama Surat</th>
                            <th>Kategori</th>
                            <th>Perihal</th>
                            <th>Tanggal dibuat</th>
                            <th>Asal Surat</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($items as $item)
                          <tr>
                            <td>{{ $item->nama_surat }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->perihal }}</td>
                            <td>{{ $item->tanggal_dibuat }}</td>
                            <td>{{ $item->asal_surat }}</td>
                            <td>
                              {{-- <button class="btn btn-primary"><i
                                      class="fas fa-eye"></i></button> --}}
                              <a href="{{ route('suratmasuk.edit', $item->id) }}"><button
                                      class="btn btn-warning">
                                      <i class="fas fa-edit"></i></button></a>
                              <a role="button" class="delete-button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm{{$item->id}}">
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                              </a>
                              @if ($item->file)
                              <a href="{{ route('suratmasukdownload', ['id' => $item->id, 'file' => $item->file]) }}" class="btn btn-success" target="_blank"><i class="fas fa-download"></i></a>
                          @endif

                              <a href="{{ route('disposisi.showsurat', ['id' => $item->id, 'nama' => $item->nama_surat]) }}"><button
                                class="btn btn-primary"><i
                                    class="fa-regular fa-note-sticky"></i></button></a>

                              @if ($item->status == auth()->user()->jabatan)
                                  <a
                                      href="{{ route('disposisi.tambah', ['id' => $item->id, 'jenis' => "surat masuk"]) }}"><button
                                          class="btn btn-success"><i
                                              class="fa-solid fa-share-from-square"></i></button></a>
                              @endif
                          
                                    
                              <div class="modal fade bd-example-modal-sm{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title"><strong>Hapus Data</strong></h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                          </div>
                                          <div class="modal-body">Apakah anda yakin ingin menghapus data?</div>
                                          <div class="modal-footer" style="left:0px; height: 80px;">
                                              <form action="{{ route('suratmasuk.destroy', $item->id) }}" method="POST">
                                                  @method('DELETE')
                                                  @csrf
                                                  <div style="display: flex; justify-content: space-between;">
                                                      <button type="button" class="btn submit-btn submit-btn-yes" data-bs-dismiss="modal" style="width: 49%;">Tidak</button>
                                                      <input type="submit" class="btn submit-btn submit-btn-no" value="Hapus" style="width: 49%;">
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
<script src="js/kelolasuratmasuk.js"></script>

  <!-- Bootstrap v5 JavaScript -->
  <script src="https://unpkg.com/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>


@endsection
