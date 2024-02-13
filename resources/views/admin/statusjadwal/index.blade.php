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
        @php
            $selectedMonth = request('selectedMonth', now()->format('m'));
            $selectedYear = request('selectedYear', now()->format('Y'));
        @endphp

        <body>
            <div class="container py-5" style="background-color: blue; border-radius: 25px;">
                <div class="container py-6">
                    <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="font-weight-bold" style="font-size: 30px;">Kelola Jadwal</span>
                            </div>
                            <div>
                                <form action="{{ route('statusjadwal.lockall') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="bulan" value={{ $selectedMonth }}>
                                    <input type="hidden" name="tahun" value={{ $selectedYear }}>
                       
                                    <button class="button" id="openPopupButton"
                                        style="font-size: 15px; border-radius: 20px;">
                                        Kunci Jadwal Bulan Ini</button>
                                </form>
                                
                           
                            </div>
                        </div>

                    </div><br>
                    <div class="row py-6">
                        <div class="col-lg-12 mx-auto">
                            <div class="card rounded shadow border-2">
                                <div class="card-body p-5 bg-white rounded">
                                    <div class="table-responsive">
                                        <label for="selectMonth">Bulan:</label>
                                        <select id="selectMonth" onchange="updateTable()" value="{{ $selectedMonth }}">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    
                                    
                                        <label for="selectYear">Tahun:</label>
                                        <select id="selectYear" onchange="updateTable()" value="{{ $selectedYear }}">
                                            @php
                                                $currentYear = now()->format('Y');
                                            @endphp
                                    
                                            @for ($year = $currentYear - 5; $year <= $currentYear + 5; $year++)
                                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                        <table id="example" style="width: 100%"
                                            class="table table-striped table-bordered">

                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Bagian</th>
                                                    <th>Status</th>
                                                    <th>Waktu Dibuat</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($bagians as $bagian)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $bagian->nama_bagian }}</td>
                                                        @php
                                                        $statusjadwal=$statusjadwals->where('nama_bagian',$bagian->nama_bagian)->first();
                                                        $status = $statusjadwal ? $statusjadwal->status : '-';
                                                        $waktu = $statusjadwal ? $statusjadwal->created_at : '-';
                                                        @endphp
                                                        <td>{{ $status }}</td>
                                                        <td>{{ $waktu }}</td>
                                            

                                                        <td>
                                                            <a href="{{ route('bagian.edit', $bagian->id) }}"><button
                                                                    class="btn btn-primary">
                                                                    <i class="fas fa-eye"></i></button></a>
                                                            @if(!$statusjadwal || $statusjadwal->status=='terbuka')
                                                            <form action="{{ route('statusjadwal.lock') }}" method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="bulan" value={{ $selectedMonth }}>
                                                                <input type="hidden" name="tahun" value={{ $selectedYear }}>
                                                                <input type="hidden" name="bagian" value={{ $bagian->nama_bagian }}>
                                                                <button type="submit"
                                                                    class="btn btn-danger">
                                                                    <i class="fas fa-lock"></i></button>
                                                            </form>
                                                            
                                                            @elseif($statusjadwal && $statusjadwal->status=='terkunci')
                                                            <form action="{{ route('statusjadwal.unlock') }}" method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="bulan" value={{ $selectedMonth }}>
                                                                <input type="hidden" name="tahun" value={{ $selectedYear }}>
                                                                <input type="hidden" name="bagian" value={{ $bagian->nama_bagian }}>
                                                                <button type="submit"
                                                                    class="btn btn-success">
                                                                    <i class="fas fa-unlock"></i></button>
                                                            </form>
                                                            @endif
                                                         



                                                            <div class="modal fade bd-example-modal-sm{{$bagian->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"><strong>Hapus Data</strong></h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">Apakah anda yakin ingin menghapus data?</div>
                                                                        <div class="modal-footer" style="left:0px; height: 80px;">
                                                                            <form action="{{route('bagian.destroy', $bagian->id)}}" method="POST">
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
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <!-- Sisipkan script untuk DataTables -->
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <!-- Sisipkan script untuk file JavaScript Anda -->
            <script src="js/arsip.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
        // Set nilai awal untuk dropdown
        document.getElementById('selectMonth').value = "{{ $selectedMonth }}";
        document.getElementById('selectYear').value = "{{ $selectedYear }}";
    
        // Panggil fungsi updateTable untuk memuat data tanpa merefresh halaman
        updateTable();
    });
    
    function updateTable() {
        var selectedMonth = document.getElementById('selectMonth').value;
        var selectedYear = document.getElementById('selectYear').value;
    
        var url = window.location.pathname + '?selectedMonth=' + selectedMonth + '&selectedYear=' + selectedYear;
    
        // Ubah URL tanpa merefresh halaman
        history.replaceState({}, '', url);
    
        // Gunakan fetch untuk memuat data
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            // Ganti konten HTML tanpa merefresh halaman
            document.body.innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
        </script>
        </body>
    </html>
@endsection
