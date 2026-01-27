<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Invoices</title>
    <link href="{{ public_path('css/pdf_tw.css') }}" rel="stylesheet">

    <style>
        @page {
            margin: 10px;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .data tr th,
        .data tr td {
            font-size: 12px;
            text-align: center;
        }

        .card-container {
            position: relative;
            overflow: hidden;
            background-color: white;
            border: 1px solid;
        }

        .card-logo-bg {
            position: absolute;
            top: 160px;
            /* Adjust based on where you want the image */
            left: 27px;
            width: 150px;
            opacity: 0.25;
        }

        .wave-pattern {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 300px;
            opacity: 0.75;
        }

        .card-content {
            position: relative;
            z-index: 1;
        }

        .page-break {
            page-break-after: always;
        }

        h3,
        p {
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

@php
    $i = 0;
    $numOfInvoicesPerRow = 1;
@endphp

<body>
    <main>
        <div>
            <table class="w-full">
                <tbody>
                    <tr class="text-xs">
                        <td class="text-left">Fee Invoices</td>
                        <td class="text-right">Printed on {{ now()->format('d-M-Y') }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table-auto w-full mt-2" cellspacing="0">
                <tbody class="data">
                    @foreach ($feeInvoices as $feeInvoice)
                        @if ($i % $numOfInvoicesPerRow == 0)
                            <tr class="text-sm">
                        @endif

                        <td class="p-6">
                            <table width="100%">
                                <tr>
                                    <th style="width: 10%"></th>
                                    <th style="width: 70%"></th>
                                    <th style="width: 20%"></th>
                                </tr>
                                <tr>
                                    <td style="text-align: right; padding-right:8px;"><img
                                            src="{{ public_path('images/logo/ghs-32.png') }}" alt=""
                                            width="40px" height="40px"></td>
                                    <td>
                                        <h3 class="m-0 p-0 text-left">Bin Tariq Campus</h3>
                                        <p class="m-0 p-0 text-left">Chorasta Mian Khan, Depalpur</p>
                                    </td>
                                    <td>
                                        <p class="m-0 p-0">Fee Challan</p>
                                        <h3 class="m-0 p-0">{{ $feeInvoice->billingMonth() }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border:solid 1px; text-align:left;padding-left:40px">
                                        <b>Jazz Cash A/C
                                            #</b> 03294606033
                                    </td>
                                    <td style="border:solid 1px">
                                        <p class="m-0 p-0">Challan #</p>
                                        <h4 class="m-0 p-0">{{ $feeInvoice->invoice_no }}</h4>
                                    </td>
                                </tr>
                            </table>
                            <table class="w-full">
                                <tr>
                                    <th style="width: 50%"></th>
                                    <th style="width: 50%"></th>
                                </tr>
                                <tr>
                                    <td style="border: solid 1px; padding:10px">
                                        <table class="w-full">
                                            <tr>
                                                <th style="width: 30%"></th>
                                                <th style="width: 70%"></th>
                                            </tr>
                                            <tr>
                                                <td><b>Name</b></td>
                                                <td style="text-align: left">{{ $feeInvoice->student->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Father</b></td>
                                                <td style="text-align: left">{{ $feeInvoice->student->father_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Class</b></td>
                                                <td style="text-align: left">
                                                    {{ $feeInvoice->student->section->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Roll #</b></td>
                                                <td style="text-align: left">{{ $feeInvoice->student->rollno }}
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                    <td style="border:solid 1px;text-align:left; padding:10px; padding-left:40px">
                                        <h4>Fee Detail</h4>
                                        @foreach ($feeInvoice->feeInvoiceItems as $feeInvoiceItem)
                                            <p>
                                                {{ $feeInvoiceItem->feeType->name }} &ndash;
                                                {{ $feeInvoiceItem->amount }}
                                            </p>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border:solid 1px; padding:5px">
                                        <b>Due Date:</b> {{ $feeInvoice->due_date->format('d/m/Y') }}
                                    </td>
                                    <td style="border:solid 1px; padding:5px">
                                        <b>Total Amount:</b> Rs. {{ $feeInvoice->amount }}
                                    </td>

                                </tr>
                            </table>

                        </td>

                        @if ($i % $numOfInvoicesPerRow == $numOfInvoicesPerRow - 1)
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
