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

        /* Styles remain unchanged */
    </style>
</head>
<body>
@php
$users = App\Models\User::all();

// Fetch shift data from the database
$shifts = App\Models\Shift::all();
@endphp

<form method="post" action="{{ route('jadwal.store') }}">
    @csrf

    <h2>Jadwal Karyawan Bulan {{ now()->format('F') }}</h2>

    <table>
        <tr>
            <th></th>
            @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, now()->format('m'), now()->format('Y')); $day++)
                <th>{{ $day }}</th>
            @endfor
        </tr>

        @foreach ($users as $user)
            <tr>
                <td class="employee-name">{{ $user->nama_karyawan }}</td>

                @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, now()->format('m'), now()->format('Y')); $day++)
                    <td class="calendar-cell">
                        <div class="shift-dropdown">
                            <select class="shift" name="jadwal[{{ $user->id }}][{{ $day }}]">
                                @foreach ($shifts as $shiftOption)
                                    <option value="{{ $shiftOption->id }}">{{ $shiftOption->kode_shift }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                @endfor
            </tr>
        @endforeach
    </table>

    <input type="hidden" name="bulan" value="{{ now()->month }}">

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
