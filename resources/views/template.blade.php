@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Undangan</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 mx-auto">

        <div class="text-center mb-4">
          <h2>Undangan</h2>
        </div>

        <p class="font-weight-bold">Perihal: Undangan</p>

        <p>Kepada Yth,<br>
          Daftar Peserta Terlampir<br>
          di<br>
          Tempat
        </p>

        <p>Assalamu’alaikum Wr. Wb.</p>

        <p>Melalui Surat ini Kami bermaksud mengundang Bapak/Ibu/Sdr untuk mengikuti Simulasi Pemadam Kebakaran pada :</p>

        <ul>
          <li>Hari/Tanggal : Rabu, 11 Oktober 2023</li>
          <li>Waktu : Pukul 09.00 WIB (Ontime) s/d selesai</li>
          <li>Tempat : Lahan Belakang RSI</li>
        </ul>

        <p>Mengingat pentingnya acara tersebut, maka Kami mengharapkan Bapak/Ibu/Sdr. dapat meluangkan waktu untuk datang tepat pada waktunya.</p>

        <p>Demikian Memo ini Kami sampaikan, atas kehadirannya Kami ucapkan terima kasih.</p>

        <p>Wassalamu’alaikum Wr. Wb.</p>

        <p class="text-right">Bandar Jaya, 10 Oktober 2023<br>
        Direktur RS. Islam Asy-Syifaa</p>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>


@endsection
