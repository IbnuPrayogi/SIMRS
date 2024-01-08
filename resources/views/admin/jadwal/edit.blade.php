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
            background-color: #4CAF50;
            color: white;
            padding: 8px;
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
    $users = App\Models\User::all();
    $shifts = App\Models\Shift::all();
    $jadwal = App\Models\Jadwal::where('bulan', $bulan)->get();
    $bulan = $bulan ?? now()->format('m');
@endphp

<form method="post" action="{{ route('jadwal.store') }}">
    @csrf

    <h2>Jadwal Karyawan Bulan {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</h2>

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
                    $hours = floor($userSchedule->jumlah_jam_kerja / 60);
                    $minutes = $userSchedule->jumlah_jam_kerja % 60;
                @endphp
                <td>{{ $hours.' jam' }}</td>
            </tr>
        @endforeach
    </table>

    <input type="hidden" name="bulan" value="{{ $bulan }}">

    <button type="submit">Simpan Jadwal</button>
</form>

<script>
    function changeShift(shiftId, userName, day) {
        // Implement your logic here to handle the shift change
        console.log('Selected Shift:', shiftId, 'for', userName, 'on day ' + day + ':', shiftId);
    }
</script>

</body>
</html>
