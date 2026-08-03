<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POS Invoice</title>

    <style>
        @page{
            size:80mm auto;
            margin:3mm;
        }

        body{
            width:80mm;
            margin:0 auto;
            font-family:monospace;
            font-size:12px;
            color:#000;
        }

        .center{
            text-align:center;
        }

        .line{
            border-top:1px dashed #000;
            margin:5px 0;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            text-align:left;
            border-bottom:1px dashed #000;
            padding:3px 0;
        }

        td{
            padding:2px 0;
            vertical-align:top;
        }

        .right{
            text-align:right;
        }

        .bold{
            font-weight:bold;
        }

        .total td{
            padding:3px 0;
        }

        @media print{
            .no-print{
                display:none;
            }
        }
    </style>
</head>

<body>

<div class="center no-print" style="margin-bottom:10px;">
    <button onclick="window.print()">Print</button>
</div>

<div class="center">

    <h3 style="margin:0;">{{setting()->name}}</h3>

    <small>
        {{setting()->address}}<br>
        Phone: {{setting()->contact}}
    </small>

</div>

<div class="line"></div>

<table>

    <tr>
        <td>Invoice</td>
        <td class="right">{{$sale->saleid}}</td>
    </tr>

    <tr>
        <td>Date</td>
        <td class="right">{{$sale->created_at->format('d-M-Y h:i A')}}</td>
    </tr>

    <tr>
        <td>Customer</td>
        <td class="right">{{$sale->name}}</td>
    </tr>

    <tr>
        <td>Seller</td>
        <td class="right">{{$sale->user->name}}</td>
    </tr>

</table>

<div class="line"></div>

<table>

    <thead>

        <tr>
            <th>Item</th>
            <th class="right">Qty * Price</th>
            <th class="right">Total</th>
        </tr>

    </thead>

    <tbody>

    @foreach($sale->glass as $item)

        <tr>
            <td>
                {{ ucwords(strtolower($item->glass->name ?? null)) }}
            </td>
            <td class="right">
                {{$item->qty}} × {{$item->price}}
            </td>
            <td class="right">
                {{$item->qty * $item->price}}
            </td>
        </tr>

    @endforeach
    @foreach($sale->frame as $item)

        <tr>
            <td>
                {{ ucwords(strtolower($item->frame->name ?? null)) }}
            </td>
            <td class="right">
                {{$item->qty}} × {{$item->price}}
            </td>
            <td class="right">
                {{$item->qty * $item->price}}
            </td>
        </tr>

    @endforeach

    </tbody>

</table>

<div class="line"></div>

<table class="total">

    <tr>
        <td>Subtotal</td>
        <td class="right">{{$sale->total_price}}</td>
    </tr>

    <tr>
        <td>Discount</td>
        <td class="right">{{$sale->discount}}</td>
    </tr>

    <tr class="bold">
        <td>Grand Total</td>
        <td class="right">{{$sale->grand_total}}</td>
    </tr>

    <tr>
        <td>Paid</td>
        <td class="right">{{$sale->paid}}</td>
    </tr>

    <tr class="bold">
        <td>Change</td>
        <td class="right">{{$sale->changes}}</td>
    </tr>

</table>

<div class="line"></div>

<div class="line"></div>

<div class="center">

    <strong>Thank You!</strong><br>

    Please Visit Again<br>
    Designed By: Jwel Rana(01571166570)

</div>

</body>
</html> 