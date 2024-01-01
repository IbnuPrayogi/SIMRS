@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            /* padding: 20px; */
        }

        #form-container {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .hidden {
            display: none;
        }
    </style>
    <script>
        function showForm(selectedValue) {
            var izinForm = document.getElementById('izin-form');
            var keluarForm = document.getElementById('keluar-form');

            if (selectedValue === 'izin') {
                izinForm.classList.remove('hidden');
                keluarForm.classList.add('hidden');
            } else if (selectedValue === 'keluar') {
                keluarForm.classList.remove('hidden');
                izinForm.classList.add('hidden');
            }
        }
    </script>
</head>
<body>
    <div id="form-container">
        <label for="jenis-surat">Pilih Jenis Surat:</label>
        <select id="jenis-surat" onchange="showForm(this.value)">
            <option value="" selected disabled>Pilih Jenis Surat</option>
            <option value="izin">Surat Izin</option>
            <option value="keluar">Surat Keluar 2</option>
        </select>

        <form id="izin-form" class="hidden">
            <!-- Form surat izin -->
            <h2>Form Surat Izin</h2>
            <!-- Tambahkan elemen formulir yang diperlukan untuk surat izin -->
        </form>

        <form id="keluar-form" class="hidden">
            <!-- Form surat keluar 2 -->
            <h2>Form Surat Keluar 2</h2>
            <!-- Tambahkan elemen formulir yang diperlukan untuk surat keluar 2 -->
        </form>
    </div>
</body>
</html>
@endsection

