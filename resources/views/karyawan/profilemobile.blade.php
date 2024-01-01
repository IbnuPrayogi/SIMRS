@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="css/profilemobile.css">
<style>
    /* Style the container */
    .file-input-container {
        position: relative;
        overflow: hidden;
        border: 2px solid #3498db; /* Blue color */
        border-radius: 5px;
        margin-top: 240px;
        background: #0253BA;
        color: white;
        width: 90%;
        height: 40px;
        text-align: center;
        text-justify: auto;
       
    
    }

    /* Style the actual file input */
    .real-file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container">
    <div class="card">
        <h1>Profile Karyawan</h1>
    </div>
    <div class="card-body">
        <form action="{{ route('update.profile') }}" enctype="multipart/form-data" method="POST">
            @method('PUT')
            @csrf
        <div class="box_foto" style=" display: flex;flex-direction:column; justify-content: center;
        align-items: center;position: relative;padding-bottom:20px ">
      
                <img id="preview-image" src="{{ asset('assets/profil/'.auth()->user()->foto)}}" style="width: 200px; height: 200px; position: absolute; display: none;">
      
            <img  id="profile" src="{{ asset('assets/profil/'.auth()->user()->foto )}}" style="width:200px;height:200px;position: absolute">
            <label for="fileInput" class="file-input-container">
                <input type="file" id="fileInput" class="real-file-input" name="foto" onchange="previewImage()" title="Ganti Foto" accept=".jpg, .jpeg, .png, .gif">
                Ganti Foto
            </label>
            {{-- <button class="ganti_foto" type="" >Ganti Foto</button> --}}
        </div>
        <div class="lapisan">
            <div class="teks">
                <h1>Nama</h1>
            </div>
            <div class="box_gelap">
                <input type="text" name="nama_karyawan" id="namaInput" class="box_input" style="padding-left: 20px"
                placeholder="{{ auth()->user()->nama_karyawan }}" value="{{ auth()->user()->nama_karyawan }}">
            </div>
            <div class="teks">
                <h1>Alamat</h1>
            </div>
            <div class="box_gelap">
                <input type="text" name="alamat" id="alamatInput" class="box_input" style="padding-left: 20px"
                placeholder="{{ auth()->user()->alamat }}" value="{{ auth()->user()->alamat }}">
            </div>
            <div class="teks">
                <h1>Nomor Induk Karyawan</h1>
            </div>
            <div class="box_gelap">
                <input type="text" name="nama_karyawan" id="namaInput" class="box_input" style="padding-left: 20px"
                placeholder="{{ auth()->user()->nik }}" disabled>
            </div>
            <div class="teks">
                <h1>Jabatan</h1>
            </div>
            <div class="box_gelap">
                <input type="text" name="jabatan" id="alamatInput" class="box_input" style="padding-left: 20px"
                placeholder="{{ auth()->user()->jabatan }}" disabled>
            </div>
            <div class="teks">
                <h1>Tanda Tangan</h1>
            </div>
            <input type="file" name="tanda_tangan" id="fileInput" style="padding-left: 20px" accept=".jpg, .jpeg, .png, .gif">
              
            <button id="simpan-button" type="submit">Simpan Perubahan</button>
        </form>
{{-- 
            <div class="box_gelap">
                <div class="icon_belum" id="mark">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="belum_unggah" id="unggah">
                    <h1>Belum diunggah</h1>
                </div>
                <input type="file" name="tanda_tangan" id="fileInput" style="display: none;">
                <div onclick="document.getElementById('fileInput').click()" class="pilih" id="pilih_file" style="display: none;">
                    <h1>Pilih File</h1>
                </div>
                <div class="no" id="no_file" style="display: none;">
                    <h1>Tidak ada file yang dipilih</h1>
                </div>
                <div class="icon_berhasil" id="done" style="display: none;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="sudah_unggah" id="sudah_unggah" style="display: none;">
                    <h1>Sudah diunggah</h1>
                </div>
                <div class="lihat" id="lihat" style="display: none;">
                    <h1>Lihat</h1>
                </div>
            </div> --}}
            <button id="toggle-button" hidden>Ubah Profile</button>
            {{-- <button id="simpan-button" style="display: none;">Simpan Perubahan</button> --}}


            <button id="ubah-sandi-button">Ubah Kata Sandi</button>
            <form action="{{ route('change.password') }} " method="POST">
                @method('POST')
                @csrf
                <div class="teks" id="sandi_lama" style="display: none;">
                    <h1>Kata Sandi Lama</h1>
                </div>
                <div class="box_gelap" style="display: none;" id="sandi_lamaInput">
                    <input type="text" class="box_input" name="password_lama">
                </div>
                <div class="teks" id="sandi_baru" style="display: none;">
                    <h1>Kata Sandi Baru</h1>
                </div>
                <div class="box_gelap" style="display: none;" id="sandi_baruInput">
                    <input type="text" class="box_input" name="password_baru">
                </div>
                <div class="teks" id="konfirmasi" style="display: none;">
                    <h1>Konfirmasi Kata Sandi Baru</h1>
                </div>
                <div class="box_gelap" style="display: none;" id="konfirmasiInput">
                    <input type="text" class="box_input" name="konfirmasi_password">
                </div>
                
                <button type="submit" id="simpan-sandi-button" style="display: none;">Simpan Kata Sandi</button>
            </form>
    </div>
