<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page{
            size:A4;
            margin:10mm;
        }

        @media print{
            .no-print{
                display:none !important;
            }

            body{
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
            }
        }
    </style>
</head>
<body style="background:#f2f2f2;font-family:Arial,Helvetica,sans-serif;font-size:14px;">

<div style="width:210mm;min-height:297mm;margin:20px auto;background:#fff;padding:15mm;border:1px solid #dcdcdc;box-shadow:0 0 10px rgba(0,0,0,.08);box-sizing:border-box;">

    <!-- Header -->

    <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
        <tr>

            <td style="width:60%;vertical-align:top;">

                <h2 style="margin:0;color:#0d6efd;">{{$purchase->provider}}</h2>

                <div style="margin-top:10px;line-height:24px;">
                    {{$purchase->company}}
                </div>

            </td>

            <td style="width:40%;vertical-align:top;text-align:right;">

                <h3 style="margin:0;">STOCK IN INVOICE</h3>

                <table style="width:100%;margin-top:15px;">
                    <tr>
                        <td style="padding:4px;"><b>Date</b></td>
                        <td style="padding:4px;">:</td>
                        <td style="padding:4px;text-align:right;">{{$purchase->created_at->format('d-M-Y')}}</td>
                    </tr>

                    <tr>
                        <td style="padding:4px;"><b>Purchase By</b></td>
                        <td style="padding:4px;">:</td>
                        <td style="padding:4px;text-align:right;">{{$purchase->user->name}}</td>
                    </tr>

                </table>

            </td>

        </tr>
    </table>


    <!-- Product Table -->

    <table style="width:100%;border-collapse:collapse;margin-top:20px;">

        <thead>

        <tr style="background:#f4f4f4;">

            <th style="border:1px solid #999;padding:10px;">SL</th>

            <th style="border:1px solid #999;padding:10px;text-align:left;">Product</th>

            <th style="border:1px solid #999;padding:10px;">Qty</th>

        </tr>

        </thead>

        <tbody>
            @foreach ($purchase->items as $key=>$item)
                <tr>

                    <td style="border:1px solid #999;padding:10px;text-align:center;">{{++$key}}</td>

                    <td style="border:1px solid #999;padding:10px;">{{ucwords(strtolower($item->lens->name))}}</td>

                    <td style="border:1px solid #999;padding:10px;text-align:center;">{{$item->qty}}</td>

                </tr>
            @endforeach
        </tbody>

    </table>

    <!-- Signature -->

</div>

<div class="text-center my-4 no-print">
    <button class="btn btn-primary" onclick="window.print()">
        Print Invoice
    </button>
</div>

</body>
</html>