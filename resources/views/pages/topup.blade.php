@extends('layout.home')


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Top-Up Saldo</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <h5>Saldo Anda Saat Ini: Rp {{ number_format(session('balance', $balance), 0, ',', '.') }}</h5>
                    </div>

                    <form action="{{ url('/top-up') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Jumlah</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Top-Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection