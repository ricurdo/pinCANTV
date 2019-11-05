@extends('layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{URL::asset('css/chart/Chart.css')}}">
@endsection

@section('content')

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{route('home')}}">Página principal</a>
        </li>
        <li class="breadcrumb-item active">Home</li>
      </ol>
      <!--/.breadcrumbs-->

      <!--Alerta de cantidades-->
      @if($warning==true)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <h4 class="alert-heading"><strong>Precaución</strong></h4>

          <p>Es necesario generar nuevos pines ya que la cantidad de <strong>pines</strong> actuales es menor a la cantidad de <strong>cargas</strong> disponibles</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <!--/.alert-->

      <div class="row">
        <div class="col w-100">
          <!-- Area Chart Example-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Generación de pines del mes de {{$month}}</div>
            <div class="card-body">
              <canvas id="myChartPines" class="w-100"></canvas>
            </div>
            <div class="card-footer small text-muted">Última actualización: {{$lastUpdateG}}</div>
          </div>
        </div>

        <div class="col w-100">
          <!-- Area Chart Example-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Carga de pines del mes de {{$month}}</div>
            <div class="card-body">
              <canvas id="myChartCargas" class="w-100"></canvas>
            </div>
            <div class="card-footer small text-muted">Última actualización: {{$lastUpdateC}}</div>
          </div>
        </div>
      </div>
      <!--/.row-->

      <div class="row">
        <div class="col" align="center">
          <div class="mb-3">
            <div class="card text-black bg-white o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-database"></i>
                </div>
                <div style="font-weight: bold;">{{$pines}} pines disponibles</div>
              </div>
              <div class="card-footer text-blue clearfix small z-1"></div>
            </div>
          </div>
        </div>

        <div class="col" align="center">
          <div class="mb-3">
            <div class="card text-black bg-white o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-server"></i>
                </div>
                <div style="font-weight: bold;">{{$fichas}} cargas disponibles</div>
              </div>
              <div class="card-footer text-white clearfix small z-1"></div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->

    

  </div>
  <!-- /.content-wrapper -->

@endsection

@section('scripts_body')
  <script src="{{URL::asset('js/chart/Chart.bundle.js')}}"></script>

  <script>

    //Grafica CARGAS PINES
    var ctx = document.getElementById('myChartCargas').getContext('2d');

    let contenido = {
        type: 'line',
        data: {
          //Eje X
          labels: [@for ($i = 0; $i < $cant; $i++)
                      '{{$values[0][$i]}}',
                   @endfor],

          datasets: [{
            label: ['Carga de pines'],
            //Eje Y
            data: [@for ($i = 0; $i < $cant; $i++)
                      '{{$values[1][$i]}}',
                   @endfor],

            lineTension: 0.3,
            backgroundColor: "rgba(252,157,27,0.2)",
            borderColor: "rgba(252,157,27,1)",
            borderWidth: 2,
            pointBackgroundColor: "rgba(252,157,27,1)"

          }]
        },
        options: {

            legend: false,
            // responsive: false,
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: true
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }

    var myChartCargas = new Chart(ctx, contenido);
    //-----------Fin Grafica CARGAS PINES--------

    //Grafica GENERACION PINES
    var ctx = document.getElementById('myChartPines').getContext('2d');

    let contenidop = {
        type: 'line',
        data: {
          //Eje X
          labels: [@for ($i = 0; $i < $cantP; $i++)
                      '{{$valuesP[0][$i]}}',
                   @endfor],

          datasets: [{
            label: ['Generación de pines'],
            //Eje Y
            data: [@for ($i = 0; $i < $cantP; $i++)
                      '{{$valuesP[1][$i]}}',
                   @endfor],

            lineTension: 0.3,
            backgroundColor: "rgba(252,157,27,0.2)",
            borderColor: "rgba(252,157,27,1)",
            borderWidth: 2,
            pointBackgroundColor: "rgba(252,157,27,1)"

          }]
        },
        options: {

            legend: false,
            // responsive: false,
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: true
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }

    var myChartCargas = new Chart(ctx, contenidop);

  </script>

@endsection