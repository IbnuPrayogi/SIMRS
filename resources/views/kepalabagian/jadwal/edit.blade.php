@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Jadwal Kerja Karyawan</title>
    <style>
        /* Styles remain unchanged */

        .employee-name {
            /* Updated styling for employee name */
            text-align: left;
            font-weight: bold;
            background-color: #0D72F2;
            color: white;
            padding: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Add responsive styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        /* Hide day headers on mobile */
        @media (max-width: 600px) {
            th {
                display: none;
            }
        }

        /* Styles remain unchanged */
    </style>
</head>
<body>
@php
    $users = App\Models\User::where('nama_bagian',auth()->user()->nama_bagian)->get();
    $shifts = App\Models\Shift::where('bagian',auth()->user()->nama_bagian)->get();
    $bulan=intval($bulan);
    $jadwal = App\Models\Jadwal::where('bulan', $bulan)->where('tahun',$tahun)->where('nama_bagian',auth()->user()->nama_bagian)->get();

    $bulan = $bulan ?? now()->format('m');
    $tahun = $tahun ?? now()->format('Y');
@endphp

<form method="post" action="{{ route('kbjadwal.store') }}">
    @csrf

    <h4>Jadwal Karyawan Bulan {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</h4>

    <table>
        <tr>
            <th></th>
            @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $bulan, now()->format('Y')); $day++)
                <th>{{ $day }}</th>
            @endfor
            <th>Jam Kerja</th>
        </tr>

        @foreach ($users as $user)
            @php
                $userSchedule = $jadwal->where('user_id', $user->id)->where('bulan', $bulan)->first();
            @endphp

            <tr>
                <td class="employee-name">{{ $user->nama_karyawan }}</td>

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

                @php
                if($userSchedule){
                    $hours = floor($userSchedule->jumlah_jam_kerja / 60);
                    $minutes = $userSchedule->jumlah_jam_kerja % 60;
                }
                else{
                    $hours = '0';
                    $minutes = '0';
                }
                    
                @endphp
                <td>{{ $hours.' jam' }}</td>
            </tr>
        @endforeach
    </table>

    <input type="hidden" name="bulan" value="{{ $bulan }}">
    <input type="hidden" name="tahun" value="{{ $tahun }}">

    <br>
    <button type="submit">Simpan Jadwal</button>
</form>
{{-- <form method="post" action="{{ route('presensi.store') }}" enctype="multipart/form-data">
    @csrf
    <label for="">Rekap Presensi</label><br>
    <button type="submit">Rekap Data Presensi</button>
</form> --}}

<script>
    function changeShift(shiftId, userName, day) {
        // Implement your logic here to handle the shift change
        console.log('Selected Shift:', shiftId, 'for', userName, 'on day ' + day + ':', shiftId);
    }
</script>

</body>
</html>
@endsection