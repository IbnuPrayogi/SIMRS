@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="css/buatpengajuan.css">


    
<style>
  .card-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 5px;
    margin-top: 40px;
    
  }

  .card-content {
    flex: 1;
    height: 250px;
    width: 170px
  }
</style>

<div class="card-container">
    <div class="card-content">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <h2 style="text-align: center;">Cuti</h2><br><br>
            <img src="/img/heart.png" alt="calendar" style="width: 60%; margin-left: 10px;">
            <div style="display: flex; align-items: center; justify-content: center; margin-top: 10px;">
                <a href="{{ route('suratcuti.create') }}"><i class="fas fa-plus"></i></a>
                <i class="fas fa-list-check" style="margin-left: 60px; font-size: 24px;"></i>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <h2>Izin</h2><br><br>
            <img src="/img/plush.png" alt="calendar" style="width: 60%; margin-left: 10px;">
            <div style="display: flex; align-items: center; justify-content: center; margin-top: 10px;">
                <a href="{{ route('suratizin.create') }}"><i class="fas fa-plus"></i></a>
                <i class="fas fa-list-check" style="margin-left: 60px; font-size: 24px;"></i>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <h2>Tukar jaga</h2><br><br>
            <img src="/img/tukar.png" alt="calendar" style="width: 60%; margin-left: 10px;">
            <div style="display: flex; align-items: center; justify-content: center; margin-top: 10px;">
                <a href="{{ route('surattukarjaga.create') }}"><i class="fas fa-plus"></i></a>
                <i class="fas fa-list-check" style="margin-left: 60px; font-size: 24px;"></i>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div style="display: flex; flex-direction: column;">
            <h2>Request</h2>
        </div>
        <a href="{{ route('suratizin.create') }}"><i class="fas fa-plus"></i></a>
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