@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="css/homemobile.css">

<div class="screen">
    <div class="overlap">
      <div class="statistik-data">
        <div class="jumlah-arsip">
          <div class="overlap-group"><div class="text-wrapper">Lihat Permohonan</div></div>
          <div class="div-wrapper"><div class="div"><img src="/img/clock.png" alt="clock" style="width:70%;"></div></div>
        </div>
        <div class="kategori-arsip">
          <div class="overlap-group"><div class="text-wrapper-2">Buat Permohonan</div></div>
          <div class="div-wrapper"><div class="text-wrapper-3"><img src="/img/file.png" alt="file" style="width:70%;"></div></div>
        </div>
        <div class="overlap-2">
          <div class="text-wrapper-4">Malam</div><br><br><br>
          <div style="text-align: center;">
            <img src="/img/calendar.png" alt="calendar" style="width:50%">
          </div><br>
          <div class="text-wrapper-5">Jadwal Hari Ini</div>
        </div>
      </div>
      <div class="rectangle"></div>
      <div class="rectangle-2"></div>
      <div class="rectangle-3"></div>
      <img class="arrow" src="img/arrow-3.svg" />
      <a href="{{ route('lihat.pengajuan') }}"><div class="text-wrapper-6">Selengkapnya</div></a>
      <img class="img" src="img/arrow-5.svg" />
      <a href="{{  route('karyawanjadwal.index')  }}"><div class="text-wrapper-7">Selengkapnya</div></a>
      <img class="arrow-2" src="img/arrow-4.svg" />
      <a href="{{ route('presensi.karyawan') }}\"></a><div class="text-wrapper-8">Selengkapnya</div>
    </div>
    <div class="title">
      <div class="overlap-3"><div class="text-wrapper-9">Rs Islam Asy Syifaa</div></div>
    </div>
    <div class="halo-karyawan">Halo,<br />{{ auth()->user()->nama_karyawan }}</div>
  </div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
    var container = document.querySelector('.container');
    var cardBody = document.querySelector('.card-body');

    // Fungsi untuk mengatur overflow berdasarkan ukuran konten dan container
    function checkOverflow() {
        if (cardBody.scrollHeight > container.clientHeight) {
            cardBody.style.overflowY = 'scroll'; // Jika melebihi, atur overflow menjadi scroll
        } else {
            cardBody.style.overflowY = 'hidden'; // Jika tidak, sembunyikan overflow
        }
    }

    // Panggil fungsi saat dokumen dimuat dan saat window di-resize
    checkOverflow();
    window.addEventListener('resize', checkOverflow);
});

</script>
@endsection