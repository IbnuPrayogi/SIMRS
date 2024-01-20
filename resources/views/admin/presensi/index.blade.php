<!-- resources/views/schedule/index.blade.php -->

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
            padding: 8px;
        }

        .employee-name {
            font-weight: bold;
            background-color: #4CAF50;
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
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
@endphp

<h2>Jadwal Karyawan Bulan 
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
</h2>

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
        <tr>
            <td class="employee-name">{{ $user->nama_karyawan }}</td>

            @php
                $totalTerlambat = \App\Models\Terlambat::where('user_id', $user->id)
                    ->where('tanggal','like',"%/$selectedMonth/%")
                    ->sum('waktu_terlambat');
                $totalTerpotong = \App\Models\Potongan::where('user_id', $user->id)
                    ->where('tanggal','like',"%/$selectedMonth/%")
                    ->sum('waktu_potongan');
                $totalIzin = \App\Models\Izin::where('nama_karyawan', $user->nama_karyawan)
                    ->where('tanggal','like',"%/$selectedMonth/%")
                    ->sum('waktu_izin');
            @endphp

            @for ($day = 1; $day <= $daysInMonth; $day++)
                <td class="calendar-cell" style="background-color: 
                @php
                    $date = $day . "/" . $selectedMonth . "/" . $selectedYear;
                    $datapresensi = $presensi->where('id_karyawan', $user->id)->where('tanggal', $date)->first();

                    if ($datapresensi != null) {
                        if ($datapresensi->status === 'tepat waktu') {
                            echo 'green';  // Warna hijau untuk tepat waktu
                        } elseif ($datapresensi->status === 'alfa') {
                            echo 'red';  // Warna merah untuk alfa
                        } elseif ($datapresensi->status === 'izin') {
                            echo 'blue';
                        } elseif ($datapresensi->status === 'cuti') {
                            echo 'black';
                        } elseif ($datapresensi->status !== null) {
                            echo 'yellow';  // Warna kuning untuk kondisi lainnya
                        } else {
                            echo 'white';  // Warna putih untuk null
                        }
                    }
                @endphp
                ">
                    @php
                        $userSchedule = $jadwal->where('user_id', $user->id)->where('bulan', $selectedMonth)->first();
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

<a href="javascript:void(0);" onclick="downloadImage()" class="btn btn-primary">Download Image</a>
<a href="{{ route('jadwal.editjadwal', ['bulan' => $selectedMonth]) }}" class="btn btn-primary">Edit Schedule</a>

<form method="post" action="{{ route('presensi.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="bulan" value="{{ $selectedMonth }}">
    <input type="hidden" name="tahun" value="{{ $selectedYear }}">
    <label for="">Rekap Presensi</label><br>
    <button type="submit">Rekap Data Presensi</button>
</form>

</body>
<script>
    function downloadImage() {
        html2canvas(document.querySelector("#scheduleTable")).then(canvas => {
            var link = document.createElement('a');
            link.href = canvas.toDataURL("image/png");
            link.download = 'jadwal_karyawan.png';
            link.click();
        });
    }

    function updateTable() {
        var selectedMonth = document.getElementById('selectMonth').value;
        var selectedYear = document.getElementById('selectYear').value;
        window.location.href = window.location.pathname + '?selectedMonth=' + selectedMonth + '&selectedYear=' + selectedYear;
    }
</script>
</html>
