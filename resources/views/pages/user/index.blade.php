@extends('layout.home')
@section('title', 'Accounts')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>List Akun</h1>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tabel Akun</h4>
                    <div class="card-header-form">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <a href="{{ route('users.export') }}" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
                                <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                                    Akun Baru</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Terakhir Login</th>
                                <th>Aksi</th>
                            </tr>
                            @foreach ($userAccounts as $acc)
                                <tr>
                                    <td>{{ $acc->name }}</td>
                                    <td>{{  $acc->email }}</td>
                                    @if ($acc->role == 'admin')
                                        <td>
                                            <div class="badge badge-danger">Admin</div>
                                        </td>
                                    @else
                                        <td>
                                            <div class="badge badge-warning">Petugas</div>
                                        </td>
                                    @endif
                                    @if ($acc->last_login == null)
                                        <td>Belum Login</td>
                                    @else
                                        <td>{{ $acc->last_login }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('user.edit', $acc->id) }}" class="btn btn-primary">Edit</a>
                                        @if (Auth::user()->id != $acc->id)
                                            <button class="btn btn-danger" type="button" data-toggle="modal"
                                                data-target="#deleteConfirm{{ $acc->id }}">Delete</button>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirm{{ $acc->id }}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin ingin menghapus data?</p>
                                            </div>
                                            <div class="modal-footer bg-whitesmoke br">
                                                <form method="post" action="{{ route('user.delete', $acc->id) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger" type="submit">Yes</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $userAccounts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
