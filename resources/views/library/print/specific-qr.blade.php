<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes</title>
    <link href="{{public_path('css/pdf_tw.css')}}" rel="stylesheet">
    <style>
        @page {
            margin: 50px 80px 50px 50px;
        }
    </style>
</head>

<body>
    <main>
        <div class="custom-container">
            <div class="text-left">
                <div>{!! DNS2D::getBarcodeHTML($qr, 'QRCODE',4,4) !!}</div>
                <span class="text-xs pl-5">{{$qr}}</span>
            </div>
        </div>
</body>

</html>