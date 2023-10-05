<!DOCTYPE html>
<html>

<head>
    <title>{{ $general['fileName'] }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    @php
        $logo = $general['logo'];
    @endphp
    <table class="table" style="width:100%">
        <tr>
            <th colspan="4"><img alt="Logo" src="{{ public_path("$logo") }}" style="height: 50px;" /></th>
            <th colspan="4" style="font-size: 20px; font-weight: bold">Nictus Ecommerce Store</th>
            <th colspan="4" style="font-size: 10px;">Printing Date: {{ $general['currentDate'] }}</th>
        </tr>
    </table>

    <table class="table" style="width:100%; margin-top: 10px;">
        <tr>
            <th>For the month {{ $general['dateFrom'] }} / {{ $general['dateTo'] }}</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>

            <th>{{ $general['reportName'] }}</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>

    </table>


    <table class="table" style="border: 1px solid black; border-collapse: collapse; width: 100%">
        <thead>
            <tr>
                @foreach ($tableHeaders as $tableHeader)
                    <th style="font-size: 12px; border: 1px solid; text-align:center;">{{ $tableHeader }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($tableData as $columnData)
                <tr>
                    @foreach ($columnData as $col)
                        <td style="border: 1px solid;text-align:center;">{{ $col }}</td>
                    @endforeach

                </tr>
            @endforeach

        </tbody>
    </table>
    @if (isset($total))
        <table class="table" style="border: 1px solid black; border-collapse: collapse; width: 100%">
            <thead>
                <th>&nbsp;
                </th>
                <th>&nbsp;
                </th>
                <th>&nbsp;
                </th>
                <th>&nbsp;
                </th>
                <th>&nbsp;
                </th>
                <th>&nbsp;
                </th>

                <th>&nbsp;
                </th>
                <th>&nbsp;
                </th><th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>


                <th><b>&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                </th>
            </th><th>&nbsp;
            </th> </th><th>&nbsp;
            </th>
        </th><th>&nbsp;
        </th> </th><th>&nbsp;
        </th> </th><th>&nbsp;
        </th> </th><th>&nbsp;
        </th>
                <th><b> Total :&nbsp;&nbsp;&nbsp;&nbsp; {{ attachCurrencyDecimal(array_sum($sub_total)) }} </b>
                </th>

                <th><b>{{ attachCurrencyDecimal(array_sum($shipping_price)) }} </b>
                </th>

                <th><b>{{ attachCurrencyDecimal(array_sum($coupon_amount)) }} </b>
                </th>
                <th><b> {{ attachCurrencyDecimal(array_sum($total)) }} </b></th>
            </thead>
        </table>
    @endif
</body>

</html>
