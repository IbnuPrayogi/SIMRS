@extends('layouts.appdashboardmobile')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="../css/cutimobile.css">

    <div class="container">
        <div class="card-header">
            <a href="/buatpengajuansurat">
                <div class="icon-back">
                    <i class='bx bx-arrow-back'></i>
                </div>  
            </a>
            
            <h1><b>Ajukan Permohonan Cuti</b></h1>
        </div>
        <div class="card-body">
            <Form method="POST" action="{{route('suratcuti.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="content-text">
                    <h3 style="margin-bottom: 20px">Tanggal Mulai</h3>
                </div>
                <div class="content-box" style="border-radius: 10px">
                    <input class="input_waktu" type="date" id="Tanggal_Mulai" name="tanggal_mulai"
                    onchange="checkDate('Tanggal_Mulai')">
                </div>
                <!-- Popup -->
                <div class="popup-tgl" id="myPopup-tgl">
                    <!-- Isi popup di sini -->
                    <i class='bx bx-error'></i>
                    <b>Tanggal telah lewat!!!</b>
                </div>

                <div class="popup-tgl" id="myPopup-tgl-warning">
                    <!-- Isi popup di sini -->
                    <i class='bx bx-error'></i>
                    <b>Jumlah Cuti Bulan ini Telah Mencapai Batas Maksimal</b>
                </div>

                <div class="popup-tgl" id="myPopup-tgl-month" style="text-align:center;margin-right:90px">
                    <!-- Isi popup di sini -->
                    <i class='bx bx-error'></i>
                    <b>Tanggal Mulai dan Tanggal Selesai Harus Dalam Bulan yang sama</b>
                </div>

                <div class="popup-tgl" id="myPopup-tgl-limit" style="margin-left:10px">
                    <!-- Isi popup di sini -->
                    <i class='bx bx-error'></i>
                    <b>Ajukan Cuti maksimal 1 bulan sebelum </b>
                </div>

                <div class="content-text">
                    <h3 style="margin-bottom: 20px">Tanggal Selesai</h3>
                </div>
                <div class="content-box" style="border-radius: 10px">
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
                    <h3 style="margin-bottom: 20px">Alamat</h3>
                </div>
                <div class="content-box" style="padding: 5px;border-radius: 10px">
                    <input class="input_waktu" type="text" id="keterangan" placeholder="alamat" name="alamat">
                </div>
    
                <div class="content-text">
                    <h3 style="margin-bottom: 20px">Keterangan</h3>
                </div>
                <div class="content-ket" style="padding: 5px;">
                    <textarea class="input_ket" type="text" id="keterangan" placeholder="Alasan..." name="keterangan"></textarea>
                </div>
    
                <!-- Button trigger modal -->
                <button type="submit" onclick="" class="btn btn-primary">
                    Buat Pengajuan
                </button>
            </Form>

            <div id="overlay_berhasil" class="overlay_berhasil" style="display: none;"></div>
            <div class="notif_berhasil" style="display: none;">
                <div class="info_pengajuan">
                    <h1><b>Pengajuan Cuti Berhasil Dibuat</b></h1>
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
    <div id="myElement"></div>
    <script>
        @if(Session::has('permission_limit_exceeded'))
            showPopupWarning("{{ Session::get('permission_limit_exceeded') }}");
        @elseif(Session::has('success'))
            notifSukses()
        @endif
    </script>
@endsection

<script>
function notifSukses() {
    var notifBerhasil = document.querySelector('.notif_berhasil');
    var overlay_berhasil = document.getElementById("overlay_berhasil");

    if (notifBerhasil.style.display === "none") {
        notifBerhasil.style.display = "block";
        overlay_berhasil.style.display = "block";

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
        var startDate = document.getElementById('Tanggal_Mulai').value;
        var endDate = document.getElementById('Tanggal_izin').value;
        var dateDifference = getDateDifference(today, startDate);
        


        if (inputDate < today) {
            showPopup();
            // Tambahkan logika atau tindakan lain yang sesuai
            document.getElementById(inputId).value = "";
            document.getElementById("keterangan").value = (today-startDate);
        } else if (endDate != "" && endDate < startDate) {
            showPopupSel();
            document.getElementById("Tanggal_Mulai").value = "";
            document.getElementById("Tanggal_izin").value = "";
        } else if ( dateDifference < 30) {
            showPopupLimit();
            document.getElementById("Tanggal_Mulai").value = "";
            // Contoh: document.getElementById(inputId).value = "";
        }
        else if ( endDate!="" && isTwoMonthsApart(startDate, endDate)) {
            // Tindakan yang ingin Anda lakukan jika tanggal berada dalam dua bulan yang berbeda
            // Misalnya, menampilkan pesan kesalahan
            showPopupMonth()
            document.getElementById(inputId).value = "";
        }
    }
    function getDateDifference(date1, date2) {
    // Implementasikan logika perbedaan tanggal di sini
    // Misalnya, hitung selisih hari
        var diffInMilliseconds = new Date(date2) - new Date(date1);
        var diffInDays = Math.floor(diffInMilliseconds / (24 * 60 * 60 * 1000));
        return diffInDays;
    }

    function isTwoMonthsApart(date1, date2) {
    // Mendapatkan bulan dari tanggal pertama
        var month1 = new Date(date1).getMonth();
        // Mendapatkan bulan dari tanggal kedua
        var month2 = new Date(date2).getMonth();

        // Memeriksa apakah bulan dari kedua tanggal berbeda
        return month1 !== month2;
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
    function showPopupLimit() {
        var popup = document.getElementById("myPopup-tgl-limit");
        var overlay = document.getElementById("overlay_berhasil")
        popup.style.display = "block"; // Tampilkan popup
        overlay.style.display = "block";
        setTimeout(function () {
            popup.style.display = "none";
            overlay.style.display = "none"; // Setelah beberapa waktu, sembunyikan kembali popup
        },2000); // Misalnya, disetel untuk hilang setelah 3 detik (3000 milidetik)
    }

    function showPopupMonth() {
        var popup = document.getElementById("myPopup-tgl-month");
        var overlay = document.getElementById("overlay_berhasil")
        popup.style.display = "block"; // Tampilkan popup
        overlay.style.display = "block";
        setTimeout(function () {
            popup.style.display = "none";
            overlay.style.display = "none"; // Setelah beberapa waktu, sembunyikan kembali popup
        },2000); // Misalnya, disetel untuk hilang setelah 3 detik (3000 milidetik)
    }

    function showPopupWarning() {
        var popup = document.getElementById("myPopup-tgl-warning");
        var overlay = document.getElementById("overlay_berhasil")
        popup.style.display = "block"; // Tampilkan popup
        overlay.style.display = "block";
        setTimeout(function () {
            popup.style.display = "none";
            overlay.style.display = "none"; // Setelah beberapa waktu, sembunyikan kembali popup
        },2000); // Misalnya, disetel untuk hilang setelah 3 detik (3000 milidetik)
    }a

    function goBack() {
        window.history.back();
    }
</script>
