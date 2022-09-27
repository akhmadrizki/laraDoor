@extends('layouts.authentication')

@section('title') Login @endsection

@section('content')
<div class="login-box-head">
    <h1 class="mb-5">Login</h1>
    <p class="text-lgray">Please login to continue...</p>
</div>
<div class="login-box-body">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Username">
        <p class="mt-5 small text-danger">*this field can't be empty</p>
    </div>
    <div class="form-group">
        <input type="password" class="form-control" placeholder="Password">
        <p class="mt-5 small text-danger hide">*this field can't be empty</p>
    </div>
</div>
<div class="login-box-footer">
    <div class="text-right">
        <a href="index.php" class="btn btn-primary">Submit</a>
    </div>
</div>
@endsection