@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link  rel="stylesheet" href="{{ asset('css/presensi.css') }}">

<div class="container" style="margin-top:20px">
    <div class="card-header">
        <h1><b>Presensi</b></h1>
    </div>
    <div class="card-body">
        @php
            $selectedMonth = request('selectedMonth', now()->format('m'));
            $selectedYear = request('selectedYear', now()->format('Y'));
            $selectedDepartment = request('selectedDepartment', 'Satpam');
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
        @endphp

        <h4 style="margin-top: 20px;margin-left: 17px;">Bulan 
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
        </h4>

        <div class="table-container" style="max-height: 30rem; overflow: auto;width:380px">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Shift</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $date = $day . "/" . $selectedMonth . "/" . $selectedYear;
                            $datapresensi=null;
                            if($presensi!=null){
                                $datapresensi = $presensi->where('nama_karyawan', $jadwal->nama_karyawan)->where('tanggal', $date)->first();
                            }
                            $userShift = $jadwal ? $shift->where('id', $jadwal->{"tanggal_$day"})->first() : null;
                            $shiftId = $userShift ? $userShift->kode_shift : '-';
                            $presensiId = $datapresensi ? $datapresensi->status :'-';
                            $idpresensi= $datapresensi ? $datapresensi->id:'-';
                        @endphp
                        <tr>
                            <td>{{ $day }}</td>
                            <td>{{ $shiftId }}</td>
                            <td>{{ $presensiId }}</td>
                            <td>
                                <a href="{{ route('detail.presensi',['id'=>$idpresensi,'shift'=>$shiftId]) }}"><button class="detail-button">
                                    <i class="fas fa-eye"></i> 
                                </button></a>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

    </div>
    <!-- Sertakan ikon mata (eye) dari Font Awesome -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script>
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
</div>
@endsection
