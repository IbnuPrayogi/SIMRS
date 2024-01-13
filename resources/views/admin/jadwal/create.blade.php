<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import SQL Table Form</title>
</head>
<body>
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="post" action="{{ route('jadwal.importsql') }}" enctype="multipart/form-data">
        @csrf
        <label for="sql_file">Upload SQL File:</label><br>
        <input type="file" name="sql_file"><br><br>
        <button type="submit">Import SQL Table</button>
    </form>


</body>
</html>