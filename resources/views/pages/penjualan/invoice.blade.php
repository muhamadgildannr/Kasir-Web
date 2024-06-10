@extends('layout.home')
@section('title', 'Invoice')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Invoice</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Pribadi</h4>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="row w-100 mb-3">
                        <div class="col-sm-6 col-12">
                            <b>Nama</b>
                        </div>
                        <div class="col-sm-6 col-12">
                            : {{ $name }}
                        </div>
                    </div>
                    <div class="row w-100 mb-3">
                        <div class="col-sm-6 col-12">
                            <b>Alamat</b>
                        </div>
                        <div class="col-sm-6 col-12">
                            : {{ $address == null ? '-' : $address }}
                        </div>
                    </div>
                    <div class="row w-100 mb-3">
                        <div class="col-sm-6 col-12">
                            <b>No Phone</b>
                        </div>
                        <div class="col-sm-6 col-12">
                            : {{ $phone }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Penjualan</h4>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="row w-100 mb-3">
                        <div class="col-sm-6 col-12">
                            <b>Produk yang dibeli:</b>
                        </div>
                        <div class="col-sm-6 col-12 d-none d-sm-flex flex-column">
                            <b>Harga:</b>
                        </div>
                    </div>
                    @php
                        $totalPrice = 0;
                    @endphp
                    @foreach ($items as $item)
                        <div class="row w-100 mb-3">
                            <div class="col-sm-6 col-12">
                                - {{ $item->product_name }} (Rp{{ number_format($item->price, 2, ',', '.') }})
                            </div>
                            <div class="col-sm-6 col-12">
                                @foreach ($products as $p)
                                    @if ($p['code'] == $item->code)
                                        @php
                                            $price = $p['quantity'] * $item->price;
                                            $totalPrice += $price;
                                        @endphp
                                        {{ $p['quantity'] }}x (Rp{{ number_format($price, 2, ',', '.') }})
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="row w-100 mb-3">
                        <div class="col-sm-6 col-12">
                            <b>Total Dibayar:</b>
                        </div>
                        <div class="col-sm-6 col-12">
                            Rp{{ number_format($totalPrice, 2, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <form action="{{ route('penjualan.payment') }}" method="post">
                        @csrf
                        <button class="btn btn-success">Konfirmasi Pembayaran</button>
                        <a href="{{ route('penjualan') }}" class="btn btn-danger">Cancel Pembayaran</a>
                        <a href="/downloadpdf" class="btn btn-danger">Print Invoice</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
