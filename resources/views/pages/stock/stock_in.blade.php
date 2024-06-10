@extends('layout.home')
@section('title', 'Stock Masuk')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Stock In</h1>
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
                                <th>Other</th>
                            </tr>
                            @forelse ($stockInList->sortByDesc("created_at") as $stock)
                                <tr>
                                    <td>{{ $stock->product->product_name }}</td>
                                    <td>{{ $stock->total_stock }}</td>
                                    <td>{{ $stock->user->name }}</td>
                                    <td>{{ $stock->created_at }}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#commit{{ $stock->id }}">Commit</button>
                                    </td>
                                </tr>

                                <div class="modal fade" tabindex="-1" role="dialog" id="commit{{ $stock->id }}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Deskripsi</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-3">
                                                <div class="w-100 bg-dark p-3 rounded"
                                                    style="max-height: 200px; overflow-y: auto">
                                                    <p>"{{ $stock->description }}"</p>
                                                </div>
                                            </div>
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
