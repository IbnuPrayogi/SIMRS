@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Surat Undangan</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 mx-auto">

        <div class="text-center mb-4">
          <h2>Form Surat Undangan</h2>
        </div>

        <form method="post" action=""  enctype="multipart/form-data">
            @csrf
            <div class="form-group">
            <label for="perihal">Perihal:</label>
            <input type="text" class="form-control" id="perihal" placeholder="Masukkan perihal">
          </div>

          <div class="form-group">
            <label for="hari_tanggal">Hari/Tanggal:</label>
            <input type="text" class="form-control" id="hari_tanggal" placeholder="Masukkan hari/tanggal">
          </div>

          <div class="form-group">
            <label for="waktu">Waktu:</label>
            <input type="text" class="form-control" id="waktu" placeholder="Masukkan waktu">
          </div>

          <div class="form-group">
            <label for="tempat">Tempat:</label>
            <input type="text" class="form-control" id="tempat" placeholder="Masukkan tempat">
          </div>

          <div class="form-group">
            <label for="tanggal_surat">Tanggal Surat:</label>
            <input type="date" class="form-control" id="tanggal_surat">
          </div>

          <button type="submit" class="btn btn-primary">Buat Surat</button>

        </form>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

@endsection
