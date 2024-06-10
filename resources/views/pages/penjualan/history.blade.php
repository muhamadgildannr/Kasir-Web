@extends('layout.home')
@section('title', 'Riwayat Transaksi')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Riwayat Transaksi</h1>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tabel Log</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Informasi Pelanggan</th>
                                <th>Informasi Transaksi</th>
                                <th>Informasi Produk</th>
                            </tr>
                            @forelse ($penjualanTransaction->sortByDesc("created_at") as $penjualan)
                                <tr>
                                    <td class="py-3">
                                        <p class="m-0" style="line-height: 1.5em"><b>Nama
                                                :</b>{{ $penjualan->pelanggan->customer_name }}</p>
                                        <p class="m-0" style="line-height: 1.5em"><b>Alamat
                                                :</b>{{ $penjualan->pelanggan->address == null ? '-' : $penjualan->pelanggan->address }}
                                        </p>
                                        <p class="m-0" style="line-height: 1.5em"><b>No Telepon
                                                :</b>{{ $penjualan->pelanggan->no_phone }}</p>
                                    </td>
                                    <td class="py-3">
                                        <p class="m-0" style="line-height: 1.5em"><b>Tanggal
                                                :</b>{{ $penjualan->sale_date }}
                                        </p>
                                        <p class="m-0" style="line-height: 1.5em"><b>Total Bayar
                                                :</b>Rp{{ number_format($penjualan->total_price, 2, ',', '.') }}</p>
                                    </td>
                                    <td class="py-3">
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#listProduk{{ $penjualan->id }}">Lihat Daftar Produk</button>
                                    </td>
                                </tr>
                                <div class="modal fade" tabindex="-1" role="dialog" id="listProduk{{ $penjualan->id }}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Daftar Produk</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @foreach ($detailTransaction as $detail)
                                                @php
                                                    $found = false;
                                                @endphp
                                                @foreach ($logStockOut as $log)
                                                    @if ($detail->penjualan_id == $penjualan->id && $log->product_id == $detail->product->id)
                                                        @php
                                                            $found = true;
                                                        @endphp
                                                        <div class="modal-body p-3">
                                                            <div class="w-100 bg-dark p-3 rounded"
                                                                style="max-height: 200px; overflow-y: auto">
                                                                <p class="m-0" style="line-height: 1.5em"><b>Nama Produk
                                                                        :</b>{{ $detail->product->product_name }}</p>
                                                                <p class="m-0" style="line-height: 1.5em"><b>Kode Produk
                                                                        :</b>{{ $detail->product->code }}</p>
                                                                <p class="m-0" style="line-height: 1.5em"><b>Harga Satuan
                                                                        :</b>Rp{{ number_format($detail->product->price,2,",".".") }}</p>
                                                                <p class="m-0" style="line-height: 1.5em"><b>Total Produk
                                                                        :</b>{{ $log->total_stock }} Unit</p>
                                                                <p class="m-0" style="line-height: 1.5em"><b>Total Harga
                                                                        :</b>Rp{{ number_format($log->total_stock * $detail->product->price,2,",".".") }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @break
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr class="text-center">
                                <td colspan="5">Belum ada data</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
