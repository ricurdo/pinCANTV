<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('title','Pines Pre-Pago')

    <link rel="stylesheet" href="{{URL::asset('css/login/style.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('fontawesome/css/all.css')}}">
</head>

<body class="bg-secondary">
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
                <div class="card-title">
                    <div class="text-center h3 font-weight-bold" style="">Generación y carga de pines</div>
                    <center><img src="img/logov3.PNG" class="mt-4 ml-4" alt="logo" width="170px"></center>
                </div>

                <form action="{{route('login')}}" class="form-signin" method="POST">
                    @csrf

                    <div class="form-label-group">
                        <input type="text" id="user" name="user" class="form-control" placeholder="Usuario" required autofocus> 
                        <label for="user">Usuario</label>
                        <i class="fa fa-user" id="input_img"></i>
                    </div>
                    {{$errors->first('user')}}

                    <div class="form-label-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                        <label for="password">Contraseña</label>
                        <i class="fa fa-lock" id="input_img"></i>
                    </div>
                    {{$errors->first('password')}}

                    
                    
                    <button class="btn btn-lg btn-primary btn-block text-uppercase">Ingresar</button>

                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <!-- Footer -->
  <footer>
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; 2019. Compañía Anónima Teléfonos de Venezuela</p>
    </div>
  </footer>

<!-- Scripts -->
<script src="{{URL::asset('js/jquery-3.3.1.js')}}"></script>
<script src="{{URL::asset('js/bootstrap/bootstrap.bundle.min.js')}}"></script>


</body>
</html>