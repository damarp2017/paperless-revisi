<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Paperless Invoice</title>

    <style type="text/css" media="all">
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 50px;
            line-height: 50px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            Paperless
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            Seller<br>
                            <b>{{ $details->store->name }}</b><br>
                            {{ $details->store->address }}<br>
                            {{ $details->store->phone }}
                        </td>

                        <td>
                            Code #: <b>{{ $details->id }}</b><br>
                            Created: <b>{{ $details->created_at->format('d F Y') }}</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>
                Item
            </td>
            <td>
                Price
            </td>
        </tr>

        @foreach($details->order_detail as $item)
            <tr class="item">
                <td>
                    {{ $item->name . ' x ' . $item->quantity }}
                    @if($item->discount_by_percent != 0)
                        (disc.10%)
                    @else
                    @endif
                </td>

                <td>
                    @if($item->discount_by_percent != 0)
                        Rp. {{ number_format($item->price * $item->quantity - ($item->price * $item->quantity * ($item->discount_by_percent/100)), 2) }}
                    @else
                        Rp. {{ number_format($item->price * $item->quantity, 2) }}
                    @endif
                </td>
            </tr>
        @endforeach

        <tr class="total">
            <td></td>

            <td>
                Diskon: Rp. {{ number_format($details->total_discount, 2) }}
            </td>
        </tr>

        <tr class="total">
            <td></td>

            <td>
                Total Sebelum Diskon: Rp. {{ number_format($details->total_price, 2) }}
            </td>
        </tr>

        <tr class="total">
            <td></td>

            <td>
                Total Setelah Diskon: Rp. {{ number_format($details->total_price_with_discount, 2) }}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
