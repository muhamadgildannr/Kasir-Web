@extends('layout.auth')
@section('auth')
<div class="wrapper">
    <section class="form login">
        <header>Login</header>
        <div class="card-body">
            @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="field input">
                <label>Email</label>
                <input name="email" type="text" placeholder="Enter your email">
            </div>
            <div class="field input">
                <label>Password</label>
                <input name="password" type="password" placeholder="Password">
                <i class="fas fa-eye"></i>
            </div>
            <div class="field button">
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="link">Not yet signed up? <a href="{{ route('register') }}">Signup now</a></div>
    </section>
</div>
@endsection