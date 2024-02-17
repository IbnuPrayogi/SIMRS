<!-- resources/views/schedule/index.blade.php -->



@extends('layouts.app')

@php
function getColorClass($status) {
    switch ($status) {
        case 'tepat waktu':
            return 'green';
        case 'alfa':
            return 'red';
        case 'izin':
            return 'blue';
        case 'cuti':
            return 'black';
        default:
            return 'yellow';
    }
}
@endphp

@section('content')
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Kalender Jadwal Kerja Karyawan - Index</title>
            <style>
                /* Updated Styles */
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
        
                th, td {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 5px;
                    font-weight: normal;
                }
        
                .employee-name {
                    font-weight: normal;
                    background-color: #0D72F2;
                    color: white;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
        
                .calendar-cell {
                    text-align: center;
                }
                /* Updated Styles */
            </style>
            <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        </head>

        <body>
        @php
            $selectedMonth = request('selectedMonth', now()->format('m'));
            $selectedYear = request('selectedYear', now()->format('Y'));
            $selectedDepartment = request('selectedDepartment', 'Satpam');
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
        @endphp
      
                

        <h5>Jadwal Karyawan Bulan 


            <select id="selectMonth" onchange="updateTable()">
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

            <label for="selectDepartment">Bagian:</label>
            <select id="selectDepartment" onchange="updateTable()">
                @foreach ($bagians as $department)
                    <option value="{{ $department->nama_bagian }}" {{ $selectedDepartment == $department->nama_bagian ? 'selected' : '' }}>
                        {{ $department->nama_bagian }}
                    </option>
                @endforeach
            </select>
            
        </h4>

        <table id="scheduleTable">
            <tr>
                <th></th>
                @for ($day = 1; $day <= $daysInMonth; $day++)
                    <th>{{ $day }}</th>
                @endfor
                <th>Terlambat</th> <!-- Kolom terlambat -->
                <th>Terpotong</th>
                <th>Izin</th>
            </tr>

            @foreach ($users as $user)
            @php
                $userSchedule = $jadwal->where('nama_karyawan', $user->nama_karyawan)->first();
            @endphp
                <tr>
                    <td class="employee-name">{{ $user->nama_karyawan }}</td>

                    @php
                        $totalTerlambat = \App\Models\Terlambat::where('nama_karyawan', $user->nama_karyawan)
                            ->where('tanggal','like',"%/$selectedMonth/%")
                            ->sum('waktu_terlambat');
                        $totalTerpotong = \App\Models\Potongan::where('nama_karyawan', $user->nama_karyawan)
                            ->where('tanggal','like',"%/$selectedMonth/%")
                            ->sum('waktu_potongan');
                        $totalIzin = \App\Models\Izin::where('nama_karyawan', $user->nama_karyawan)
                            ->where('tanggal','like',"%/$selectedMonth/%")
                            ->sum('waktu_izin');
                    @endphp



                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $date = $day . "/" . $selectedMonth . "/" . $selectedYear;
                            $datapresensi = $presensi->where('id_karyawan', $user->id)->where('tanggal', $date)->first();
                        @endphp
                        <td class="calendar-cell" style="background-color: {{ $datapresensi ? getColorClass($datapresensi->status) : 'white' }}">


                        
                            @php
                                
                                $userShift = $userSchedule ? $shifts->where('id', $userSchedule->{"tanggal_$day"})->first() : null;
                                $shiftId = $userShift ? $userShift->kode_shift : '-';
                            @endphp
                            {{ $shiftId }}
                        </td>
                    @endfor

                    <!-- Kolom terlambat -->
                    <td>{{ $totalTerlambat }} jam</td>
                    <td>{{ $totalTerpotong }} jam</td>
                    <td>{{ $totalIzin }} jam</td>
                    
                </tr>
            @endforeach
        </table>
        <br>
        <a href="javascript:void(0);" onclick="downloadImage()" class="btn btn-primary">Download Image</a>

        <form id="storePresensiForm" method="post" action="{{ route('presensi.store') }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="bulan" id="bulanInput">
            <input type="hidden" name="tahun" id="tahunInput">

            <button class="btn btn-primary" type="button" onclick="storePresensi()">Rekap Data Presensi</button>
        </form>

        <form id="fetchPresensiForm" method="get" action="{{ url('presensi/ambil') }}" enctype="multipart/form-data">

            <button class="btn btn-primary" type="button" onclick="fetchPresensi()">Ambil Data Presensi</button>
        </form>

        <button id="callLocalRouteButton">Call Local Route</button>


        </body>

        <script>
            function fetchPresensi() {
                var selectedMonth = document.getElementById('selectMonth').value;
                var selectedYear = document.getElementById('selectYear').value;
        
                // Build the new URL without any conditions
                var newURL = "{{ url('presensi/take') }}/" + selectedMonth + "/" + selectedYear;
        
                // Navigate to the new URL
                window.location.href = newURL;
            }

            function storePresensi() {
                var selectedMonth = document.getElementById('selectMonth').value;
                var selectedYear = document.getElementById('selectYear').value;

                // Log the values to check if they are correct
                console.log("Selected Month:", selectedMonth);
                console.log("Selected Year:", selectedYear);

                // Set the values of hidden inputs
                document.getElementById('bulanInput').value = selectedMonth;
                document.getElementById('tahunInput').value = selectedYear;

                // Submit the form
                document.getElementById('storePresensiForm').submit();
            }

            document.getElementById('callLocalRouteButton').addEventListener('click', function() {
                fetch('http://localhost:8000/presensi/fetch/12/2023', {
                method: 'GET',
                // Tambahkan header atau opsi lain jika diperlukan
                })
                .then(response => response.json())
                .then(data => {
                console.log(data);
                // Lakukan sesuatu dengan respons yang diterima
                })
                .catch(error => {
                console.error('Error:', error);
                });
            });


        </script>

        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Set nilai awal untuk dropdown
                document.getElementById('selectMonth').value = "{{ $selectedMonth }}";
                document.getElementById('selectYear').value = "{{ $selectedYear }}";
                document.getElementById('selectDepartment').value = "{{ $selectedDepartment }}";
        
                // Simpan state sebelumnya
                var prevState = {
                    selectedMonth: "{{ $selectedMonth }}",
                    selectedYear: "{{ $selectedYear }}",
                    selectedDepartment: "{{ $selectedDepartment }}"
                };
        
                // Tambahkan event listener untuk setiap dropdown
                document.getElementById('selectMonth').addEventListener('change', function () {
                    updateTable(prevState);
                });
                document.getElementById('selectYear').addEventListener('change', function () {
                    updateTable(prevState);
                });
                document.getElementById('selectDepartment').addEventListener('change', function () {
                    updateTable(prevState);
                });
        
                // Panggil fungsi updateTable untuk memperbarui URL
                updateTable(prevState);
            });
        
            function downloadImage() {
                html2canvas(document.querySelector("#scheduleTable")).then(canvas => {
                    var link = document.createElement('a');
                    link.href = canvas.toDataURL("image/png");
                    link.download = 'jadwal_karyawan.png';
                    link.click();
                });
            }
        
            function updateTable(prevState) {
                var selectedMonth = document.getElementById('selectMonth').value;
                var selectedYear = document.getElementById('selectYear').value;
                var selectedDepartment = document.getElementById('selectDepartment').value;
        
                var url = window.location.pathname + '?selectedMonth=' + selectedMonth + '&selectedYear=' + selectedYear;
        
                if (selectedDepartment) {
                    url += '&selectedDepartment=' + selectedDepartment;
                }
        
                // Gunakan AJAX untuk memuat data tanpa merefresh seluruh halaman
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    // Buat elemen div sementara untuk menyimpan data HTML baru
                    var tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data;
        
                    // Ganti isi HTML tabel dengan yang baru
                    var newTable = tempDiv.querySelector('#scheduleTable');
                    document.getElementById('scheduleTable').innerHTML = newTable.innerHTML;
        
                    // Inisialisasi ulang elemen atau script yang diperlukan di sini
                    // Misalnya, jika ada script yang perlu dijalankan, pastikan inisialisasi dilakukan di sini.
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        </script>
        
    </html>
@endsection

