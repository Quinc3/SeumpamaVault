@extends('layouts.app')

@section('content')
    <h2 class="text-4xl font-extrabold mb-8">Transaksi Inventory</h2>

    @if($errors->any())
    <div class="mb-6 bg-red-100 text-red-700 px-5 py-4 rounded-2xl font-bold">
        {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm">
        @csrf

        <div class="grid grid-cols-3 gap-5 mb-6">
            <input type="text" name="transaction_code" value="{{ $code }}" class="rounded-xl border-slate-200" readonly>
            <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="rounded-xl border-slate-200">

            <select name="transaction_type_id" class="rounded-xl border-slate-200">
                @foreach($types as $t)
                <option value="{{ $t->id }}">{{ $t->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-5 mb-6">
            <div>
                <label class="font-bold text-sm">Total Budget</label>
                <input type="number" name="total_budget" value="0" class="w-full mt-2 rounded-xl border-slate-200">
            </div>

            <div>
                <label class="font-bold text-sm">Upload Evidence</label>
                <input type="file" name="evidence_file" class="w-full mt-2 rounded-xl border-slate-200 bg-white">
            </div>
        </div>

        <table class="w-full mb-5" id="items-table">
            <thead>
                <tr class="text-left text-slate-400 text-xs uppercase">
                    <th class="py-3">Item</th>
                    <th class="py-3">Qty</th>
                    <th class="py-3">Harga</th>
                    <th class="py-3">Subtotal</th>
                    <th class="py-3"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button type="button" onclick="addRow()" class="bg-indigo-500 text-white px-4 py-2 rounded-xl font-bold">
            + Tambah Item
        </button>

        <div class="mt-6">
            <label class="font-bold text-sm">Deskripsi</label>
            <textarea name="description" class="w-full mt-2 rounded-2xl border-slate-200"></textarea>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-bold">Total: Rp <span id="total">0</span></h3>
        </div>

        <button class="mt-6 primary-gradient text-white px-6 py-3 rounded-2xl font-bold">
            Simpan Transaksi
        </button>
    </form>

<script>
    let rowIndex = 0;

    function addRow() {
        const row = `
        <tr>
            <td class="py-2">
                <select name="items[${rowIndex}][item_id]" class="w-full border-slate-200 rounded-xl">
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="py-2">
                <input type="number" name="items[${rowIndex}][qty]" value="1" min="1" oninput="calc()" class="w-full border-slate-200 rounded-xl">
            </td>
            <td class="py-2">
                <input type="number" name="items[${rowIndex}][price]" value="0" min="0" oninput="calc()" class="w-full border-slate-200 rounded-xl">
            </td>
            <td class="py-2 font-bold subtotal">0</td>
            <td class="py-2 text-right">
                <button type="button" onclick="this.closest('tr').remove(); calc()" class="text-red-600 font-bold">X</button>
            </td>
        </tr>
    `;

        document.querySelector('#items-table tbody').insertAdjacentHTML('beforeend', row);
        rowIndex++;
        calc();
    }

    function calc() {
        let total = 0;

        document.querySelectorAll('#items-table tbody tr').forEach(row => {
            const qty = Number(row.querySelector('input[name*="[qty]"]').value || 0);
            const price = Number(row.querySelector('input[name*="[price]"]').value || 0);
            const sub = qty * price;

            row.querySelector('.subtotal').innerText = sub.toLocaleString('id-ID');
            total += sub;
        });

        document.getElementById('total').innerText = total.toLocaleString('id-ID');
    }

    addRow();
</script>
@endsection