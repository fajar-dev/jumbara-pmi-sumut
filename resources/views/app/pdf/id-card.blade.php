<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 0;
            /* size: A6 portrait; */
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            width: 105mm;
            height: 0mm;
            position: relative;
        }
        .background {
            position: absolute;
            top: 0; left: 0;
            width: 105mm;
            height: 148mm;
            z-index: 0;
        }
        .content {
            position: relative;
            z-index: 10;
            padding: 13.5mm 7mm 15mm 6.5mm;
            box-sizing: border-box;
            height: 1000%;
            color: red;
            margin-top: 30mm; /* Atur agar box posisi pas */
        }
        .top-boxes {
            display: flex;
            flex-direction: row;
            justify-content: flex-start; /* Foto di kiri, QR code di kanan */
            margin-bottom: 15mm;
        }
        /* Box Foto ukuran lebih besar */
        .box.foto {
            border: 0px solid black;
            margin-left: -0.1mm; 
            margin-top: 0.4mm;
            width: 36mm;
            height: 50.04mm;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            line-height: 60mm;
            overflow: hidden;
            background-color: white;
        }
        /* Box QR code ukuran lebih kecil */
        .box.qrcode {
            margin-left: 36.15mm; /* Jarak antara foto dan QR code */
            margin-top: -51.96mm; /* Atur posisi supaya sejajar dengan box foto */
            border: 0px solid black;
            width: 47.95mm;
            height: 42.05mm;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            line-height: 30mm;
            overflow: hidden;
            background-color: rgb(255, 255, 255);
            padding: 15px;
        }
        /* Gambar di dalam box supaya cover dan proporsional */
        .box.foto img,
        .box.qrcode img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .name-box {
            margin-top: 5.8mm;
            border: 0px solid black;
            font-weight: bold;
            font-size: 22px;
            padding: 6px 0;
            text-align: center;
            margin-bottom: 6mm;
            background-color: transparent
        }
        .kontingen-box {
            margin-top: 4mm;
            border: 0px solid black;
            font-weight: bold;
            font-size: 20px;
            padding: 6px 0;
            text-align: center;
            background-color: transparent;
            position: absolute;
            z-index: 999;

            left: 10%;   /* jarak kiri 10% */
            right: 10%;  /* jarak kanan 10% */
            /* width otomatis */
        }

    </style>
</head>
<body>
    <img class="background" src="{{ $background }}" alt="Background">

    <div class="content">
        <div class="top-boxes">
            <div class="box foto" style="background-image: url('{{ $foto }}'); background-size: cover; background-position: center;">
            </div>
            <div class="box qrcode">
                <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code">
            </div>
            @php
                $words = explode(' ', $name);
                $limited = array_slice($words, 0, 3);
                $capitalized = array_map(function ($word) {
                    return ucfirst(strtolower($word));
                }, $limited);
                $formattedName = implode(' ', $capitalized);
            @endphp

            <div class="name-box">{{ $formattedName }}</div>

            <div class="kontingen-box">{{ $kontingen }}</div>
        </div>

    </div>
</body>
</html>
