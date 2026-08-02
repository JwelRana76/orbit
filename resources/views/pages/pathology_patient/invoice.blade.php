<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pathology Lab Test Receipt</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
    margin:0;
    padding:0;
    background:#f2f2f2;
    font-family:Arial, Helvetica, sans-serif;
    font-size:12px;
}

.receipt{
    width:148mm;
    min-height:210mm;
    margin:10px auto;
    background:#fff;
    padding:10mm;
    border:1px solid #ddd;
    box-sizing:border-box;
}

.header{
    text-align:center;
    border-bottom:2px solid #000;
    padding-bottom:8px;
    margin-bottom:10px;
}

.header h3{
    margin:0;
    font-size:22px;
    font-weight:700;
}

.header p{
    margin:2px 0;
    font-size:12px;
}

.table{
    margin-bottom:8px;
}

.table th,
.table td{
    padding:4px 6px;
    font-size:12px;
    vertical-align:middle;
}

.signature{
    margin-top:60px;
}

.signature div{
    width:160px;
    border-top:1px solid #000;
    text-align:center;
    padding-top:5px;
    font-size:12px;
}
.header_button{
    border: 1px solid;
    width: max-content;
    float: center;
    margin: auto;
    padding: 5px;
    border-radius: 5px;
}

@page{
    size:A5 portrait;
    margin:8mm;
}

@media print{

    body{
        background:#fff;
    }

    .receipt{
        width:100%;
        min-height:auto;
        margin:0;
        border:none;
        box-shadow:none;
        padding:0;
    }

    .no-print{
        display:none !important;
    }

    .table{
        page-break-inside:avoid;
    }
}
    </style>

</head>
<body>

<div class="text-center my-3 no-print">
    <button class="btn btn-primary" onclick="window.print()">Print Receipt</button>
</div>
<div class="receipt">

    <div class="header">
        <h3><img src="/upload/receitp_logo.PNG" alt="" width="100%" height="100px" ></h3>
        <p>{{setting()->address}}, Facebook: {{setting()->facebook}}</p>
        <p>Phone: {{setting()->contact}},  Email: {{setting()->email}}</p>
        <h5 class="mt-2 header_button">LAB TEST RECEIPT</h5>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <table class="table table-bordered">
                <tr>
                    <th width="40%">Receipt No</th>
                    <td>{{$patient->unique_id}}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{$patient->created_at->format('d-M-Y')}}</td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td>{{$patient->created_at->format('h:i A')}}</td>
                </tr>
            </table>
        </div>

        <div class="col-6">
            <table class="table table-bordered">
                <tr>
                    <th width="40%">Patient ID</th>
                    <td>P-{{$patient->unique_id}}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{$patient->name}}</td>
                </tr>
                <tr>
                    <th>Age / Gender</th>
                    <td>{{$patient->age}} Years / {{$patient->gender->name}}</td>
                </tr>
            </table>
        </div>
    </div>

    <table class="table table-bordered mb-3">
        <tr>
            <th width="25%">Mobile</th>
            <td>{{$patient->contact}}</td>

            <th width="25%">Ref. Doctor</th>
            <td>{{$patient->doctor->name}}</td>
        </tr>
    </table>

    <table class="table table-bordered">
        <thead class="table-light">
        <tr>
            <th width="8%">SL</th>
            <th>Test Name</th>
            <th width="15%">Price</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($patient->tests as $key=>$item)
           <tr>
                <td>{{++$key}}</td>
                <td>{{$item->test->name}}</td>
                <td class="text-end">{{$item->rate}}</td>
            </tr> 
        @endforeach
        


        </tbody>
    </table>

    <div class="row">

        <div class="col-7">
            <p><strong>Payment Method:</strong> Cash</p>
            <p><strong>Collected By:</strong> {{$patient->user->name}}</p>
        </div>

        <div class="col-5">

            <table class="table table-bordered">

                <tr>
                    <th>Grand Total</th>
                    <td class="text-end">{{$patient->total}}</td>
                </tr>

                <tr>
                    <th>Discount</th>
                    <td class="text-end">{{$patient->discount_amount}}</td>
                </tr>

                <tr>
                    <th>Net Total</th>
                    <td class="text-end">{{$patient->grand_total}}</td>
                </tr>

                <tr>
                    <th>Paid</th>
                    <td class="text-end">{{$patient->paid}}</td>
                </tr>

                <tr>
                    <th>Due</th>
                    <td class="text-end text-danger fw-bold">{{$patient->grand_total - $patient->paid}}</td>
                </tr>

            </table>

        </div>

    </div>

    <div class="d-flex justify-content-between signature">

        <div>
            Patient Signature
        </div>

        <div>
            Authorized Signature
        </div>

    </div>

    <div class="text-center mt-4">
        <small>This is a computer-generated receipt.</small>
    </div>

</div>


</body>
</html>