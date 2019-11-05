<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Pines Pre-Pago')</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  @yield('scripts_header')

  <!-- Estilos -->
  
  <link rel="icon" type="image/png" href="{{URL::asset('img/icons/favicon.ico')}}"/>
  <link rel="stylesheet" type="text/css" href="{{URL::asset('css/main.css')}}">
  <link rel="stylesheet" type="text/css" href="{{URL::asset('css/bootstrap/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{URL::asset('css/plantilla/sb-admin.css')}}">
  <link rel="stylesheet" href="{{URL::asset('fontawesome/css/all.css')}}">

  @yield('styles')

</head>

<body>
  <div id="app">

    <nav class="navbar navbar-expand navbar-dark static-top" style="background-color: #282e33;">
      <div class="container-fluid">

        <!-- Izquierda del Navbar -->
          <a class="navbar-brand mr-1" href="{{route('home')}}">
              <img src="{{URL::asset('img/movilnet_1.png')}}" alt="logo" width="150px" height="50px" align="center">
          </a>

          <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
              <i class="fas fa-bars"></i>
          </button>

          <!-- Navbar Search para dejar a la derecha el boton de usuario-->
          <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></form>

          <!-- Derecha del Navbar -->
          <ul class="navbar-nav ml-auto ml-md-0">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                </li>

              @else

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" style="color: #fff" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user-circle fa-fw"></i> {{ Auth::user()->user }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal" href="#">Cerrar sesión</a>

                </div>
              </li>

            @endguest

          </ul>
      </div>
    </nav>


    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Inicio</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pinesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-microchip"></i>
            <span>Pines electrónicos</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pinesDropdown">
            <h5 class="dropdown-header">PINES:</h5>
            <a class="dropdown-item" href="{{route('generar')}}">Generación de pines</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('fichas')}}">Carga de pines</a>

            {{-- <div class="dropdown-divider"></div>
            <h6 class="dropdown-header" style="text-">Otros links:</h6>
            <a class="dropdown-item" href="#">wait</a> --}}
          </div>
        </li>
        <li class="nav-item dropdown">
          {{-- <a class="nav-link" href="#{{route('charts')}}"> --}}
          <a class="nav-link dropdown-toggle" href="#" id="chartsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Gráficas estadísticas</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="chartsDropdown">
            <h5 class="dropdown-header">GRAFICAS:</h5>
            <a class="dropdown-item" href="{{route('chart_generacion')}}">Pines generados<br>por fecha</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item mt-2" href="{{route('chart_carga')}}">Carga de pines<br>por fecha</a>

            {{-- <div class="dropdown-divider"></div>
            <h6 class="dropdown-header" style="text-">Otros links:</h6>
            <a class="dropdown-item" href="#">wait</a> --}}
          </div>
        </li>
      </ul>
      <!--/Sidebar <ul>-->

            @yield('content')

      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-secondary">
              <h5 class="modal-title" style="color: #fff" id="exampleModalLabel">¿Desea cerrar sesión?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: #fff">&times;</span>
              </button>
            </div>
            <div class="modal-footer">
              <button class="btn btn-outline-dark" style="text-transform: uppercase;" type="button" data-dismiss="modal">Cancelar</button>
              <a class="btn btn-primary" style="text-transform: uppercase;" href="{{ route('logout') }}"
                 onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                  Cerrar sesión
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /Logout .modal-->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; 2019. Compañía Anónima Teléfonos de Venezuela</span>
          </div>
        </div>
      </footer>
      <!--/Footer-->

    </div>

  </div>

<!--===================================================================================-->
    <script src="{{URL::asset('js/jquery-3.3.1.js')}}"></script>
    <script src="{{URL::asset('js/plantilla/sb-admin.js')}}"></script>
    @yield('scripts_body')


</body>

</html>
