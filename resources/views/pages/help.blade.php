@extends('layouts.app')

@section('content')
<div class="p-10">
    <h2 class="text-4xl font-extrabold mb-6">Pusat Bantuan</h2>

    <div class="bg-white rounded-3xl p-6 shadow-sm space-y-4">
        <p><b>Master Data:</b> Untuk mengelola kategori, item, gedung, ruangan, dan jenis transaksi.</p>
        <p><b>Inventaris:</b> Untuk menambah stok barang dan barcode.</p>
        <p><b>Distribusi:</b> Untuk assign barang ke ruangan.</p>
        <p><b>Riwayat Transaksi:</b> Untuk mencatat pembelian dan penghapusan barang.</p>
        <p><b>Laporan:</b> Untuk melihat dan download laporan PDF.</p>
    </div>
</div>
@endsection