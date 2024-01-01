<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Surat</title>
    <link rel="stylesheet" href="{{ public_path('css/templateizin.css') }}">
</head>
<body>
    <p style="margin-left:65%">Karang Endah,{{ $suratIzin->updated_at->format('d F Y') }}
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
        <p>Bersama Surat ini Saya sampaikan bahwa pada tanggal <b>{{ $suratIzin->tanggal_izin }}</b> Saya tidak
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
                <br><br><br><br>
                <b>Nurul Hakim, SE</b>
            </p>
        </div>
        <div class="ttd_nama">
            <p> <br>
                Hormat Saya,
                <br>
            </p>
            <p>
                @if ($suratIzin->tanda_tangan)
                    <img style="height: 120px ; width:120px;"
                        src="{{ public_path('img/' . $suratIzin->tanda_tangan) }}" alt="Tanda Tangan">
                @endif
            </p>
            <b>{{ $suratIzin->nama_pengaju }}</b>
            <p></p>
        </div>
    </div>
</body>
</html>
