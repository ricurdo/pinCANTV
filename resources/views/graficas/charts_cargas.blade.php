@extends('layouts.app')

@section('title','Estadísticas')

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
      <li class="breadcrumb-item active">Cargas de pines por fecha</li>
    </ol>
    <!--/.breadcrumbs-->

    	<div align="center">
			<div class="form-group">
				<label for="filtro" style="font-weight: bold;">MOSTRAR POR MES: </label>
				<select name="filtro" id="filtro" class="form-control" style="width: 20%;">
				    <option selected disabled>-</option>
				    <option value="0">Todas las fechas</option>
				    <option value="1">Enero</option>
				    <option value="2">Febrero</option>
				    <option value="3">Marzo</option>
				    <option value="4">Abril</option>
				    <option value="5">Mayo</option>
				    <option value="6">Junio</option>
				    <option value="7">Julio</option>
				    <option value="8">Agosto</option>
				    <option value="9">Septiembre</option>
				    <option value="10">Octubre</option>
				    <option value="11">Noviembre</option>
				    <option value="12">Diciembre</option>
				</select>
			</div>
		</div>
{{--================= Grafica ===================--}}
		<div>
            <canvas id="myChart"></canvas>
        </div>
{{--================= /grafica ===================--}}
	</div>
</div>
<!-- /.content-wrapper -->

<meta name="_token" content="{!! csrf_token() !!}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts_body')
	<script src="{{URL::asset('js/chart/Chart.bundle.js')}}"></script>

<script>
	function updateChar(cant, fechas, cargas, mes)
	{
	    for (var p = 0; p < cant; p++) {
	        myChart.data.labels.pop();

	        myChart.data.datasets.forEach((dataset) => {
	            dataset.data.pop();
	        });
	    }

	    $.each(fechas, function(i, item) {
	        myChart.data.labels.push(fechas[i]);
	    });

	    $.each(cargas, function(i, item) {
	        myChart.data.datasets.forEach((dataset) => {
	            dataset.data.push(cargas[i]);
	        });
	    });

	    if (mes==0)
	    {
	    	myChart.options.title.text = 'Carga de pines por fecha: Todas las cargas';
	    } else {

	    	myChart.options.title.text = 'Carga de pines del mes de '+mes;
	    }

	    myChart.update();
	}

	function errorAlert()
	{
		return alert('No hay datos en el mes seleccionado');
	}

	//Filtro de meses

	$(document).on('change', '#filtro', function (e){
	    let filtro = $(this).val();

	    //======Sección para arreglar el URL======
	    let url = $(location).attr('href');
	    let a = url.indexOf("fichas");
	    let b = '';

	        if (filtro == 0) {
	            b = url.slice(0,a) + '/allDates';
	        } else {
	        	b = url.slice(0,a) + '/dateChange';
	        }
	    //=========================================

	         $.ajax({
	          type: "POST",
	          url: b,
	          data: {filtro:filtro},
	          dataType: 'json',
	          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	          success: function (data,filter,cantidad,cargas) {
	             console.log('Mes: '+filtro);
	             console.log(data.filter);
	             console.log(data.cargas);
	                updateChar(data.cantidad, data.filter, data.cargas, data.mes);
	          },
	          error: function (data,filter,cantidad,cargas) {
	            console.log('Error');
	            console.log(data);
	            	errorAlert();
              }

	      });
	});
	//----------Fin filtro------------



	//Grafica impresa
	var ctx = document.getElementById('myChart').getContext('2d');

	let contenido = {
	    type: 'line',
	    data: {
	        //Eje X
	        labels: [@foreach($date as $fecha)
	                    '{{$fecha}}',
	                 @endforeach],

	        datasets: [{
	            //Eje Y
	            label: ['Cargas de pines'],
	            data: [@foreach($amount as $cantidad)
	                    '{{$cantidad}}',
	                   @endforeach],

	            lineTension: 0.3,

	            backgroundColor: "rgba(2,117,216,0.2)",
	            borderColor: "rgba(2,117,216,1)",
	            borderWidth: 2,
	            pointBackgroundColor: "rgba(2,117,216,1)"

	        }]
	    },
	    options: {

	        legend: false,
	        responsive: true,
	        title: {
	            display: true,
	            text: 'Carga de pines por fecha: Todas las cargas'
	        },

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

	var myChart = new Chart(ctx, contenido);
	//-----------Fin Grafica--------

</script>


@endsection
