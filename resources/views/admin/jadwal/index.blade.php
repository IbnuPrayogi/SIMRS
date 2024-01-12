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

        .employee-name {
            font-weight: bold;
        }

        .calendar-cell {
            padding: 5px;
        }
    }
    </style>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</head>
<body>

@php
    $selectedMonth = request('selectedMonth', now()->format('m'));
@endphp

<h4>Jadwal Karyawan Bulan 
    <select id="selectMonth" onchange="updateTable()" value="{{ $selectedMonth }}" style="font-size: 20px">
        @for ($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
            </option>
        @endfor
    </select>
</h4>

<table id="scheduleTable">
    <tr>
        <th></th>
        @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, now()->format('Y')); $day++)
            <th>{{ $day }}</th>
        @endfor
    </tr>

    @foreach ($users as $user)
        <tr>
            <td class="employee-name">{{ $user->nama_karyawan }}</td>

            @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, now()->format('Y')); $day++)
                <td class="calendar-cell">
                    @php
                        $userSchedule = $jadwal->where('user_id', $user->id)->where('bulan', $selectedMonth)->first();
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
<a href="{{ route('jadwal.editjadwal', ['bulan' => $selectedMonth]) }}" class="btn btn-primary">Edit Schedule</a>


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
        window.location.href = window.location.pathname + '?selectedMonth=' + selectedMonth;
    }
</script>
</html>
@endsection