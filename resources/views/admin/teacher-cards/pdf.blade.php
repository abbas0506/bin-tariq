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
            margin: 20px;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .data tr th,
        .data tr td {
            font-size: 12px;
            text-align: center;
            padding: 10px;
        }

        .border {
            border: 0.5px solid #999;
        }

        .card-container {
            position: relative;
            overflow: hidden;
            background-color: white;
            width: 200px;
            height: 300px;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 40px;
            z-index: 1;
            width: 25px;
            height: 25px;
        }

        .bottom-left-bar {
            position: absolute;
            bottom: 30px;
            left: 0px;
            width: 33%;
            height: 8px;
            background-color: #c6eabf;
            z-index: 1;
        }

        .bottom-right-bar {
            position: absolute;
            bottom: 30px;
            right: 0px;
            width: 33%;
            height: 8px;
            background-color: #c6eabf;
            z-index: 1;
        }

        .bg-custom {
            position: absolute;
            width: 400px;
            height: 70%;
            opacity: 1;
            transform-origin: top right;
            transform: rotate(-48deg);
            background-color: #c6eabf;
            border-radius: 10%;

        }

        .wave-pattern {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 300px;
            opacity: 0.75;
            z-index: 1;
        }

        .card-content {
            position: relative;
            z-index: 1;
        }

        .page-break {
            page-break-after: always;
        }

        .text-xs {
            font-size: 8px;
        }

        .school-name {
            position: absolute;
            left: 75px;
            top: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .web-address {
            position: absolute;
            left: 76px;
            top: 30px;
            font-size: 8px;
        }

        .footer {
            position: absolute;
            bottom: 0px;
            left: 70px;
            font-size: 8px;
        }
    </style>
</head>

@php
    $roman = config('global.romans');
    $i = 0;
    $numOfCardsPerRow = 3;
@endphp

<body>
    <main>
        <div class="custom-container">
            <table class="w-full">
                <tbody>
                    <tr class="text-xs">
                        <td class="text-left">Teacher Cards</td>
                        <td class="text-right">Printed on {{ now()->format('d-M-Y') }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table-auto w-full mt-2">
                <tbody class="data">
                    @foreach ($teachers->sortByDesc('bps') as $teacher)
                        @if ($i % $numOfCardsPerRow == 0)
                            <tr class="text-sm">
                        @endif

                        <td class="p-6">
                            <div class="border p-2 card-container">
                                <!-- Background Logo -->

                                {{-- <img src="{{ public_path('images/logo/punjab.png') }}" class="card-logo-bg"
                                    alt="Background Logo"> --}}
                                <!-- wave patten -->
                                <img src="{{ public_path('images/bg/waves.png') }}" class="wave-pattern"
                                    alt="Wave pattern">
                                <img src="{{ public_path('images/logo/black.png') }}" alt="" class="logo">
                                <div class="bg-custom"></div>
                                <div class="school-name">GHS 32/2L</div>
                                <div class="web-address">ghs32.txdevs.com</div>
                                <div class="bottom-left-bar"></div>
                                <div class="bottom-right-bar"></div>
                                <div class="footer">ID: {{ $teacher->cnic }}</div>
                                <!-- Foreground Content -->
                                <div class="card-content">


                                    <div class="w-24 h-24 m-auto mt-16">
                                        @if ($teacher->photo)
                                            <img src="{{ public_path('storage/' . $teacher->photo) }}"
                                                style="width:84px; height:84px; border-radius:50%; border:4px solid white; object-fit:cover;">
                                        @else
                                            <span style="color: #999;">No Photo</span>
                                        @endif
                                    </div>

                                    <div class="font-bold px-5 mt-5" style="font-size: 15px">
                                        {{ Str::upper($teacher->name) }}</div>
                                    <div style="color:rgb(57, 129, 35); font-size:12px; margin-top:8px">
                                        {{ $teacher->designation }}</div>
                                    <div style="width: 45px; position: absolute; left:78px; bottom:6px">
                                        {!! DNS2D::getBarcodeHTML($teacher->cnic, 'QRCODE', 2, 2) !!}
                                    </div>

                                </div>
                            </div>
                        </td>

                        @if ($i % $numOfCardsPerRow == $numOfCardsPerRow - 1)
                            </tr>
                        @endif
                        @php $i++; @endphp
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
