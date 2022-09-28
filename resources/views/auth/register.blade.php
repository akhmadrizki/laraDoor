@extends('layouts.app')

@section('title') Register @endsection

@section('content')
<div class="login-box-head">
    <h1 class="mb-5">Register</h1>
    <p class="text-lgray">Please fill the information below...</p>
</div>

<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="login-box-body">
        <div class="form-group">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Name" autofocus>
            @error('name')
            <p class="mt-5 small text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="E-mail" value="{{ old('email') }}">
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
            <a href="{{ route('post.index') }}" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </div>
</form>
@endsection