<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $barber->nama }}</title>
</head>
<body>

<div class="container">
    <h1>{{ $barber->nama }}</h1>
    <img src="{{ asset('assets/img/'.$barber->foto) }}" width="200">
    <p>{{ $barber->deskripsi }}</p>
</div>

</body>
</html>
