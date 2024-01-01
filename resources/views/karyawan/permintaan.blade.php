@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href=" {{ asset('css/statusmobile.css') }}">

<div class="container">
    <div class="card-header">
        <div class="icon-back" onclick="goBack()">
            <i class='bx bx-arrow-back'></i>
        </div>
        <h1><b>Daftar permohonan tukar jaga</b></h1>
    </div>
    <div class="card-body">
        <div class="gabung_box">
            @foreach ($surattukarjaga as $surat)
                
            <div class="content-box">
                @if ($surat->status != 'disetujui')
                <div class="icon-time">
                    <i class='bx bx-time' ></i>
                </div>
                @else
                <div class="icon-check">
                    <i class='bx bx-check'></i>
                </div>
                @endif
                
                <div class="info">
                    <h1>{{ $surat->nama_surat }}</h1>
                    <p>Status: menunggu {{ $surat->status }}</p>
                    <p>diajukan: {{ \Carbon\Carbon::parse($surat->created_at)->format('d-m-Y') }}</p>
                </div>
                
                <div class="list">
                    <div class="svg_container_unduh" onclick="toggleUnduh(this)">
                        <i class='bx bx-dots-vertical-rounded dots'></i>
                    </div>
                    <div class="popup_unduh" id="svgPopupUnduh" style="display: none">
                        <div class="unduh-permintaan">
                            <a href="{{ route('statustukarjaga.download', ['id' => $surat->id, 'file' => $surat->file]) }}"><h1>Unduh</h1></a>
                        </div>
                        <div class="click_batal" onclick="toggleOpsi(this)">
                            <h1>Tolak</h1>
                        </div>
                        <div class="click_ttd" onclick="toggleTanda(this)">
                            <h1>Tanda Tangani</h1>
                        </div>
                    </div>
                </div>
                

            </div>

            @endforeach
  
        </div>
        <div class="pencarian">
            <div class="search">
                <i class='bx bx-search'></i>
            </div>
            <input type="text" id="cariInput" class='pencarian_user' placeholder="Cari nama petugas">
        </div>
    </div>
    <script>
    function toggleBatal(clickedElement) {
        // Traverse the DOM to find the related popup within the clicked content-box
        var contentBox = clickedElement.closest('.content-box');
        var popup = contentBox.querySelector('.popup_batal');

        if (popup.style.display === "none") {
            // Show the popup
            popup.style.display = "block";
        } else {
            // Hide the popup
            popup.style.display = 'none';
        }
    }

    function toggleOpsi(clickedElement) {
        var contentBox = clickedElement.closest('.content-box');
        var popupOptions = contentBox.querySelector('.popup-options');
        var overlay = document.querySelector('.overlay_daftar');
        var popup = contentBox.querySelector('.popup_batal');

        if (popupOptions.style.display === "none") {
            popupOptions.style.display = 'block';
        } else {
            popupOptions.style.display = 'none';
        }

 
        var buttonsTidak = popupOptions.querySelectorAll('.button_tidak');

        buttonsYa.forEach(function(button) {
        button.addEventListener('click', function() {
            // Hapus content-box saat tombol "Ya" diklik
   
        });
    });

        buttonsTidak.forEach(function(button) {
        button.addEventListener('click', function() {
            // Sembunyikan popup saat tombol "Tidak" diklik
            popupOptions.style.display = 'none';
            overlay.style.display = 'none';
            popup.style.display = 'none';
        });
    });
    }

    function toggleUnduh(clickedElement) {
        var contentBox = clickedElement.closest('.content-box');
        var unduh = contentBox.querySelector('.popup_unduh');

        if (unduh.style.display == 'none') {
            unduh.style.display = 'block';
        } else {
            unduh.style.display = 'none';
        }
    }

    function toggleTanda(clickedElement) {
        var contentBox = clickedElement.closest('.content-box');
        var ttd = contentBox.querySelector('.click_ttd');

        if (ttd.style.display == 'none') {
            ttd.style.display = 'block';
        } else {
            ttd.style.display = 'none';
        }
    }

    function cariData() {
    var input = document.getElementById('cariInput').value.toLowerCase();

    // Loop melalui setiap elemen dengan class "content-box"
    var boxes = document.querySelectorAll('.content-box');  
    for (var i = 0; i < boxes.length; i++) {
        var box = boxes[i];
        var info = box.querySelector('.info');
        var pengguna = info.querySelector('h1').textContent.toLowerCase();

        // Bandingkan nilai "pengguna" dengan input pencarian
        if (pengguna.includes(input)) {
            // Hapus kelas "hidden" jika ada
            box.classList.remove('hidden');
        } else {
            // Periksa apakah kelas 'hidden' sudah ada sebelum menambahkannya
            if (!box.classList.contains('hidden')) {
                // Sembunyikan elemen yang tidak cocok dengan kelas "hidden"
                box.classList.add('hidden');
            }
        }
    }
}
// Memanggil fungsi cariData() saat input berubah
document.getElementById('cariInput').addEventListener('input', cariData);

function goBack() {
        window.history.back();
    }
</script>
</div>
@endsection