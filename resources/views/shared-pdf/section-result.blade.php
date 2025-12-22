<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Section Result</title>
    <link href="{{ public_path('css/pdf_tw.css') }}" rel="stylesheet">
    <style>
        @page {
            margin: 50px 80px 50px 50px;
        }

        .footer {
            position: fixed;
            bottom: 50px;
            left: 30px;
            right: 50px;
            background-color: white;
            height: 50px;
        }

        .page-break {
            page-break-after: always;
        }

        .data tr th,
        .data tr td {
            font-size: 11px;
            text-align: center;
            /* padding-bottom: 2px; */
            border: 0.5px solid;
        }
    </style>
</head>
@php
    $roman = config('global.romans');
@endphp

<body>

    <main>
        <div class="custom-container">

            <div class="w-1/2 mx-auto">
                <div class="relative">
                    <div class="absolute"><img alt="logo" src="{{ public_path('/images/logo/dark_green.png') }}"
                            class="w-16"></div>
                </div>
                <table class="w-full">
                    <tbody>
                        <tr>
                            <td class="text-center text-xl font-bold">Section Result : {{ $section->fullName() }} </td>
                        </tr>
                        <tr>
                            <td class="text-center text-sm">Govt. High School 32/2L, Okara</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- table header -->
            <h4 class="mt-6 text-center underline underline-offset-2">{{ $test->title }}</h4>
            <!--  -->
            <table class="table-auto text-sm border w-full mt-1">
                <thead>
                    <tr class="border text-sm">
                        <th>Roll#</th>
                        <th>Name</th>
                        @foreach ($lectureNos as $lectureNo)
                            <th>
                                @if ($allocations->where('lecture_no', $lectureNo)->count() == 1)
                                    {{ $allocations->where('lecture_no', $lectureNo)->first()->subject->short_name }}
                                @else
                                    @foreach ($allocations->where('lecture_no', $lectureNo) as $allocation)
                                        {{ $allocation->subject->short_name }}
                                        @if (!$loop->last)
                                            /
                                        @endif
                                    @endforeach
                                @endif
                            </th>
                        @endforeach
                        <th>Obt.</th>
                        <th>Total</th>
                        <th>Overall %</th>
                    </tr>
                </thead>
                <tbody class="data">
                    @foreach ($section->students->sortBy('rollno') as $student)
                        <tr class="tr">
                            <td>{{ $student->rollno }}</td>
                            <td style="text-align: left; padding-left:8px;">{{ ucwords(strtolower($student->name)) }}
                            </td>
                            @foreach ($lectureNos as $lectureNo)
                                <td class="w-8">
                                    {{ $student->results()->test($test->id)->forLectureNo($lectureNo)->first()?->obtained_marks }}
                                </td>
                            @endforeach
                            <td>{{ $student->results()->test($test->id)->sum('obtained_marks') }}</td>
                            <td>{{ $student->maximumMarks($test->id) }}</td>
                            <td>
                                @if ($student->maximumMarks($test->id) > 0)
                                    {{ round(($student->results()->test($test->id)->sum('obtained_marks') / $student->maximumMarks($test->id)) * 100, 0) }}
                                    %
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
