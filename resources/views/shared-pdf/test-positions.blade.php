<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Cards</title>
    <link href="{{ public_path('css/pdf_tw.css') }}" rel="stylesheet">
    <style>
        @page {
            margin: 50px 80px;
        }

        .footer {
            position: fixed;
            bottom: 50px;
            left: 0px;
            right: 0px;
            background-color: white;
            height: 50px;
        }

        .page-break {
            page-break-after: always;
        }

        .data tr th,
        .data tr td {
            font-size: 12px;
            padding-left: 4px;
            padding-right: 4px;
            /* text-align: left; */
        }

        .border {
            border: solid 0.1px;
        }
    </style>
</head>
@php
    $roman = config('global.romans');
@endphp

<body>

    <main>
        <div class="container">
            <!-- front page ... section gazzet -->
            <div class="w-1/2 mx-auto">
                <div class="relative">
                    <div class="absolute"><img alt="logo" src="{{ public_path('/images/logo/dark_green.png') }}"
                            class="w-16"></div>
                </div>
                <table class="w-full">
                    <tbody>
                        <tr>
                            <td class="text-center text-lg font-bold">Class Result - {{ $test->title }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">Govt. High School 32/2.L, Okara</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h4 class="mt-8 underline text-center">Class: {{ $section->fullName() }}</h4>


            <table class="table-auto w-full mt-4" cellspacing="0">
                <thead class="data">
                    <tr class="border">
                        <th class="w-16">Position</th>
                        <th class="">Student Name</th>
                        <th class="w-12">Roll No</th>
                        <th class="w-16">Total</th>
                        <th class="w-16">obtained_marks</th>
                        <th class="w-16">Percentage</th>
                    </tr>
                </thead>
                <tbody class="data">

                    @foreach ($sortedResult as $sortedPercentage)
                        <tr class="border">
                            <td>{{ $sortedPercentage['position'] }}</td>
                            <td class="text-left">{{ ucwords(strtolower($sortedPercentage['name'])) }}</td>
                            <td>{{ $sortedPercentage['rollno'] }}</td>
                            <td>{{ $sortedPercentage['max_marks'] }}</td>
                            <td>{{ $sortedPercentage['obtained_marks'] }}</td>
                            <td>{{ $sortedPercentage['percentage'] }} %</td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>

    <script type="text/php">
        if (isset($pdf) ) {
            $x = 285;
            $y = 20;
            $text = "{PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 6;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>

</body>

</html>
