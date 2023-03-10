<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="stylesheet" href="{{ asset('css/fstdropdown.css') }}">

  <title>Schoolio</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    .fstdropdown>.fstlist {
      min-height: 10rem !important;
    }

    .fstdiv.open .fstdropdown.open .fstsearch .fstsearchinput {
      border-color: rgb(183, 183, 183);
    }

    .btn-self {
      width: 5rem;
      margin: 0.1rem;
      border-radius: 5px;
      font-weight: 500;
      color: #fff;
      text-align: center
    }

    .btn-sidebar-self {
      width: 100%;
      border-width: 0;
      border-left: 3px solid transparent;
      text-align: left;
    }

    .sidebar-item.active form button.sidebar-link,
    .sidebar-item.active form button svg {
      background: linear-gradient(90deg, rgba(59, 125, 221, 0.1), rgba(59, 125, 221, 0.0875) 50%, transparent);
      border-left-color: #3b7ddd;
      color: #e9ecef;
    }
  </style>
  @stack('css')
</head>

<body>
  <div class="wrapper">
    @include('mypartials.aside')

    <div class="main">
      @include('mypartials.navbar')

      <main class="content">
        @yield('content')
      </main>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row text-muted justify-content-end">
            <span>Proudly powered by <a href="https://github.com/CodingRafi">CodingRafi</a></span>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <form action="" class="form-delete" method="POST">
    @csrf
    @method('delete')
    @stack('other_delete')
  </form>

  <script src="{{ asset('js/app.js') }}"></script>
  @include('mypartials.js')
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/fstdropdown.js') }}"></script>
  <script>
    setFstDropdown();
  </script>
  <script>
    function deleteData(url){
          Swal.fire({
              title: 'Apakah anda yakin ingin hapus data ini?',
              text: "Data yang terhapus tidak dapat dikembalikan",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Hapus',
              cancelButtonText: 'Batal'

          }).then((result) => {
              if (result.isConfirmed) {
                  $('.form-delete').attr('action', url).submit();
              } 
          })
      }
  </script>
  @stack('js')
</body>

</html>