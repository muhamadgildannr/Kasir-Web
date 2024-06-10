@extends('layout.home')
@section('title', 'Edit Account')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Account</h1>
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
        <div class="section-body">
            <div class="card">
                <form action="{{ route('user.update', $user->id) }}" method="post" class="needs-validation" novalidate>
                    @method('PATCH')
                    @csrf
                    <div class="card-header">
                        <h4>Input Account</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Full Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" placeholder="Dwi Putra" value="{{ $user->name }}"
                                    class="form-control" required>
                                <div class="invalid-feedback">
                                    please fill in the name
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Username<span class="text-danger">*</span></label>
                                <input type="text" name="username" placeholder="dwptra" value="{{ $user->username }}"
                                    class="form-control" required>
                                <div class="invalid-feedback">
                                    please fill in the username
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="form-group col-md-6 col-12">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                                <div class="invalid-feedback">
                                    please fill in the password
                                </div>
                            </div> --}}
                            <div class="form-group col-12">
                                <label>Role<span class="text-danger">*</span></label>
                                <select name="role" class="form-control" {{ Auth::user()->id == $user->id ? "disabled" : "" }}>
                                    <option disabled  {{ $user->hasRole('petugas') == false ? 'selected' : '' }}>Select Role</option>
                                    <option value="petugas" {{ $user->hasRole('petugas') == 'petugas' ? 'selected' : '' }}>
                                        Petugas</option>
                                    <option value="administrator"
                                        {{ $user->hasRole('administrator') == 'administrator' ? 'selected' : '' }}>
                                        Administrator</option>
                                </select>

                                {{-- {{ dd($user->hasRole('administrator')) }} --}}
                            </div>
                        </div>
                        <button class="btn btn-success">Simpan</button>
                        <a href="{{ route('user') }}" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section>
@endsection
