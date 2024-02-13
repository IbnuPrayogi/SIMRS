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
                <td>{{ $suratTukarJaga->jadwal_asli }}</td>
                <td>{{ $suratTukarJaga->jadwal_dirubah }}</td>

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
                <td>{{ $suratTukarJaga->jadwal_dirubah }}</td>
                {{-- <td>......</td> --}}
                <td>{{ $suratTukarJaga->jadwal_asli }}</td>
            </tr>
        </table>
        <p>Tgl. PENYERAHAN BLANKO</p>
        <div class="tgl_blangko">
            <p>ini tanggal penyerahan</p>
        </div>

        <div styleclass="tanda_tangan">
            <div class="ttd_aju">
                <p> Menyetujui,<br>
                    Direktur RSI Asy-Syifaa
                    <br><br><br><br>
                    <b>dr. Imilia Sapitri, M.Kes</b>
                </p>
            </div>
    
        </div>
        </div>
</body>

</html>
