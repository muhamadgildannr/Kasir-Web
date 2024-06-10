@extends('layout.home')
@section('title', 'Transaksi Penjualan')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Penjualan</h1>
        </div>
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
        <div class="section-body">
            <form action="{{ route('penjualan.invoice') }}" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Pelanggan:</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Nama<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                                <div class="invalid-feedback">
                                    Silahkan isi nama!
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>No Telp<span class="text-danger">*</span></label>
                                <input type="number" name="phone" class="form-control" required>
                                <div class="invalid-feedback">
                                    Silahkan isi nomor telepon
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Alamat</label>
                                <textarea name="address" class="form-control"></textarea>
                                <div class="invalid-feedback">
                                    Silahkan isi alamat
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Saldo Anda Saat Ini: Rp {{ number_format(session('balance', $balance), 0, ',', '.') }}</h4>
                    </div>
                </div>

                <div id="productInputs">
                    <div class="card">
                        <div class="card-body">
                            <div class="row product-input">
                                <div class="form-group col-md-4 col-12">
                                    <label>Nama Produk<span class="text-danger">*</span></label>
                                    <select class="form-control" name="code[]" id="dd" required>
                                        <option value="" disabled selected>Select Product</option>
                                        @forelse ($products as $product)
                                            <option value="{{ $product->code }}">{{ $product->product_name }}</option>
                                        @empty
                                            <option value="" disabled>No products available</option>
                                        @endforelse
                                    </select>
                                    <div class="invalid-feedback">
                                        Silahkan isi nama produk
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-12">
                                    <label>Kuantitas<span class="text-danger">*</span></label>
                                    <input type="number" name="quantity[]" class="form-control total-input" required>
                                    <div class="invalid-feedback">
                                        Silahkan isi kuantitas
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-12">
                                    <label>Diskon<span class="text-danger">*</span></label>
                                    <input type="number" name="discount[]" value="0" class="form-control total-input" required>
                                    <div class="invalid-feedback">
                                        Silahkan isi diskon
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <button type="button" class="btn btn-danger" onclick="removeProductInput(this)">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" onclick="addProductInput()">Tambah Input Produk</button>
                    <button class="btn btn-success">Buat Invoice</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function addProductInput() {
            var productInputs = document.getElementById('productInputs');
            var newProductInput = productInputs.children[0].cloneNode(true);
            newProductInput.querySelectorAll('input').forEach(function(input) {
                input.value = '';
            });
            productInputs.appendChild(newProductInput);
        }

        function removeProductInput(button) {
            var cardBody = button.closest('.card');
            if (document.querySelectorAll('.product-input').length > 1) {
                cardBody.remove();
            } else {
                alert("Tidak bisa menghapus produk terakhir!");
            }
        }
    </script>
@endsection
