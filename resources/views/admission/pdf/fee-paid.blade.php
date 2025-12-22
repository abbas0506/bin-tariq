<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Payments</title>
    <link href="{{ public_path('css/pdf_tw.css') }}" rel="stylesheet">
    <style>
        @page {
            margin: 50px 50px 50px 80px;
        }

        .footer {
            position: fixed;
            bottom: 0px;
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
            border: 0.5px solid;
            line-height: 14px;
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
                            <td class="text-center text-lg font-bold">Fee Record XI ({{ date('Y') }})</td>
                        </tr>
                        <tr>
                            <td class="text-center text-sm">Govt. High School 32/2L, Okara</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- table header -->
            <div class="mt-8">
                <table class="w-full">
                    <tbody>
                        <tr class="text-xs">
                            <td class="text-right">Printed on {{ now()->format('d-M-Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @php $sr=1; @endphp

            <table class="w-full mt-2 data">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th class="w-8">Sr</th>
                        <th class="w-12">Form#</th>
                        <th>Name</th>
                        <th>Group</th>
                        <th>Marks</th>
                        <th>Fee</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($applications->sortByDesc('obtained_marks')->sortBy('group_id') as $application)
                        <tr class="text-base">
                            <td>{{ $sr++ }}</td>
                            <td>{{ $application->rollno }}</td>
                            <td style="text-align: left !important; padding:2px 6px;">
                                {{ ucwords(strtolower($application->name)) }}</td>
                            <td>{{ $application->group->name }}</td>
                            <td>{{ $application->obtained_marks }}</td>
                            <td>{{ $application->amount_paid }}</td>
                            <td>
                                @if ($application->photo)
                                    <img src="{{ public_path('storage/' . $application->photo) }}"
                                        style="width:32px; height:32px; border-radius:10%; border:0.5px solid #fff; object-fit:cover;">
                                @else
                                    <span style="color: #999;">No Photo</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="text-xs mt-3">* form # is same as student's matric roll number</div>
            <div class="mt-8">
                <table class="w-full">
                    <tbody>
                        <tr class="text-xs">
                            <td class="text-left">Students: {{ $applications->count() }}</td>
                            <td class="text-right">Total Fee: {{ $applications->sum('amount_paid') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </main>

    <footer class="footer">
        <div class="mt-8">
            <table class="w-full">
                <tbody>
                    <tr class="text-xs">
                    </tr>
                </tbody>
            </table>
        </div>
    </footer>

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
