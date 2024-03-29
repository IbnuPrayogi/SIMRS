<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Surat</title>
    <link rel="stylesheet" href="{{ public_path('css/templateizin.css') }}">
</head>
<body>
    <p style="margin-left:65%">Karang Endah,{{ \Carbon\Carbon::parse($suratIzin->updated_at)->format('d-m-Y') }}
    </p>
    <div class="kepada">
        <p> Kepada Yth,<br>
            Ibu Direktur RS. Islam Asy-Syifaa<br>
            Di<br>
            Tempat
        </p>
    </div>
    <p><b>Assalamu’alaikum Wr. Wb.</b></p>
    <p> Saya yang bertandatangan di bawah ini:</p>
    <p>Nama Pengaju : {{ $suratIzin->nama_pengaju }} <br>
        Bagian      : {{ $suratIzin->bagian }}
    </p>
    <div class="keterangan">
        <p>Bersama Surat ini Saya sampaikan bahwa pada tanggal <b>{{ \Carbon\Carbon::parse($suratIzin->tanggal_izin)->format('d-m-Y') }}</b> Saya tidak
            dapat bekerja seperti biasa,
            dikarenakan ada <b>{{ $suratIzin->keterangan }}</b>. Mohon kiranya Ibu Direktur dapat memberikan izin kepada
            Saya.
        </p>
    </div>
    <p>Demikian Surat ini Saya sampaikan, atas Izin yang diberikan saya ucapkan terima kasih.</p>
    <p><b>Wassalamu’alaikum Wr. Wb.</b></p>
    <div class="tanda_tangan">
        <div class="ttd_aju">
            <p> Mengetahui,<br>
                Manager Keuangan Umum & Personalia
            </p>
            @if ($suratIzin->tanda_tangan_direktur)
                <img style="height: 120px ; width:120px;"
                    src="{{ public_path('assets/ttd/'.$suratIzin->tanda_tangan_direktur) }}" alt="Tanda Tangan">
            @endif
            <p><b>dr. Imilia Sapitri, M.Kes</b></p>
        </div>
        <div class="ttd_nama">

    </div>
</body>
</html>

