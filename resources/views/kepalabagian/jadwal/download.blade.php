<!-- resources/views/schedule/download.blade.php -->

Jadwal Karyawan Bulan {{ now()->format('F') }} - Download

@foreach ($users as $user)
    {{ $user->nama_karyawan }}
    @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, now()->format('m'), now()->format('Y')); $day++)
        @php
            $userSchedule = $jadwal->where('user_id', $user->id)->first();
            $userShift = $shifts->where('id', $userSchedule->{"tanggal_$day"})->first();
            $shiftId = $userSchedule ? $userShift->kode_shift : '-';
        @endphp
        {{ $shiftId }}
    @endfor
@endforeach
