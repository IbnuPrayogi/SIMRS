@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="css/homemobile.css">

<div class="container">
    <div class="card-header">
        <h1><b>Halo, Nama User</b></h1>
    </div>
    <div class="card-body">
        <div class="card-content">
            <h2>Tukar Jaga</h2>
            <a href="{{ route('surattukarjaga.create') }}"><i class='bx bx-right-arrow-circle row1' ></i></a>
        </div>
        <div class="card-content">
            <h2>Permohonan Cuti</h2>
            <a href="{{ route('suratcuti.create') }}"><i class='bx bx-right-arrow-circle row2' ></i></a>
        </div>
        <div class="card-content">
            <h2>Permohonan Izin</h2>
            <a href="{{ route('suratizin.create') }}"><i class='bx bx-right-arrow-circle row2' ></i></a>
        </div>
    </div>
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