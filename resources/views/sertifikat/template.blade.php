<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            background-image: url("{{ public_path('images/sertifikat-bg.png') }}");
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            position: relative;
        }

        .layer-teks {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            text-align: justify;
        }


        .nama {
            position: absolute;
            font-size: 48px;
            
            text-align: center;
            top: 00%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-family: 'Times New Roman', Times, serif, cursive;
        }
    </style>
</head>

<body>
    <div class="layer-teks">
        <h1></h1>
        <div class="nama">{{ $name }}</div>

    </div>
</body>

</html>