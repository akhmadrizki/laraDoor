@extends('layouts.app')

@section('title') Register Success @endsection

@section('content')
<div class="login-box-head text-center">
    <h1>Successfully Registered</h1>
</div>
<div class="login-box-body text-center">
    <p>
        Thank you for your membership register.<br />
        We send confirmation e-mail to you. Please complete the registration by clicking the confirmation URL
        <b>to use all of our services.</b><br />
        If you did not receive the email
    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link mt-5 align-baseline">click here to request
            another</button>.
    </form>
    </p>
</div>
<div class="login-box-footer">
    <div class="text-center">
        <a href="{{ route('post.index') }}" class="btn btn-primary">Back to Home</a>
    </div>
</div>
@endsection