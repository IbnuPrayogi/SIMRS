@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perizinan Rumah Sakit</title>
    <style>
        /* Gaya CSS dapat disesuaikan sesuai kebutuhan */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            text-decoration: underline;
        }
        p {
            line-height: 1.5;
            text-align: justify;
        }
        /* Tambahkan gaya CSS tambahan sesuai kebutuhan */
    </style>
</head>
<body>
    <div class="container">
        <h2>Surat Perizinan Rumah Sakit</h2>

        <p>
            Dengan hormat,
        </p>

        <p>
            Bersama surat ini, kami bermaksud untuk memohon perizinan kepada pihak terkait untuk kegiatan sebagai berikut:
        </p>

        <h3>Detail Kegiatan:</h3>
        <ul>
            <li>Nama Kegiatan: [Nama Kegiatan]</li>
            <li>Tanggal Pelaksanaan: [Tanggal Pelaksanaan]</li>
            <li>Tempat Pelaksanaan: [Tempat Pelaksanaan]</li>
            <!-- Tambahkan detail kegiatan sesuai kebutuhan -->
        </ul>

        <p>
            Kegiatan ini dilakukan sesuai dengan aturan dan regulasi yang berlaku di bidang kesehatan. Kami akan memastikan bahwa kegiatan ini tidak menimbulkan dampak negatif dan mengikuti protokol kesehatan yang berlaku.
        </p>

        <p>
            Sebagai bentuk tanggung jawab kami, kami siap menyediakan dokumen dan informasi tambahan yang diperlukan terkait kegiatan ini.
        </p>

        <p>
            Demikian surat permohonan ini kami buat dengan sebenar-benarnya dan kami harapkan untuk mendapatkan persetujuan dari pihak terkait.
        </p>

        <p>
            Terima kasih atas perhatian dan kerjasamanya.
        </p>

        <p>
            Hormat kami,
            <br>
            [Nama Rumah Sakit]
        </p>
    </div>
</body>
</html>

</html>

@endsection
