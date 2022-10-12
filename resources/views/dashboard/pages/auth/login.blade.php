@extends('layouts.app')

@section('title') Admin Login @endsection

@section('content')
<div class="login-box-head">
    <h1 class="mb-5">Admin Login</h1>
    <p class="text-lgray">Please login to continue...</p>
</div>

<form action="{{ route('admin.login') }}" method="POST">
    @csrf
    <div class="login-box-body">
        <div class="form-group">
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" placeholder="Email" autofocus>
            @error('email')
            <p class="mt-5 small text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Password">
            @error('password')
            <p class="mt-5 small text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="login-box-footer">
        <div class="text-right">
            <button type="submit" class="btn btn-info">Submit</button>
        </div>
    </div>
</form>
@endsection