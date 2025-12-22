<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teacher Cards</title>
    <link href="{{ public_path('css/pdf_tw.css') }}" rel="stylesheet">

    <style>
        @page {
            margin-top: 60px;
            margin-bottom: 60px;
        }

        @page :right {
            margin-left: 100px;
            margin-right: 75px;
        }

        @page :left {
            margin-left: 75px;
            margin-right: 100px;
        }

        body {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            text-align: center;
            font-size: 10px;
            height: 20px;
        }

        .page-container {
            position: relative;
            overflow: hidden;
            /* background-color: white; */
            /* border: 1px solid; */
        }

        .bg-logo {
            position: absolute;
            top: 300px;
            /* Adjust based on where you want the image */
            left: 150px;
            width: 300px;
            opacity: 0.4;
        }

        .sunday,
        .holiday {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .wave-pattern {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 300px;
            opacity: 0.75;
        }

        .month-title {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

@php
    $maxTeachersPerPage = 4;
@endphp

<body>
    <main>
        <div class="">
            @foreach ($monthData as $month)
                @foreach ($teacherChunks as $teachers)
                    <div class="page-break page-container">
                        <!-- Background Logo -->
                        <img src="{{ public_path('images/logo/logo_32.png') }}" class="bg-logo" alt="Logo">

                        <div class="month-title">
                            Staff Attendance Register — {{ $month['month_name'] }} {{ $year }}
                        </div>
                        <div class="month-title"> Govt High School 32/2L, Okara</div>

                        <table>
                            <thead>
                                <tr>
                                    <th rowspan="2" width="4%">Day</th>

                                    @foreach ($teachers as $teacher)
                                        @if ($teacher)
                                            <th colspan="4" style="font-size:12px">{{ $teacher->name }}
                                                </br>
                                                <span style="font-size: 10px">{{ $teacher->designation }}</span>
                                            </th>
                                        @else
                                            <th colspan="4">&nbsp;</th>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach ($teachers as $teacher)
                                        <th>Arr</th>
                                        <th>Sign</th>
                                        <th>Dep</th>
                                        <th>Sign</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @for ($day = 1; $day <= $month['month_days']; $day++)
                                    @php
                                        $date = \Carbon\Carbon::create($year, $month['month_number'], $day);
                                        $holidayName = $holidayMap[$month['month_number']][$day] ?? null;
                                    @endphp
                                    {{-- HOLIDAY ROW --}}
                                    @if ($holidayName)
                                        <tr class="holiday">
                                            <td>{{ $day }}</td>
                                            <td colspan="{{ $teachers->count() * 4 }}"
                                                style="text-align:center; font-weight:bold;">
                                                {{ strtoupper($holidayName) }}
                                            </td>
                                        </tr>
                                    @elseif ($date->isSunday())
                                        {{-- SUNDAY ROW --}}
                                        <tr class="sunday">
                                            <td>{{ $day }}</td>
                                            <td colspan="{{ $teachers->count() * 4 }}"
                                                style="text-align:center; font-weight:bold;">
                                                SUNDAY
                                            </td>
                                        </tr>
                                    @else
                                        {{-- NORMAL DAY --}}
                                        <tr>
                                            <td>{{ $day }}</td>

                                            @foreach ($teachers as $teacher)
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endfor
                                <tr>
                                    <th colspan="{{ $teachers->count() * 4 + 1 }}">LEAVE RECORD</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    @foreach ($teachers as $teacher)
                                        <td>C</td>
                                        <td>E</td>
                                        <td>M</td>
                                        <td rowspan="4" style="background: #f2f2f2"></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>PRE</th>
                                    @foreach ($teachers as $teacher)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>CRT</th>
                                    @foreach ($teachers as $teacher)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>TOT</th>
                                    @foreach ($teachers as $teacher)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endforeach
                                </tr>
                            </tbody>

                        </table>

                        <div style="margin-top: 25px; font-size:12px;font-style:normal">Sr. Headmster: _________________
                        </div>

                    </div>
                @endforeach
            @endforeach
        </div>
    </main>

    <script type="text/php">
        $font = $pdf->getFontMetrics()->getFont("Helvetica", "bold");
        $size = 6;
        $color = [0, 0, 0];

        $text = "{PAGE_NUM} of {PAGE_COUNT}";

        $width = $pdf->getFontMetrics()->getTextWidth($text, $font, $size);

        $x = ($pdf->getCanvas()->get_width() - $width) / 2;
        $y = $pdf->getCanvas()->get_height() - 40; // bottom

        $pdf->page_text($x, $y, $text, $font, $size, $color);
    </script>
</body>

</html>
