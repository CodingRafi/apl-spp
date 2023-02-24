@extends('mylayouts.guard')

{{-- @push('css')
<style>
  body {
    color: #999;
    background: #f5f5f5;
    font-family: "Varela Round", sans-serif;
  }

  .form-control {
    box-shadow: none;
    border-color: #ddd;
  }

  .form-control:focus {
    border-color: #4aba70;
  }

  .login-form {
    width: 350px;
    margin: 0 auto;
    padding: 30px 0;
  }

  .login-form form {
    color: #434343;
    border-radius: 1px;
    margin-bottom: 15px;
    background: #fff;
    border: 1px solid #f3f3f3;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 30px;
  }

  .login-form h4 {
    text-align: center;
    font-size: 22px;
    margin-bottom: 20px;
  }

  .login-form .avatar {
    color: #fff;
    margin: 0 auto 30px;
    text-align: center;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    z-index: 9;
    background: #4aba70;
    padding: 15px;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
  }

  .login-form .avatar i {
    font-size: 62px;
  }

  .login-form .form-group {
    margin-bottom: 20px;
  }

  .login-form .form-control,
  .login-form .btn {
    min-height: 40px;
    border-radius: 2px;
    transition: all 0.5s;
  }

  .login-form .close {
    position: absolute;
    top: 15px;
    right: 15px;
  }

  .login-form .btn {
    background: #4aba70;
    border: none;
    line-height: normal;
  }

  .login-form .btn:hover,
  .login-form .btn:focus {
    background: #42ae68;
  }

  .login-form .checkbox-inline {
    float: left;
  }

  .login-form input[type="checkbox"] {
    margin-top: 2px;
  }

  .login-form .forgot-link {
    float: right;
  }

  .login-form .small {
    font-size: 13px;
  }

  .login-form a {
    color: #4aba70;
  }
</style>
@endpush --}}

@section('content')

<div class="container-fluid">
  <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('login') }}" method="POST">
            @csrf
            {{-- <h4 class="modal-title">Login to Your Account</h4> --}}
            <h3 class="mb-3" style="color: #263238;">Masuk</h3>
            <div class="mb-3">
              <select class="form-control select-pilihan text-dark" style="width: 100%; border-radius: 5px" name="role">
                <option value="" selected>Masuk Sebagai</option>
                @foreach ($roles as $role)
                <option value="{{ $role->name }}" style="text-transform: capitalize;">{{ str_replace("_", " ",
                  $role->name_long) }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3 login">
              <label for="login" class="form-label">Email</label>
              <input type="email" class="form-control" id="login" name="login" style="width: 100%;" disabled placeholder="Masukkan email">
            </div>
            <div class="mb-3 password">
              <label class="form-label" for="password">Password</label>
              <input type="password" id="password" class="form-control input-password" name="password"
                style="width: 100%; border: 1px solid rgb(205, 205, 205); border-radius: 5px"
                placeholder="&nbsp;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                disabled>
            </div>
            {{-- <div class="mb-3">
              <div class="container p-0">
                <div class="row" style=" width: 100%; display: flex; justify-content: space-between;">
                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="remember" name="remember">
                      <label class="form-check-label m-0" for="remember">Remember Me</label>
                    </div>
                  </div>
                  <div class="col-6 d-flex justify-content-end align-items-center">
                    <a href="forgot-password"
                      style="font-size: 12.5px; text-decoration: none; font-weight: 600; color:#3bae9c;">Lupa
                      Password?</a>
                  </div>
                </div>
              </div>
            </div> --}}
            <div class="mb-3">
              <div class="d-grid gap-2">
                <button class="btn text-white tombol-login" type="submit"
                  style="background: #3bae9c; width: 100%;" disabled>Masuk</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center small">Don't have an account? <a href="#">Sign up</a></div>
</div>
@endsection

@push('js')
<script>
  $('.select-pilihan').on('change', function(){
    if ($(this).val() == '') {
      $('.login input, .password input, .tombol-login').attr('disabled', 'disabled').val();
    }else{
      $('.password input').val('').removeAttr('disabled');
      $('.tombol-login').removeAttr('disabled');

      if($(this).val() == 'siswa'){
        $('.login input').val('').attr('type', 'number').removeAttr('disabled').attr('placeholder', 'Masukkan NIPD').parent().children("label").html('NIPD');
      }else if($(this).val() == 'super_admin' || $(this).val() == 'admin'){
        $('.login input').val('').attr('type', 'email').removeAttr('disabled').attr('placeholder', 'Masukkan email').parent().children("label").html('Email');
      }else{
        $('.login input').val('').attr('type', 'number').removeAttr('disabled').attr('placeholder', 'Masukkan NIP').parent().children("label").html('NIP');
      }
    }
  })
</script>
@endpush