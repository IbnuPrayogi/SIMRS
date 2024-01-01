@extends('layouts.appdashboardmobile')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="../css/tukarjagamobile.css">

    <div class="container">
        <form method="post" action="{{route('surattukarjaga.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <div class="icon-back" onclick="goBack()">
                    <i class='bx bx-arrow-back'></i>
                </div>
                <h1><b>Ajukan Tukar Jaga</b></h1>
            </div>
            <div class="card-body">
                <div class="content-text">
                    <h3>Jadwal Asli</h3>
                </div>
                <div class="content-box">
                    <input class="input_waktu" type="date" id="Tanggal_Pengajuan" placeholder="Tanggal Pengajuan..."
                        name="jadwal_asli" onchange="checkDate('Tanggal_Pengajuan')">
                </div>
                <!-- Popup -->
                <div class="popup-tgl" id="myPopup-tgl">
                    <!-- Isi popup di sini -->
                    <i class='bx bx-error'></i>
                    <b>Tanggal yang dimasukkan telah lewat</b>
                </div>

                <div class="content-text">
                    <h3>Jadwal Yang Ingin Diubah</h3>
                </div>
                <div class="content-box">
                    <input class="input_waktu" type="date" id="Tanggal_Target" placeholder="Tanggal Target..." name="jadwal_dirubah"
                    onchange="checkDate('Tanggal_Target')">
                </div>
                <!-- Popup -->
                <div class="popup-tgl" id="myPopup-tgl">
                    <!-- Isi popup di sini -->
                    <i class='bx bx-error'></i>
                    <b>Tanggal yang dimasukkan telah lewat</b>
                </div>

                <div class="content-text">
                    <h3>Nama Target</h3>
                </div>
                <div class="dropdown-menu">
                    <select class="select" name="target_tukar_jaga">
                        <option value="">Pilih Nama Target</option>
                        @foreach ($karyawan as $user)
                        @if ($user->nama_karyawan!= auth()->user()->nama_karyawan)
                        <option value="{{ $user->nama_karyawan }}">{{ $user->nama_karyawan }}</option>
                        @endif
                        @endforeach
                    </select>
                    <div class="icon">
                        <i class='bx bx-chevron-down'></i>
                    </div>
                </div>

                <div class="content-text">
                    <h3>Keterangan</h3>
                </div>
                <div class="content-ket">
                    <textarea class="input_ket" type="text" id="keterangan" placeholder="Keterangan..." name="keterangan"></textarea>
                </div>

                <!-- Button trigger modal -->
                <button onclick="togglePopup()" class="btn btn-primary">
                    Buat Pengajuan
                </button>
        </form>

        <div id="overlay_berhasil" class="overlay_berhasil" style="display: none;"></div>
        <div class="notif_berhasil" style="display: none;">
            <div class="info_pengajuan">
                <h1><b>Pengajuan Tukar Jaga Berhasil Dibuat</b></h1>
            </div>
            <div class="icon_sukses">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" fill="none">
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
    // Fungsi untuk menampilkan pop-up
    function togglePopup() {
        var notifBerhasil = document.querySelector('.notif_berhasil');
        var overlay_berhasil = document.getElementById("overlay_berhasil");

        if (overlay_berhasil.style.display === "none" || notifBerhasil.style.display === "none") {
            notifBerhasil.style.display = "block";
            overlay_berhasil.style.display = "block";
        } else {
            notifBerhasil.style.display = "block";
            overlay_berhasil.style.display = "block";
        }
        setTimeout(function() {
            notifBerhasil.style.display = "none";
            overlay_berhasil.style.display = "none";
        }, 1000);
    }

    document.getElementById('fileInput').addEventListener('change', function() {
        var selectedFile = this.files[0];

        if (selectedFile) {
            // Di sini Anda dapat mengirimkan gambar yang dipilih ke server atau melakukan tindakan lain sesuai kebutuhan Anda.
            // Misalnya, Anda dapat menggunakan FormData untuk mengirim gambar tersebut ke server.
            // Contoh:
            var formData = new FormData();
            formData.append('profile_image', selectedFile);

            // Selanjutnya, Anda dapat melakukan pengiriman data ini ke server menggunakan XMLHttpRequest atau fetch.

            // Setelah pengiriman gambar berhasil, Anda dapat melakukan tindakan seperti menampilkan gambar profil yang baru.
            // Anda juga dapat menyimpan gambar tersebut di server dan mengatur URL gambar profil.
        }
    });
</script>
<script>
    function checkDate(inputId) {
        var inputDate = document.getElementById(inputId).value;
        var today = new Date().toISOString().split('T')[0];
        var startDate =document.getElementById('Tanggal_Pengajuan').value;
        var endDate =document.getElementById('Tanggal_Target').value;

        if (inputDate < today) {
            showPopup();
            document.getElementById(inputId).value="";
            // Tambahkan logika atau tindakan lain yang sesuai
            document.getElementById(inputId).value = "";
        } else if(endDate != "" && endDate < startDate ){
        showPopup();
        document.getElementById("Tanggal_Pengajuan").value = "";
        document.getElementById("Tanggal_Target").value = "";
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
    function goBack() {
        window.history.back();
    }
</script>
