@extends('layout.home')
@section('title', 'Stock Keluar')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Stock Out</h1>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Logs Table</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>Officer Name</th>
                                <th>Date In</th>
                            </tr>
                            @forelse ($stockOutList->sortByDesc("created_at") as $stock)
                                <tr>
                                    <td>{{ $stock->product->product_name }}</td>
                                    <td>{{ $stock->total_stock }}</td>
                                    <td>{{ $stock->user->name }}</td>
                                    <td>{{ $stock->created_at }}</td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="4">Belum ada data</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
