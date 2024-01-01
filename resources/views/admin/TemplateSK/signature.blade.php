<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan</title>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
</head>

<body>
    <section class="border">
        <div class="container py-5" style="background-color:; border-radius: 25px;">
            <div class="container mt-5 Border">
                <div class="row">
                    <div class="col-md-8 mx-auto">

                        <div class="text-center mb-4">
                            <h2>Undangan</h2>
                        </div>

                        <p class="font-weight-bold">Perihal: {{ $templateSK->perihal }}</p>

                        <p>Kepada Yth,<br>
                            Daftar Peserta Terlampir<br>
                            di<br>
                            Tempat
                        </p>

                        <p>Assalamu’alaikum Wr. Wb.</p>

                        <p>Melalui Surat ini Kami bermaksud mengundang Bapak/Ibu/Sdr untuk mengikuti Simulasi Pemadam
                            Kebakaran pada :</p>

                        <ul>
                            <li>Hari/Tanggal : {{ $templateSK->hari_tanggal }}</li>
                            <li>Waktu : Pukul {{ $templateSK->waktu }} s/d selesai</li>
                            <li>Tempat : {{ $templateSK->tempat }}</li>
                        </ul>

                        <p>Mengingat pentingnya acara tersebut, maka Kami mengharapkan Bapak/Ibu/Sdr. dapat meluangkan
                            waktu
                            untuk datang tepat pada waktunya.</p>

                        <p>Demikian Memo ini Kami sampaikan, atas kehadirannya Kami ucapkan terima kasih.</p>

                        <p>Wassalamu’alaikum Wr. Wb.</p>

                        <p class="text-right">Bandar Jaya, {{ $templateSK->tanggal_surat }}</p>

                            @if ($templateSK->tanda_tangan)
                        <img src="{{public_path('assets/ttd/'.$templateSK->tanda_tangan)}}" alt="" style="max-height: 150px;max-width:150px">
                            @endif

                            <p class="text-right">Direktur RS. Islam Asy-Syifaa</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
