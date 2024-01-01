@extends('layouts.appdashboardmobile')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="../css/cutimobile.css">

    <div class="container">
        <div class="card-header">
            <div class="icon-back" onclick="goBack()">
                <i class='bx bx-arrow-back'></i>
            </div>
            <h1><b>Ajukan Permohonan Cuti</b></h1>
        </div>
        <div class="card-body">
            <Form method="POST" action="{{route('suratcuti.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="content-text">
                    <h3>Tanggal Mulai</h3>
                </div>
                <div class="content-box">
                    <input class="input_waktu" type="date" id="Tanggal_Mulai" name="tanggal_mulai"
                    onchange="checkDate('Tanggal_Mulai')">
                </div>
                <!-- Popup -->
                <div class="popup-tgl" id="myPopup-tgl">
                    <!-- Isi popup di sini -->
                    <i class='bx bx-error'></i>
                    <b>Tanggal telah lewat!!!</b>
                </div>

                <div class="content-text">
                    <h3>Tanggal Selesai</h3>
                </div>
                <div class="content-box">
                    <input class="input_waktu" type="date" id="Tanggal_izin" name="tanggal_selesai"
                    onchange="checkDate('Tanggal_izin')">
                </div>
                <!-- Popup -->
                <div class="popup-tgl-sel" id="myPopup-tgl-sel">
                    <!-- Isi popup di sini -->
                    <i class='bx bx-error'></i>
                    <b>Tanggal selesai salah!!!</b>
                </div>

                <div class="content-text">
                    <h3>Bagian</h3>
                </div>
                <div class="content-box">
                    <input class="input_waktu" type="text" id="keterangan" placeholder="Bagian" name="bagian">
                </div>
    
                <div class="content-text">
                    <h3>Alamat</h3>
                </div>
                <div class="content-box">
                    <input class="input_waktu" type="text" id="keterangan" placeholder="alamat" name="alamat">
                </div>
    
                <div class="content-text">
                    <h3>Jabatan</h3>
                </div>
                <div class="content-box">
                    <input class="input_waktu" type="text" id="keterangan" placeholder="jabatan" name="jabatan">
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
            </Form>

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
                                fill="#E6EFFA" />
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
</script>
<script>
    function checkDate(inputId) {
        var inputDate = document.getElementById(inputId).value;
        var today = new Date().toISOString().split('T')[0];
        var startDate =document.getElementById('Tanggal_Mulai').value;
        var endDate =document.getElementById('Tanggal_izin').value;

        if (inputDate < today) {
            showPopup();
            // Tambahkan logika atau tindakan lain yang sesuai
            document.getElementById(inputId).value = "";
        } else if(endDate != "" && endDate < startDate ){
        showPopupSel();
        document.getElementById("Tanggal_Mulai").value = "";
        document.getElementById("Tanggal_izin").value = "";
    }
    }
    function showPopup() {
        var popup = document.getElementById("myPopup-tgl");
        var overlay = document.getElementById("overlay_berhasil")
        popup.style.display = "block"; // Tampilkan popup
        overlay.style.display = "block";
        setTimeout(function () {
            popup.style.display = "none";
            overlay.style.display = "none"; // Setelah beberapa waktu, sembunyikan kembali popup
        },2000); // Misalnya, disetel untuk hilang setelah 3 detik (3000 milidetik)
    }
    function showPopupSel() {
        var popup = document.getElementById("myPopup-tgl-sel");
        var overlay = document.getElementById("overlay_berhasil")
        popup.style.display = "block"; // Tampilkan popup
        overlay.style.display = "block";
        setTimeout(function () {
            popup.style.display = "none";
            overlay.style.display = "none"; // Setelah beberapa waktu, sembunyikan kembali popup
        },2000); // Misalnya, disetel untuk hilang setelah 3 detik (3000 milidetik)
    }

    function goBack() {
        window.history.back();
    }
</script>
