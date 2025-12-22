<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Cards</title>
    <link href="{{ public_path('css/pdf_tw.css') }}" rel="stylesheet">

    <style>
        @page {
            margin: 50px;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .data tr th,
        .data tr td {
            font-size: 12px;
            text-align: center;
            /* padding-top: 10px; */
        }

        .border {
            border: 0.5px solid #999;
        }

        .card-container {
            position: relative;
            overflow: hidden;
            background-color: white;
            width: 100%;
            height: 390px;
        }

        .card-content {
            position: relative;
            z-index: 1;
        }

        .bg-custom {
            position: absolute;
            width: 500px;
            height: 74%;
            opacity: 1;
            transform-origin: top right;
            transform: rotate(-48deg);
            background-color: #c6eabf;
            border-radius: 10%;

        }

        .logo {
            position: absolute;
            top: 25px;
            left: 45px;
            z-index: 1;
            width: 36px;
            height: 36px;
            z-index: 1;
        }

        .school-name {
            position: absolute;
            left: 90px;
            top: 30px;
            font-size: 14px;
            font-weight: bold;
            z-index: 1;
        }

        .web-address {
            position: absolute;
            left: 91px;
            top: 42px;
            font-size: 10px;
            z-index: 1;
        }

        .wave-pattern {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 300px;
            opacity: 0.75;
            z-index: 1;
        }

        .bottom-left-bar {
            position: absolute;
            bottom: 32px;
            left: 0px;
            width: 33%;
            height: 12px;
            background-color: #c6eabf;
            z-index: 1;
        }

        .bottom-right-bar {
            position: absolute;
            bottom: 32px;
            right: 0px;
            width: 33%;
            height: 12px;
            background-color: #c6eabf;
            z-index: 1;
        }

        .qr-code {
            position: absolute;
            left: 102px;
            bottom: 16px;
            width: 50px;
            z-index: 1;
        }

        .footer {
            position: absolute;
            bottom: 2px;
            left: 85px;
            font-size: 9px;
        }

        .page-break {
            page-break-after: always;
        }

        .text-xs {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <main>
        <div class="custom-container">
            <table class="">
                <tbody>
                    <tr class="text-xs">
                        <td class="text-left">Teacher Cards</td>
                        <td class="text-right">Printed on {{ now()->format('d-M-Y') }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table-auto mt-2 mx-auto" cellspacing="8" style="border-collapse:separate;">
                <tbody class="data">
                    @foreach ($teachers->sortByDesc('bps') as $teacher)
                        <tr class="text-sm">
                            @foreach (range(1, 2) as $column)
                                <td class="border" width='255px'>
                                    <div class="card-container">
                                        <img src="{{ public_path('images/bg/waves.png') }}" class="wave-pattern"
                                            alt="Wave pattern">
                                        <img src="{{ public_path('images/logo/black.png') }}" alt=""
                                            class="logo">
                                        <div class="bg-custom"></div>
                                        <div class="school-name">GHS 32/2L</div>
                                        <div class="web-address">ghs32.txdevs.com</div>
                                        <div class="bottom-left-bar"></div>
                                        <div class="bottom-right-bar"></div>
                                        <div class="footer">ID: {{ $teacher->cnic }}</div>
                                        <!-- Foreground Content -->
                                        <div class="card-content">
                                            <div class="w-32 h-32 m-auto" style="margin-top: 85px">
                                                @if ($teacher->photo)
                                                    <img src="{{ public_path('storage/' . $teacher->photo) }}"
                                                        style="width:100px; height:100px; border-radius:50%; border:5px solid white; object-fit:cover;">
                                                @else
                                                    <span style="color: #999;">No Photo</span>
                                                @endif
                                            </div>

                                            <div class="font-bold px-5 mt-4" style="font-size: 18px; line-height:20px">
                                                {{ Str::upper($teacher->name) }}</div>
                                            <div style="color:rgb(57, 129, 35); font-size:14px; margin-top:12px">
                                                {{ $teacher->designation }}</div>

                                            <div class="qr-code">
                                                {!! DNS2D::getBarcodeHTML($teacher->cnic, 'QRCODE', 2.4, 2.4) !!}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <script type="text/php">
        if (isset($pdf)) {
            $x = 285;
            $y = 20;
            $text = "{PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 6;
            $color = [0, 0, 0];
            $pdf->page_text($x, $y, $text, $font, $size, $color);
        }
    </script>
</body>

</html>
