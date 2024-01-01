@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="../css/tukarjagamobile.css">

<div class="container">
    <div class="card-header">
        <h1><b>Ajukan Tukar Jaga</b></h1>
    </div>
    <div class="card-body">
        <form>
            <div class="content-text">
                <h3>Jadwal asli</h3>
            </div>
            <div class="content-box">
                <input class="input_waktu" type="date" id="Tanggal_Mulai" name="tanggal_mulai">
            </div>

            <div class="content-text">
                <h3>Jadwal yang ingin diubah</h3>
            </div>
            <div class="content-box">
                <input class="input_waktu" type="date" id="Tanggal_izin" name="tanggal_selesai">
            </div>

            <div class="content-text">
                <h3>Nama target</h3>
            </div>
            <div class="dropdown-menu">
                <select class="select">
                    <option value="">Pilih Nama Target</option>
                    <option value="first">Astra</option>
                    <option value="second">Brimstone</option>
                    <option value="third">Viper</option>
                </select>
                <div class="icon">
                    <i class='bx bx-chevron-down'></i>
                </div>
            </div>

            <div class="content-text">
                <h3>Keterangan</h3>
            </div>
            <div class="content-ket">
                <textarea class="input_ket" type="text" id="keterangan" placeholder="Alasan..." name="keterangan"></textarea>
            </div>

            <!-- Button trigger modal -->
            <button type="submit" onclick="notifSukses()" class="btn btn-primary">
                Buat Pengajuan
            </button>
        </form>

        <div id="overlay_berhasil" class="overlay_berhasil" style="display: none;"></div>
        <div class="notif_berhasil" style="display: none;">
            <div class="info_pengajuan">
                <h1><b>Pengajuan Tukar Jaga Berhasil Dibuat</b></h1>
            </div>
            <div class="icon_sukses">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120"
                    fill="none">
                    <circle cx="60" cy="60" r="60" fill="#0253BA" />
                </svg>
                <div class="ceklis">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="67" viewBox="0 0 80 67"
                        fill="none">
                        <path
                            d="M28.4408 50.124L11.3807 33.0638C8.7772 30.4603 4.55611 30.4603 1.95262 33.0638C-0.650872 35.6673 -0.650872 39.8884 1.95262 42.4919L24.1748 64.7141C26.9468 67.4861 31.5006 67.2795 34.0103 64.2679L78.4546 10.9347C80.8117 8.1062 80.4296 3.90244 77.6011 1.54536C74.7726 -0.811733 70.5688 -0.429574 68.2117 2.39893L28.4408 50.124Z"
                            fill="#E6EFFA"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function notifSukses() {
        var notifBerhasil = document.querySelector('.notif_berhasil');
        var overlay_berhasil = document.getElementById("overlay_berhasil");
        var popup = document.getElementById("myPopup");
        var overlay = document.getElementById("overlay");
        var prosesButton = document.getElementById("prosesButton");

        if (notifBerhasil.style.display === "none") {
            notifBerhasil.style.display = "block";
            overlay_berhasil.style.display = "block";
            popup.style.display = "none";
            overlay.style.display = "none";
            prosesButton.style.display = "none";

            // Sembunyikan notifikasi setelah 5 detik (5000 milidetik)
            setTimeout(function() {
                notifBerhasil.style.display = "none";
                overlay_berhasil.style.display = "none";
            }, 1000);
        } else {
            notifBerhasil.style.display = "none";
            overlay_berhasil.style.display = "none";
        }
    }

    const dropdowns = document.querySelectorAll('.dropdown-menu');

    dropdowns.array.forEach(dropdown => {
        const select = dropdown.querySelector('.select');
        const caret = dropdown.querySelector('.caret');
        const optionslist = dropdown.querySelector('.options-list');
        const options = dropdown.querySelector('.options-list li');
        const selected = dropdown.querySelector('.selected');

        select.addEventListener('click', () => {
            select.classList.toggle('select-clicked');
            caret.classList.toggle('caret-rotate');
            optionslist.classList.toggle('menu-open');
        });

        options.forEach(option => {
            option.addEventListener('click', () => {
                selected.innerText = option.innerText;
                select.classList.remove('select-clicked');
                caret.classList.remove('caret-rotate');
                optionslist.classList.remove('menu-open');
                options.forEach(option => {
                    option.classList.remove('active');
                });
                option.classList.add('active');
            });
        });
    });

    // Mendapatkan elemen input tanggal pertama dengan id Tanggal_Mulai
var tanggalMulaiInput = document.getElementById('Tanggal_Mulai');

// Mendapatkan elemen input tanggal kedua dengan id Tanggal_izin
var tanggalIzinInput = document.getElementById('Tanggal_izin');

// Mendapatkan tanggal hari ini
var today = new Date().toISOString().split('T')[0];

// Mengatur nilai minimum pada elemen input tanggal pertama ke hari ini
tanggalMulaiInput.setAttribute('min', today);

// Mengatur nilai minimum pada elemen input tanggal kedua ke hari ini
tanggalIzinInput.setAttribute('min', today);

// Mengatur event listener untuk memastikan tanggal kedua tidak lebih kecil dari tanggal pertama
tanggalMulaiInput.addEventListener('change', function() {
    tanggalIzinInput.setAttribute('min', this.value);
});

</script>