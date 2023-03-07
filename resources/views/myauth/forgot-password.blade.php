@extends('mylayouts.guard')

@push('css')
<style>
  .card-login {
    border-radius: 13px;
  }
</style>
@endpush

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center align-items-center" style="min-height: 100vh;background-color: #EBEBEB;">
    <div class="col-md-5">
      <div class="card card-login">
        <div class="card-body p-4">
          @if (session()->has('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <form class="pt-3" action="{{ route('password.email') }}" method="post">
            @csrf
            <h2 class="text-center mb-3" style="color: #263238;">Reset Password</h2>
            <div class="mb-3 login">
              <input type="email" class="form-control w-100" id="email" name="email" placeholder="Email">
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-primary w-100">Send
                Reset Password</button>
            </div>
          </form>
        </div>
      </div>
      <a href="/login" class="d-flex justify-content-center mt-3"><i class="bi bi-arrow-left-circle mr-2"></i>
        Back to login</a>
    </div>
  </div>
  <div class="text-center small">Don't have an account? <a href="#">Sign up</a></div>
</div>
@endsection