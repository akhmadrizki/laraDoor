@extends('layouts.app')

@section('title') Register Success @endsection

@section('content')
<div class="login-box-head text-center">
    <h1>Membership Register ✔️</h1>
</div>
<div class="login-box-body text-center">
    <p>
        Thank you for your registration. Membership is now
        complete.
    </p>
</div>
<div class="login-box-footer">
    <div class="text-center">
        <a href="{{ route('post.index') }}" class="btn btn-primary">Back to Home</a>
    </div>
</div>
@endsection