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
    
  <div class="container py-12" style="background-color: blue; border-radius: 25px; height: 100vh;">
    <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
    
            <div style="text-align:center;">
                <span class="font-weight-bold" style="font-size: 20px;">Surat Masuk</span>
            </div>

        <br>
        <div class="row py-12">
            <div class="col-lg-12 mx-auto">
                <div class="card rounded shadow border-2" style="height: 85vh;margin-left:-25px;margin-right:-25px;">

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
                              
                 
                              @if ($item->file)
                              <a href="{{ route('kbsuratmasukdownload', ['id' => $item->id, 'file' => $item->file]) }}" class="btn btn-success" target="_blank"><i class="fas fa-download"></i></a>
                          @endif

                              <a href="{{ route('kbdisposisi.showsurat', ['id' => $item->id, 'nama' => $item->nama_surat]) }}"><button
                                class="btn btn-primary"><i
                                    class="fa-regular fa-note-sticky"></i></button></a>

                              @if ($item->status == auth()->user()->jabatan)
                                  <a
                                      href="{{ route('kbdisposisi.tambah', ['id' => $item->id, 'jenis' => "surat masuk"]) }}"><button
                                          class="btn btn-secondary"style="padding: 0.25rem 0.5rem;font-size: 10px;"><i
                                              class="fa-solid fa-share-from-square"></i></button></a>
                              @endif
                          
                                    
                   
                                    
                                  
                                    
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
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> --}}
</body>
</html>


@endsection
