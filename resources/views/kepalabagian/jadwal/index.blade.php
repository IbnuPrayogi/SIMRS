@extends('layouts.appdashboardkabag')

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
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
    
        .employee-name, .jam-kerja {
            text-align: left;
            font-weight: bold;
            background-color: #0D72F2;
            color: white;
            padding: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    
        .header-row th, .header-row td {
            position: sticky;
            top: 0;
            background-color: #0D72F2;
            color: white;
            z-index: 2;
        }
    
        .content-row td {
            text-align: center;
        }
    
        @media only screen and (max-width: 600px) {
            #scheduleTable {
                font-size: 12px;
            }
    
            th, td {
                min-width: 30px;
                max-width: 100px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
    
            .content-row td {
                padding: 5px;
            }
        }
    </style>
    
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</head>
<body>

@php
    $selectedMonth = request('selectedMonth', now()->format('m'));
    $selectedYear = request('selectedYear', now()->format('Y'));
@endphp

<h4>Jadwal Karyawan Bulan 
    <select id="selectMonth" onchange="updateTable()" value="{{ $selectedMonth }}" style="font-size: 20px">
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

<table id="scheduleTable">
    <tr>
        <th></th>
        <th style="width: 200px">Jam Kerja</th>
        @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, now()->format('Y')); $day++)
            <th>{{ $day }}<br>
                {{ date('l', strtotime("$year-$selectedMonth-$day")) === 'Sunday' ? 'Minggu' :
                    (date('l', strtotime("$year-$selectedMonth-$day")) === 'Monday' ? 'Senin' :
                    (date('l', strtotime("$year-$selectedMonth-$day")) === 'Tuesday' ? 'Selasa' :
                    (date('l', strtotime("$year-$selectedMonth-$day")) === 'Wednesday' ? 'Rabu' :
                    (date('l', strtotime("$year-$selectedMonth-$day")) === 'Thursday' ? 'Kamis' :
                    (date('l', strtotime("$year-$selectedMonth-$day")) === 'Friday' ? 'Jumat' : 'Sabtu'))))) }}</th>
        @endfor
    </tr>

    @foreach ($users as $user)
        <tr>
            <td class="employee-name">{{ $user->nama_karyawan }}</td>
                   @php
                   $userSchedule = $jadwal->where('user_id', $user->id)->where('bulan', $selectedMonth)->where('tahun',$selectedYear)->first();
                        if ($userSchedule) {
                            $hours = floor($userSchedule->jumlah_jam_kerja / 60);
                            $minutes = $userSchedule->jumlah_jam_kerja % 60;
                        } else {
                            $hours = '0';
                            $minutes = '0';
                        }
                    @endphp
                    <td class="jam-kerja">{{ $hours.' jam' }}</td>

            @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, now()->format('Y')); $day++)
                <td class="calendar-cell">
                    @php
                        
                        $userShift = $userSchedule ? $shifts->where('id', $userSchedule->{"tanggal_$day"})->first() : null;
                        $shiftId = $userShift ? $userShift->kode_shift : '-';
                    @endphp
                    {{ $shiftId }}
                </td>
            @endfor
        </tr>
    @endforeach
</table>

<a href="javascript:void(0);" onclick="downloadImage()" class="btn btn-primary">Download Image</a>
<a href="{{ route('kbjadwal.editjadwal', ['bulan' => $selectedMonth,'tahun'=>$selectedYear]) }}" class="btn btn-primary">Edit Schedule</a>


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
@endsection