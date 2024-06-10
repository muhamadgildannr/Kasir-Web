@extends('layout.home')
@section('title', 'Stock')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>List Stok</h1>
        </div>
    </section>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <b>Success:</b>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <b>Fail:</b>
                {{ session('fail') }}
            </div>
        </div>
    @endif
    @if (session('err'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <b>Error:</b>
                {{ session('err') }}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tabel Stok</h4>
                    <div class="card-header-form">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" data-toggle="modal"
                                    data-target="#addStockModal"><i class="fas fa-plus"></i> Tambah Produk Baru</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Unit</th>
                                <th>Kode</th>
                                <th>Aksi</th>
                            </tr>
                            @forelse ($stockList as $stock)
                                <tr>
                                    <td>{{ $stock->product_name }}</td>
                                    <td>Rp{{ number_format($stock->price, 2, ',', '.') }}</td>
                                    <td>{{ $stock->stock }}</td>
                                    <td>{{ $stock->code }}</td>
                                    <td>
                                        <button class="btn btn-success" type="button" data-toggle="modal"
                                            data-target="#editStockModal{{ $stock->id }}">Tambah Unit</button>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#editProdukModal{{ $stock->id }}">Edit Produk</button>
                                    </td>
                                </tr>

                                <div class="modal fade" tabindex="-1" role="dialog"
                                    id="editStockModal{{ $stock->id }}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Unit</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('stock.update.stock', $stock->id) }}"
                                                class="needs-validation" novalidate="">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="d-block">
                                                            <label for="stock" class="control-label">Masukan Unit<span
                                                                    class="text-danger">*</span></label>
                                                        </div>
                                                        <input id="stock" class="form-control" name="stock"
                                                            tabindex="2" type="number" required>
                                                        <div class="invalid-feedback">
                                                            please fill in unit product
                                                        </div>
                                                        <small><b>*</b>Isi dengan teliti</small>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="d-block">
                                                            <label for="description" class="control-label">Deskripsi</label>
                                                        </div>
                                                        <textarea name="description" id="description" class="form-control"></textarea>
                                                        <div class="invalid-feedback">
                                                            please fill in description
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-whitesmoke br">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Batal</button>
                                                    <button class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" role="dialog"
                                    id="editProdukModal{{ $stock->id }}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Produk</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('stock.update', $stock->id) }}"
                                                class="needs-validation" novalidate="">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="product_name">Nama Produk<span
                                                                class="text-danger">*</span></label>
                                                        <input id="product_name" class="form-control" name="product_name"
                                                            tabindex="1" value="{{ $stock->nama_produk }}"
                                                            type="text" required autofocus>
                                                        <div class="invalid-feedback">
                                                            Silahkah isi nama produk
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="d-block">
                                                            <label for="price" class="control-label">Harga<span
                                                                    class="text-danger">*</span></label>
                                                        </div>
                                                        <input id="price" class="form-control" name="price"
                                                            tabindex="2" value="{{ $stock->harga }}" type="number"
                                                            required>
                                                        <div class="invalid-feedback">
                                                            Silahkan isi nama produk
                                                        </div>
                                                    </div>

                                                    {{-- <div class="form-group">
                                                        <div class="d-block">
                                                            <label for="stock" class="control-label">Stock</label>
                                                        </div>
                                                        <input id="stock" class="form-control" name="stock" tabindex="2" type="number"
                                                            required>
                                                        <div class="invalid-feedback">
                                                            please fill in product stock
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <div class="modal-footer bg-whitesmoke br">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Batal</button>
                                                    <button class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="addStockModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('stock.store') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_name">Nama Produk<span class="text-danger">*</span></label>
                            <input id="product_name" class="form-control" name="product_name" tabindex="1"
                                type="text" required autofocus>
                            <div class="invalid-feedback">
                                Silahkan isi nama produk
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="price" class="control-label">Harga<span
                                        class="text-danger">*</span></label>
                            </div>
                            <input id="price" class="form-control" name="price" tabindex="2" type="number"
                                required>
                            <div class="invalid-feedback">
                                Silahkan isi harga produk
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="stock" class="control-label">Unit<span
                                        class="text-danger">*</span></label>
                            </div>
                            <input id="stock" class="form-control" name="stock" tabindex="2" type="number"
                                required>
                            <div class="invalid-feedback">
                                Silahkan isi berapa unit produk
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="description" class="control-label">Deskripsi<span
                                        class="text-danger"></span></label>
                            </div>
                            <textarea id="description" class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
