<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Surat</title>
    <link rel="stylesheet" href="{{ public_path('css/templateizin.css') }}">
    <style>
        /* Tambahkan style khusus untuk posisi div tanda_tangan */
        .tanda_tangan {
          float: right;
          clear: both; /* Menjaga agar elemen berada di sebelah kanan */
          width: 50%; /* Sesuaikan lebar sesuai kebutuhan */
        }
        </style>
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
    <div styleclass="tanda_tangan">
        <div class="ttd_aju">
            <p> Menyetujui,<br>
                Direktur RSI Asy-Syifaa
                <br><br><br><br>
                <b>dr. Imilia Sapitri, M.Kes</b>
            </p>
        </div>

    </div>
</body>
</html>
