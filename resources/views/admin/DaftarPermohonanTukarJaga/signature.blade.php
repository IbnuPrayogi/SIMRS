<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Surat</title>
    <link rel="stylesheet" href="{{ public_path('css/templatetukarjaga.css') }}">
</head>

<body>
    <div class="blangko">
        <p>BLANGKO TUKAR DINAS/TUKAR JAGA BAGIAN/RUANG ...............</p>
    </div>
    <div class="isi">
        <table>
            <tr>
                <th>Nama Karyawan</th>
                {{-- <th>Tgl</th> --}}
                <th>Jadwal Asli</th>
                {{-- <th>Tgl</th> --}}
                <th>Jadwal yang dirubah/diganti</th>
            </tr>
            <tr>
                <td>{{ $suratTukarJaga->nama_pengaju }}</td>
                {{-- <td>......</td> --}}
                {{-- <td>......</td> --}}
                <td>{{ \Carbon\Carbon::parse($suratTukarJaga->jadwal_asli)->format('d-m-Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($suratTukarJaga->jadwal_dirubah)->format('d-m-Y')}}</td>

            </tr>
            <tr>
                <th>Nama Karyawan</th>
                {{-- <th>Tgl</th> --}}
                <th>Jadwal Asli</th>
                {{-- <th>Tgl</th> --}}
                <th>Jadwal yang dirubah/diganti</th>
            </tr>
            <tr>
                <td>{{ $suratTukarJaga->target_tukar_jaga}}</td>
                {{-- <td>......</td> --}}
                <td>{{ \Carbon\Carbon::parse($suratTukarJaga->jadwal_dirubah)->format('d-m-Y')}}</td>
                {{-- <td>......</td> --}}
                <td>{{ \Carbon\Carbon::parse($suratTukarJaga->jadwal_asli)->format('d-m-Y')}}</td>
            </tr>
        </table>
        <p>Tgl. PENYERAHAN BLANKO</p>
        <div class="tgl_blangko"></div>
        <div class="ttd_A">
            <p>Yang Memohon, <b>{{ $suratTukarJaga->nama_pengaju }}</b>
            </p>
            <p>
          
                    <img style="height: 120px ; width:120px;"
                        src="{{ public_path('assets/ttd/' . $suratTukarJaga->tanda_tangan) }}" alt="Tanda Tangan">
          
            </p>
            <p><b>{{ $suratTukarJaga->nama_pengaju }}</b></p>
        </div>

        <div class="ttd_B">
            <p>Termohon, <b>{{ $suratTukarJaga->target_tukar_jaga}}<b></p>
            @if ($suratTukarJaga->termohon)
            <img style="height: 120px ; width:120px;"
                src="{{ public_path('assets/ttd/' . $suratTukarJaga->termohon) }}" alt="Tanda Tangan">
        @endif
        <p><b>{{ $suratTukarJaga->target_tukar_jaga}}<b></p>
        </div>

        <div class="ttd_kar">
            <p>Ka. Ruangan</p>
            @if ($suratTukarJaga->kepala_ruangan)
            <img style="height: 120px ; width:120px;"
                src="{{ public_path('assets/ttd/' . $suratTukarJaga->kepala_ruangan) }}" alt="Tanda Tangan">
        @endif
        <p><b>{{ $suratTukarJaga->nama_kepala_ruangan }}</b></p>
        </div>
        <div class="ttd_kab">
            <p>Ka. Bagian</p>
            @if ($suratTukarJaga->kepala_bagian)
            <img style="height: 120px ; width:120px;"
                src="{{ public_path('assets/ttd/' . $suratTukarJaga->kepala_bagian) }}" alt="Tanda Tangan">
        @endif
        <p><b>{{ $suratTukarJaga->nama_kepala_bagian }}</b></p>
        </div>
        </div>
</body>

</html>
