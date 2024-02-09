@extends('layouts.appdashboardkabag')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Jadwal Kerja Karyawan</title>
    <style>
        /* Updated Styles */
        .employee-name, .jam-kerja {
            text-align: left;
            font-weight: normal;
            background-color: #0D72F2;
            color: white;
            padding: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .scrollable-table {
            overflow-x: auto;
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-weight: normal;
        }

        .fixed-column {
            position: absolute;
            width: 200px; /* Sesuaikan lebar kolom sesuai kebutuhan */
            left: 0;
            top: auto;
            border-right: 1px solid #ddd;
        }
      
    </style>
</head>
<body>
@php
    $users = App\Models\User::where('nama_bagian', auth()->user()->nama_bagian)->where('role',3)->get();
    $shifts = App\Models\Shift::where('bagian', auth()->user()->nama_bagian)->get();
    $bulan = intval($bulan);
    $jadwal = App\Models\Jadwal::where('bulan', $bulan)->where('tahun', $tahun)->where('nama_bagian', auth()->user()->nama_bagian)->get();

    $bulan = $bulan ?? now()->format('m');
    $tahun = $tahun ?? now()->format('Y');
@endphp

<form method="post" action="{{ route('kbjadwal.store') }}">
    @csrf

    <h5>Jadwal Karyawan Bulan {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</h5>

    <div class="scrollable-table">
        <style>
            .fixed-column {
                position: sticky;
                left: 0;
                z-index: 1;
                background-color: #0D72F2;
                color: white;
            }
        
            .fixed-column th,
            .fixed-column td {
                white-space: nowrap;
            }
        
            .fixed-jam {
                position: sticky;
                left: 155px; /* Sesuaikan dengan lebar kolom "Nama Karyawan" */
                z-index: 1;
                background-color: #0D72F2;
                color: white;
            }
        </style>
        
        <table style="width: auto;">
            <colgroup>
                <col span="1" style="width: auto;">
                <col span="1" style="width: auto;">
                @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $bulan, now()->format('Y')); $day++)
                    <col span="1" style="width: 40px;">
                @endfor
            </colgroup>
            <tr>
                <th class="fixed-column">Nama Karyawan</th>
                <th class="fixed-jam">Jam Kerja</th>
                @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $bulan, now()->format('Y')); $day++)
                    <th>
                        {{ $day }}<br>
                        {{ date('l', strtotime("$tahun-$bulan-$day")) === 'Sunday' ? 'Minggu' :
                            (date('l', strtotime("$tahun-$bulan-$day")) === 'Monday' ? 'Senin' :
                            (date('l', strtotime("$tahun-$bulan-$day")) === 'Tuesday' ? 'Selasa' :
                            (date('l', strtotime("$tahun-$bulan-$day")) === 'Wednesday' ? 'Rabu' :
                            (date('l', strtotime("$tahun-$bulan-$day")) === 'Thursday' ? 'Kamis' :
                            (date('l', strtotime("$tahun-$bulan-$day")) === 'Friday' ? 'Jumat' : 'Sabtu'))))) }}
                    </th>
                @endfor
            </tr>
        
            @foreach ($users as $user)
                @php
                    $userSchedule = $jadwal->where('user_id', $user->id)->where('bulan', $bulan)->first();
                @endphp
        
                <tr>
                    <td class="fixed-column employee-name">{{ $user->nama_karyawan }}</td>
                    @php
                        if ($userSchedule) {
                            $hours = floor($userSchedule->jumlah_jam_kerja / 60);
                            $minutes = $userSchedule->jumlah_jam_kerja % 60;
                        } else {
                            $hours = '0';
                            $minutes = '0';
                        }
                    @endphp
                    <td class="fixed-jam jam-kerja">{{ $hours.' jam' }}</td>
        
                    @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $bulan, now()->format('Y')); $day++)
                        @php
                            $userShift = $userSchedule ? $shifts->where('id', $userSchedule->{"tanggal_$day"})->first() : null;
                            $shiftId = $userShift ? $userShift->kode_shift : '-';
                        @endphp
                        <td class="calendar-cell">
                            <div class="shift-dropdown">
                                <select class="shift" name="jadwal[{{ $user->id }}][{{ $day }}]">
                                    @foreach ($shifts as $shiftOption)
                                        <option value="{{ $shiftOption->id }}" {{ $shiftId == $shiftOption->kode_shift ? 'selected' : '' }}>
                                            {{ $shiftOption->kode_shift }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    @endfor
                </tr>
            @endforeach
        </table>
        
    </div>

    <input type="hidden" name="bulan" value="{{ $bulan }}">
    <input type="hidden" name="tahun" value="{{ $tahun }}">

    <br>
    <button type="submit">Simpan Jadwal</button>
</form>

<script>
    function changeShift(shiftId, userName, day) {
        // Implement your logic here to handle the shift change
        console.log('Selected Shift:', shiftId, 'for', userName, 'on day ' + day + ':', shiftId);
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Array hari dalam Bahasa Indonesia
        const daysInIndonesian = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // ... Bagian JavaScript lainnya ...
    });
</script>

</body>
</html>
@endsection
