<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Venta {{ $sale->invoice_number }}</title>
    <style>
        @page { margin: 1.2cm; }
        body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; }
        h1 { margin: 0 0 4px; font-size: 22px; }
        h2 { margin: 0; font-size: 16px; }
        .header { border-bottom: 2px solid #333; padding-bottom: 12px; margin-bottom: 18px; }
        .muted { color: #666; }
        .info { width: 100%; margin-bottom: 16px; }
        .info td { width: 50%; vertical-align: top; padding: 3px 0; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 14px; }
        .items th, .items td { border: 1px solid #bbb; padding: 7px; }
        .items th { background: #eee; text-align: left; }
        .right { text-align: right; }
        .totals { width: 42%; margin-left: auto; margin-top: 14px; border-collapse: collapse; }
        .totals td { padding: 5px; }
        .total { border-top: 2px solid #333; font-size: 15px; font-weight: bold; }
        .notes { margin-top: 18px; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Venta {{ $sale->invoice_number }}</h1>
        <div class="muted">Fecha: {{ $sale->sale_date->format('d/m/Y') }} | Estado: {{ ['completed' => 'Completada', 'pending_authorization' => 'En espera de autorización', 'pending' => 'Pendiente', 'cancelled' => 'Cancelada'][$sale->status] ?? ucfirst($sale->status) }}</div>
    </div>
    <table class="info">
        <tr>
            <td><strong>Cliente:</strong> {{ $sale->customer->name }}<br>{{ $sale->customer->document_number }}</td>
            <td><strong>Vendedor:</strong> {{ $sale->seller->name }}<br><strong>Pago:</strong> {{ ['cash' => 'Efectivo', 'card' => 'Tarjeta', 'transfer' => 'Transferencia', 'check' => 'Cheque'][$sale->payment_method] ?? ucfirst($sale->payment_method) }}</td>
        </tr>
        <tr>
            <td><strong>Tipo de despacho:</strong> {{ $sale->dispatchType?->name ?? 'No informado' }}</td>
            <td><strong>Dirección:</strong> {{ $sale->dispatch_address ?: 'No aplica' }}</td>
        </tr>
    </table>
    <table class="items">
        <thead><tr><th>Producto</th><th class="right">Precio unit.</th><th class="right">Cantidad</th><th class="right">Comisión fija</th><th class="right">Subtotal</th></tr></thead>
        <tbody>
            @foreach($sale->saleDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name }}<br><span class="muted">{{ $detail->product->sku }}</span></td>
                    <td class="right">${{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                    <td class="right">{{ $detail->quantity }}</td>
                    <td class="right">${{ number_format($detail->commission_unit_price ?? $detail->commission_percentage, 0, ',', '.') }}</td>
                    <td class="right">${{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="totals">
        <tr><td>Subtotal</td><td class="right">${{ number_format($sale->subtotal, 0, ',', '.') }}</td></tr>
        <tr><td>Comisión total</td><td class="right">${{ number_format($sale->total_commission, 0, ',', '.') }}</td></tr>
        <tr class="total"><td>Total</td><td class="right">${{ number_format($sale->total, 0, ',', '.') }}</td></tr>
    </table>
    @if($sale->notes)<div class="notes"><strong>Notas:</strong> {{ $sale->notes }}</div>@endif
</body>
</html>
