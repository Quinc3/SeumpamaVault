<!DOCTYPE html>
<html>

<head>
    <title>Print Barcode</title>
</head>

<body onload="window.print()">

    @php
    use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
    @endphp

    <div style="text-align:center; margin-top:80px;">
        <h2>{{ $inventory->item->name ?? '-' }}</h2>

        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($inventory->barcode, 'C128') }}">

        <p style="font-family: monospace; font-weight: bold;">
            {{ $inventory->barcode }}
        </p>
    </div>

</body>

</html>