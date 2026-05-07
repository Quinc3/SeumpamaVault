<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Inventory</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #4f46e5;
            color: white;
            padding: 8px;
        }

        td {
            padding: 6px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>LAPORAN INVENTORY ASET</h2>
    <p class="subtitle">
        Tanggal Cetak: {{ date('d M Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barcode</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp

            @foreach($inventories as $index => $inv)
            @php
            $total = $inv->quantity * $inv->price;
            $grandTotal += $total;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $inv->barcode }}</td>
                <td>{{ $inv->item->name ?? '-' }}</td>
                <td>{{ $inv->quantity }}</td>
                <td class="text-right">Rp {{ number_format($inv->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <div class="footer">
        Total Keseluruhan: Rp {{ number_format($grandTotal, 0, ',', '.') }}
    </div>

</body>

</html>