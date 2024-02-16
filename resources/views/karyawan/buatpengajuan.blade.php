@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="css/buatpengajuan.css">

<div class="container" style="margin-top: 2rem">
    <div class="card-header">
        <h1><b>Halo, Nama User</b></h1>
    </div>
    <div class="card-body">
        <div class="card-content">
            <div style="display:flex;flex-direction:column">
                <h2>Tukar Jaga</h2>
                <h3 style="margin-left: 15px;color:#0253BA;">Kuota : 50</h3>
            </div>
            <a href="{{ route('surattukarjaga.create') }}"><i class="fas fa-plus"></i> </i></a>
        </div>
        <div class="card-content">
            <div style="display:flex;flex-direction:column">
                <h2>Permohonan Cuti</h2>
                <h3 style="margin-left: 15px;color:#0253BA;">Kuota : 50</h3>
            </div>
            <a href="{{ route('suratcuti.create') }}"><i class="fas fa-plus"></i> </a>
        </div>
        <div class="card-content">            
        <div style="display:flex;flex-direction:column">
            <h2>Permohonan Izin</h2>
            <h3 style="margin-left: 15px;color:#0253BA;">Kuota : 50</h3>
        </div>
            <a href="{{ route('suratizin.create') }}"><i class="fas fa-plus"></i> </a>
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