<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   

    <title>SPP</title>
  </head>
  <body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light" style="border-bottom: 1px solid white">
            <div class="container-fluid mt-1 mb-1">
              <a class="navbar-brand" href="#">
                <img src="{{ asset('img/gotap.png') }}" alt="logo" style="width: 7rem;">
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                  <a class="nav-link active" aria-current="page" href="#" style="color: #005c4e;">Home</a>
                  <a class="nav-link" href="#" style="color: #005c4e;">Dashboard</a>
                  <a class="nav-link" href="#" style="color: #005c4e;">Jadwal</a>
                  <a class="nav-link" href="#" style="color: #005c4e;">Kontak</a>
                  <form action="{{ route('login') }}"><button class="btn btn-light text-right" style="font-weight: 500;">Login</button></form>
                </div>
              </div>
            </div>
        </nav>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>