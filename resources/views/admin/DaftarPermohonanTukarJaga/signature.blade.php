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
 
   

        <div class="ttd_kar">
            <p>Direktur</p>
            @if ($suratTukarJaga->tanda_tangan_direktur)
            <img style="height: 120px ; width:120px;"
                src="{{ public_path('assets/ttd/' . $suratTukarJaga->tanda_tangan_direktur) }}" alt="Tanda Tangan">
        @endif
        <p><b>dr. Imilia Sapitri, M.Kes</b></p>
        </div>

        </div>
</body>

</html>
