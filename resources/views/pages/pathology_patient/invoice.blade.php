<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Receipt</title>
    <style>
        @font-face {
            font-family: 'Libre Barcode 39';
            font-style: normal;
            font-weight: 400;
            src: local('Libre Barcode 39 Regular'), local('LibreBarcode39-Regular'), url(fonts/-nFnOHM08vwC6h8Li1eQnP_AHzI2G_Bx0g.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        #memo {
            width:600px;
            /* width: 460px; */
            min-height: 200px;
            height: auto;
            margin: auto;
            margin-top:60px;
        }

        #main_page {
            width:600px;
            /* width: 460px; */
            height: auto;
            margin: auto;
        }

        #invoice_1 {
            width:600px;
            /* width: 460px; */
            height: 792px;
        }

        #invoice_2 {
            width:600px;
            /* width: 460px; */
            height: 792px;
            display: none;
        }

    </style>
    <style media="print">
        #invoice_2 {
            display: inline-table;
        }

        #print_btn {
            display: none;
        }
    </style>
</head>

</html>
<center><button onclick="window.print()" id="print_btn" style="padding:5px 15px; font-weight:bold">Print</button></center>
<div id="main_page">

    <!--------- Start Invoice Part 1 ---------->

    @php
    $setting = setting();
    @endphp

    <div id="memo" class="page-break">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="5" style="padding-bottom:10px">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>

                            <td align="center" valign="top">
                                <font style="font-size:18px; font-weight:bold"><b>{{$setting->name}}</b></font>
                                <font style="font-size:14px ;font-weight:bold"><br />{{$setting->address}}</font>
                                <font style="font-size:14px ;font-weight:bold"><br />{{$setting->contact ??''}}</font>
                            </td>
                            <td valign="top" align="center">
                                <font style="font-size:14px; font-weight:bold">Lab Copy</font>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="2" width="100%" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:12px">
                                    <tr>
                                        <td style="font-weight:bold" width="70px">Patient</td>
                                        <td width="20px">:</td>
                                        <td style="font-weight:bold">{{$patient->name}}</td>
                                        <td style="font-weight:bold" width="70px">Mobile</td>
                                        <td width="20px">:</td>
                                        <td style="font-weight:bold">{{$patient->contact}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold" width="50px">ID</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold">{{$patient->unique_id ?? null}}</td>
                                        <td style="font-weight:bold" width="50px">Age</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold">{{$patient->age}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold" width="50px">Date</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold">{{$patient->updated_at->format("d-M-Y h:i:s")}}</td>
                                        <td style="font-weight:bold" width="50px">Sex</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold">{{$patient->gender->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold" width="50px">Refd. By.</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold" colspan="4">{{$patient->doctor->name ?? 'N/A'}}</td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                        <tr style="font-weight:bold; font-style:italic; text-align:center; font-size:14px">
                            <th style="border:1px solid #000; border-right:none; font-weight:bold" width="75%">Test Name / Tube Name</th>

                            <th width="25%" style="border:1px solid #000; border-right:none; font-weight:bold">Amount</th>
                        </tr>

                        @foreach ($patient->tests as $key=>$test)
                        <tr style="font-size:14px">
                            <td style="padding:3px ;font-weight:bold ; text-align:left">{{$test->test->name ?? 'N/A'}}</td>
                            <td style="padding:3px ;font-weight:bold; width:100px !important" align="right">{{$test->test->rate ?? 'N/A'}}</td>
                        </tr>

                        @endforeach

                        <tr>
                            <td colspan="5" style="border-top:1px solid">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:12px">
                                    <tr>
                                        <td width="60%" valign="top" style="padding:2px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                                <tr>
                                                    <td width="60px" style="padding:1px; font-weight:normal; font-size:9px" colspan="3" align="left">
                                                        * বিশেষ কারণে পরীক্ষা নিরীক্ষা ও রিপোর্ট ডেলিভারি বিলম্ব হতে পারে।<br />
                                                        * রিপোর্ট ডেলিভারির সময় এই মেমো অবশ্যই নিয়ে আসতে হবে।
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="60px" style="padding:2px; font-weight:bold">Prepd. By</td>
                                                    <td width="10px">:</td>
                                                    <td width="250px" style="padding:2px">{{$patient->user->name ?? 'N/A'}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top" style="padding:2px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                                <tr>
                                                    <td width="200px" style="font-weight:bold">Sub Total</td>
                                                    <td width="10px">:</td>
                                                    <td width="150px" align="right">{{$patient->total}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="200px" style="font-weight:bold">Discount</td>
                                                    <td width="10px">:</td>
                                                    <td width="150px" align="right">{{$patient->discount_amount}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="200px" style="font-weight:bold; border-top:1px solid">Grand Total</td>
                                                    <td width="10px" style="border-top:1px solid">:</td>
                                                    <td width="150px" align="right" style="border-top:1px solid">{{$patient->grand_total}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="200px" style="font-weight:bold; border-top:1px solid">Paid Amount</td>
                                                    <td width="10px" style="border-top:1px solid">:</td>
                                                    <td width="150px" align="right" style="border-top:1px solid">{{$patient->paid}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="200px" style="font-weight:bold; border-top:1px solid">Due Amount</td>
                                                    <td width="10px" style="border-top:1px solid">:</td>
                                                    <td width="150px" align="right" style="border-top:1px solid">{{$patient->grand_total - $patient->paid}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="center" style="font-size:20px; font-weight:bold">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding-top:0px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                                <tr>
                                                    <td colspan="2" align="left"><b>Delivery Date: ......................</b></td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><u><b>Report Delivered By</b></u></td>
                                                    <td align="right"><u><b>Authorized Signature</b></u></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding-top:30px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                                <tr>
                                                    <td colspan="2" align="left"><b><u></u></b></td>
                                                    <td colspan="2" align="right"><b><u></u></b></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div id="memo">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="5" style="padding-bottom:10px">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>

                            <td align="center" valign="top">
                                <font style="font-size:18px; font-weight:bold"><b>{{$setting->name}}</b></font>
                                <font style="font-size:14px ;font-weight:bold"><br />{{$setting->address}}</font>
                                <font style="font-size:14px ;font-weight:bold"><br />{{$setting->contact ??''}}</font>
                            </td>
                            <td valign="top" align="center">
                                <font style="font-size:14px; font-weight:bold">Patient's Copy</font>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="2" width="100%" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:12px">
                                    <tr>
                                        <td style="font-weight:bold" width="70px">Patient</td>
                                        <td width="20px">:</td>
                                        <td style="font-weight:bold">{{$patient->name}}</td>
                                        <td style="font-weight:bold" width="70px">Mobile</td>
                                        <td width="20px">:</td>
                                        <td style="font-weight:bold">{{$patient->contact}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold" width="50px">ID</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold">{{$patient->unique_id ?? null}}</td>
                                        <td style="font-weight:bold" width="50px">Age</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold">{{$patient->age}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold" width="50px">Date</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold">{{$patient->updated_at->format("d-M-Y h:i:s")}}</td>
                                        <td style="font-weight:bold" width="50px">Sex</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold">{{$patient->gender->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold" width="50px">Refd. By.</td>
                                        <td width="10px">:</td>
                                        <td style="font-weight:bold" colspan="4">{{$patient->doctor->name ?? 'N/A'}}</td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                        <tr style="font-weight:bold; font-style:italic; text-align:center; font-size:14px">
                            <th style="border:1px solid #000; border-right:none; font-weight:bold" width="75%">Test Name / Tube Name</th>

                            <th width="25%" style="border:1px solid #000; border-right:none; font-weight:bold">Amount</th>
                        </tr>

                        @foreach ($patient->tests as $key=>$test)
                        <tr style="font-size:14px">
                            <td style="padding:3px ;font-weight:bold ; text-align:left">{{$test->test->name ??'N/A'}}</td>
                            <td style="padding:3px ;font-weight:bold; width:100px !important" align="right">{{$test->test->rate ?? 'N/A'}}</td>
                        </tr>

                        @endforeach
                        
                        <tr>
                            <td colspan="5" style="border-top:1px solid">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:12px">
                                    <tr>
                                        <td width="60%" valign="top" style="padding:2px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                                <tr>
                                                    <td width="60px" style="padding:1px; font-weight:normal; font-size:9px" colspan="3" align="left">
                                                        * বিশেষ কারণে পরীক্ষা নিরীক্ষা ও রিপোর্ট ডেলিভারি বিলম্ব হতে পারে।<br />
                                                        * রিপোর্ট ডেলিভারির সময় এই মেমো অবশ্যই নিয়ে আসতে হবে।
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="60px" style="padding:2px; font-weight:bold">Prepd. By</td>
                                                    <td width="10px">:</td>
                                                    <td width="250px" style="padding:2px">{{$patient->user->name ?? 'N/A'}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top" style="padding:2px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                                <tr>
                                                    <td width="200px" style="font-weight:bold">Sub Total</td>
                                                    <td width="10px">:</td>
                                                    <td width="150px" align="right">{{$patient->total}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="200px" style="font-weight:bold">Discount</td>
                                                    <td width="10px">:</td>
                                                    <td width="150px" align="right">{{$patient->discount_amount}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="200px" style="font-weight:bold; border-top:1px solid">Grand Total</td>
                                                    <td width="10px" style="border-top:1px solid">:</td>
                                                    <td width="150px" align="right" style="border-top:1px solid">{{$patient->grand_total}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="200px" style="font-weight:bold; border-top:1px solid">Paid Amount</td>
                                                    <td width="10px" style="border-top:1px solid">:</td>
                                                    <td width="150px" align="right" style="border-top:1px solid">{{$patient->paid}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="200px" style="font-weight:bold; border-top:1px solid">Due Amount</td>
                                                    <td width="10px" style="border-top:1px solid">:</td>
                                                    <td width="150px" align="right" style="border-top:1px solid">{{$patient->grand_total - $patient->paid}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="center" style="font-size:20px; font-weight:bold">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding-top:0px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                                <tr>
                                                    <td colspan="2" align="left"><b>Delivery Date: ......................</b></td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><u><b>Report Delivered By</b></u></td>
                                                    <td align="right"><u><b>Authorized Signature</b></u></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding-top:30px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                                <tr>
                                                    <td colspan="2" align="left"><b><u></u></b></td>
                                                    <td colspan="2" align="right"><b><u></u></b></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </div>


</div>

</html>