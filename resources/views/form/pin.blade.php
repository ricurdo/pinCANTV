@extends('layouts.app')

@section('styles')
	<link rel="icon" type="image/png" href="{{URL::asset('img/icons/add.ico')}}"/>
	{{-- <link rel="stylesheet" href="{{URL::asset('css/pace/progressbar_center.css')}}"> --}}
@endsection

@section('title', 'Generación')

@section('scripts_header')
	{{-- <script src="{{URL::asset('js/pace/pace.min.js')}}"></script> --}}
@endsection

@section('content')

<div id="content-wrapper">
	<div class="container-fluid">

	<!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}">Página principal</a>
      </li>
      <li class="breadcrumb-item active">Generar pines</li>
    </ol>
    <!--/.breadcrumbs-->
		
	<!--Alert Bootstrap (Proceso listo)-->
	@if (session('alert'))
	    <div class="alert alert-primary alert-dismissible fade show" role="alert">
	        <h4 class="alert-heading">Generación finalizada</h4>

	        <p>Total de pines generados en el proceso: <strong>{{session('alert')}}</strong></p>
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
	    </div>
	@endif
	<!--/.alert-->

		<center>
			<div class="card border-dark w-50 mb-3">
				<h3 class="card-header border-dark text-center" style="background-color: rgba(254, 162, 37, 0.8);">Generación de pines</h3><br>

				<div class="card-body">

					<p>Total deltas disponibles:<strong> {{$del_total}}</strong></p>

					<form action="{{route('proceso')}}" method="POST">
						@csrf

					  <div class="row">
					    <div class="col">
						    <label for="cant_delta"> Cantidad de archivos </label>
						    <input type="number" class="form-control" name="cant_delta" id="cant_delta" min="3" max="14" placeholder="Ingrese cantidad" required>
					    </div>

					    <div class="col">
					    	<label for="regXdelta"> Cantidad de pines por archivo </label>
					    	<input type="number" class="form-control" name="regXdelta" id="regXdelta" placeholder="Ingrese cantidad" required>
					    </div>
					  </div>

					<br>
					  	<div class="card-footer text-right" style="background-color: #fff;">
					  		<a href="{{route('home')}}" class="btn btn-dark" style="text-transform: uppercase;"> Cancelar </a>
					  		<button type="submit" class="btn btn-outline-primary" style="text-transform: uppercase;">Generar Pines</button>
					  	</div>

					</form>
				</div>
			</div>
		</center>
	</div>
	<!--/.container-fluid-->
</div>
<!-- /.content-wrapper -->
@endsection