</div>
<script>
document.getElementById('toggle-button').addEventListener('click', function() {
    var namaInput = document.getElementById('namaInput');
    var alamatInput = document.getElementById('alamatInput');
    var boxGelap = document.querySelector('box_gelap_kata');
    var pilihFile = document.getElementById('pilih_file');
    var noFile = document.getElementById('no_file');
    var mark = document.getElementById('mark');
    var unggah = document.getElementById('unggah');
    var done = document.getElementById('done');
    var sudahunggah = document.getElementById('sudah_unggah');
    var lihat = document.getElementById('lihat');
    var simpanButton = document.getElementById('simpan-button');

    if (namaInput.style.display === 'none' && alamatInput.style.display === 'none') {
        namaInput.style.display = 'block';
        alamatInput.style.display = 'block';
        simpanButton.style.display = 'block'; // Tampilkan tombol "Simpan Perubahan"
        this.style.display = 'none'; // Sembunyikan tombol "Ubah Profile"
        // Sembunyikan elemen i dan h1, dan tampilkan elemen pilih dan no
        sudahunggah.style.display = 'none';
        lihat.style.display = 'none';
        pilihFile.style.display = 'block';
        noFile.style.display = 'block';
        mark.style.display = 'none';
        done.style.display = 'none';
        unggah.style.display = 'none';
    }
});
document.getElementById('simpan-button').addEventListener('click', function() {
    var namaInput = document.getElementById('namaInput');
    var alamatInput = document.getElementById('alamatInput');
    var pilihFile = document.getElementById('pilih_file');
    var noFile = document.getElementById('no_file');
    var done = document.getElementById('done');
    var sudahunggah = document.getElementById('sudah_unggah');
    var lihat = document.getElementById('lihat');
    var ubahButton = document.getElementById('toggle-button');

    if (namaInput.style.display === 'block' && alamatInput.style.display === 'block') {
        namaInput.style.display = 'none';
        alamatInput.style.display = 'none';
        pilihFile.style.display = 'none';
        noFile.style.display = 'none';
        done.style.display = 'block';
        sudahunggah.style.display = 'block';
        lihat.style.display = 'block';
        ubahButton.style.display = 'block'; // Tampilkan tombol "Ubah Profile"
        this.style.display = 'none'; // Sembunyikan tombol "Simpan Perubahan"
    }
});

document.getElementById('ubah-sandi-button').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah formulir diajukan secara otomatis

    // Logika perubahan tampilan tombol "Ubah Kata Sandi"
    var sandiLamaInput = document.getElementById('sandi_lamaInput');
    var sandiBaruInput = document.getElementById('sandi_baruInput');
    var konfirmasiInput = document.getElementById('konfirmasiInput');
    var sandiLama = document.getElementById('sandi_lama');
    var sandiBaru = document.getElementById('sandi_baru');
    var konfirmasi = document.getElementById('konfirmasi');
    var simpanSandiButton = document.getElementById('simpan-sandi-button');

    if (sandiLamaInput.style.display === 'none' && sandiBaruInput.style.display === 'none' && konfirmasiInput.style.display === 'none') {
        sandiLamaInput.style.display = 'block';
        sandiBaruInput.style.display = 'block';
        konfirmasiInput.style.display = 'block';
        sandiLama.style.display = 'block';
        sandiBaru.style.display = 'block';
        konfirmasi.style.display = 'block';
        simpanSandiButton.style.display = 'block'; // Tampilkan tombol "Simpan Sandi"
        this.style.display = 'none'; // Sembunyikan tombol "Ubah Kata Sandi"
    }
});
document.getElementById('simpan-sandi-button').addEventListener('click', function() {
    var sandiLamaInput = document.getElementById('sandi_lamaInput');
    var sandiBaruInput = document.getElementById('sandi_baruInput'); 
    var konfirmasiInput = document.getElementById('konfirmasiInput');
    var sandiLama = document.getElementById('sandi_lama');
    var sandiBaru = document.getElementById('sandi_baru');
    var konfirmasi = document.getElementById('konfirmasi');
    var ubahSandiButton = document.getElementById('ubah-sandi-button');

    if (sandiLamaInput.style.display === 'block' && sandiBaruInput.style.display === 'block' && konfirmasiInput.style.display === 'block') {
        sandiLamaInput.style.display = 'none';
        sandiBaruInput.style.display = 'none';
        konfirmasiInput.style.display = 'none';
        sandiLama.style.display = 'none';
        sandiBaru.style.display = 'none';
        konfirmasi.style.display = 'none';
        ubahSandiButton.style.display = 'block'; // Tampilkan tombol "Ubah Kata Sandi"
        this.style.display = 'none'; // Sembunyikan tombol "Simpan Sandi"
    }
});

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

document.getElementById('simpan-sandi-button').addEventListener('click', function(event) {
        var passwordBaru = document.getElementsByName('password_baru')[0].value;
        var konfirmasiPassword = document.getElementsByName('konfirmasi_password')[0].value;

        // Periksa kesamaan
        if (passwordBaru !== konfirmasiPassword) {
            alert('Kata sandi baru dan konfirmasi kata sandi baru harus sama.');
            event.preventDefault(); // Mencegah pengiriman formulir jika kata sandi tidak cocok
        }
    });


    function previewImage() {
            var fileInput = document.getElementById('fileInput');
            var previewImage = document.getElementById('preview-image');
            var previewContainer = document.getElementById('preview-container');
            var profilepct =document.getElementById('profile');

            var file = fileInput.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    profilepct.style.display = 'none';
                };

                reader.readAsDataURL(file);
            } else {
                // Jika tidak ada file yang dipilih, tampilkan foto profil lama
                previewImage.src = "{{ asset('assets/profil/'.auth()->user()->foto)}}";
                previewImage.style.display = 'none';
                profilepct.style.display = 'block';
            }
        }
</script>
@endsection