@extends('layouts.app')


@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="content-wrapper">
	<div class="container-fluid">

	 <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}">Página principal</a>
      </li>
      <li class="breadcrumb-item active">Carga de pines</li>
    </ol>
    <!--/.breadcrumbs-->

	<!--Alert Bootstrap (Proceso listo)-->
	@if (session('alert'))
	    <div class="alert alert-primary alert-dismissible fade show" role="alert">
	        <h4 class="alert-heading">Carga finalizada</h4>

	        <p>Total de pines cargados en el proceso: <strong>{{session('alert')}}</strong></p>
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
	    </div>
	@endif
	<!--/.alert-->

		<div class="py-3">
			<div class="card border-dark w-70 mb-3">
				
					<h3 class="card-header border-dark text-center" style="background-color: rgba(254, 162, 37, 0.8);">Carga de pines</h3><br>

				<div class="card-body">

					<form action="{{route('carga')}}" method="POST">
						@csrf

					  <br>

					<div class="row">
						<div class="card" style="margin-left: 20px">
							
							<div class="card-header">
								<center>
									<p style="font-weight: bold;">Rango de seriales</p>
								</center>
							</div>

							<div class="card-body">
						  	<div class="col">
									<label for="serialI"> Inicio </label>
							    <input type="number" class="form-control" name="serialI" id="serialI" placeholder="Rango de inicio" value="{{$s_inicio}}" readonly>
						  	</div>

						  <br>

						  	<div class="col">
						    	<label for="serialF"> Fin </label>
						    	<input type="number" class="form-control" name="serialF" id="serialF" placeholder="Rango final">
						    </div>
							</div>
						</div>

						<div class="card-body">

					    <div class="col">
					  		<label for="load_batch">Load Batch</label>
					  		<input type="number" class="form-control" name="load_batch" id="load_batch" placeholder="Lote de carga">
					  	</div>

					  <br>

					  	<div class="col">
								<div class="form-group">
								    <label for="exampleFormControlSelect1">Proveedor</label>
								    <select class="form-control" id="exampleFormControlSelect1" name="proveedor">
								      <option selected disabled>Seleccionar...</option>
								      <option id="1">PINVIRTUAL</option>
								    </select>
								</div>
							</div>

							{{-- <div class="row">
								<div class="col">
									<div class="form-group">
									    <label for="bono">¿Bono?</label>
									    <select class="form-control" id="bono" name="bono">
									      <option selected disabled>...</option>
									      <option value="1">Si</option>
									      <option value="2">No</option>
									    </select>
									</div>
								</div>

								<div class="col" id="bono_valor"></div>

							</div> --}}
						<br>
							<div class="row">
								<div class="col">
						    	<label for="vf"> Valor Facial </label>
						    	<input type="number" class="form-control" name="vf" id="vf" placeholder="Valor Facial">
					    	</div>

					    	<div class="col">
					    		<label for="total"> Total </label>
						    	<input type="number" class="form-control" name="total" id="total" placeholder="Valor Total" readonly>
					    	</div>
							</div>

						</div>
					</div>
						<br>

					  <div class="row">

					  	<div class="col">
					  		
					  		<label for="retailer_id"> Retailer ID(Codigo de motivo) </label>
					    	<input type="text" class="form-control" name="retailer_id" id="retailer_id" placeholder="ID">
					  	</div>

					  	<div class="col">
					  		
					  		<label for="fechaExp"> Fecha de Expiración de Tarjeta </label>
					    	<input type="text" class="form-control" name="fechaExp" id="fechaExp" placeholder="Seleccione fecha" value="12 / 31 / 2025" readonly>
					  	</div>

					  	<div class="col">
					  		
					  		<label for="saldoExp"> Periodo de Expiración de Saldo </label>
					    	<input type="text" class="form-control" name="saldoExp" id="saldoExp" placeholder="Periodo de expiración" value="365" readonly>
					  	</div>

					  </div>
						<br>
					  <div class="row">

					  	<div class="col">
					  		<label for="cantidad"> Cantidad de fichas (archivos) </label>
					    	<input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad">
					  	</div>


					  	<div class="col">
					  		<label for="pedido"> Número de tarjetas por ficha </label>
					    	<input type="text" class="form-control" name="num_tarjetas" id="pedido" placeholder="Pedido">
					  	</div>

					  	<div class="col">
					  		<label for="correlativo">Correlativo de inicio para las ficha</label>
					  		<input type="text" class="form-control" name="correlativo" id="correlativo" placeholder="Número de correlativo">
					  	</div>

					  </div>
						<br>
						

					<div class="card-footer" style="background-color: #fff;">
						<div class="text-right">

						<a href="{{route('home')}}" class="btn btn-dark" style="text-transform: uppercase;">Cancelar</a>

						<button type="submit" class="btn btn-outline-primary" style="text-transform: uppercase;">Realizar carga</button>

						</div>
					</div>

					</form>


				</div>
			</div>
		</div>
	</div>

</div>
  <!-- /.content-wrapper -->
<script>

	$(document).on('keyup', '#vf', function (e){

		let vfo = $(this).val();
		let validate = parseInt(vfo);
		let total = document.getElementById("total");
		let vf = document.getElementById("vf");

		//Validación que Valor Facial sea un campo numérico
			if (isNaN(validate))
			{
				alert('ERROR: Debe ingresar solo números');
			  vf.value='';
			  total.value = '';
			  console.log(isNaN(validate));
			} else {
				total.value = validate;
				console.log(isNaN(validate));
			}
	});

	$(document).on('keyup', '#load_batch', function (e){

		let loadB = $(this).val();
		let validate = parseInt(loadB);
		let load = document.getElementById('load_batch')

		//Validación que Load batch sea un campo numérico
			if (isNaN(validate))
			{
				alert('ERROR: Debe ingresar sólo números');
			  load.value='';

			  console.log(isNaN(validate));
			}
		console.log(isNaN(validate));
	});

	$(document).on('keyup', '#retailer_id', function (e){

		let ret = $(this).val();
		let validate = parseInt(ret);
		let retailer = document.getElementById('retailer_id')

		//Validación que Load batch sea un campo numérico
			if (isNaN(validate))
			{
				alert('ERROR: Debe ingresar sólo números');
			  retailer.value='';

			  console.log(isNaN(validate));
			}
		console.log(isNaN(validate));
	});

	$(document).on('keyup', '#cantidad', function (e){

		let can = $(this).val();
		let validate = parseInt(can);
		let cantidad = document.getElementById('cantidad')

		//Validación que Load batch sea un campo numérico
			if (isNaN(validate))
			{
				alert('ERROR: Debe ingresar sólo números');
			  cantidad.value='';

			  console.log(isNaN(validate));
			}
		console.log(isNaN(validate));
	});

	$(document).on('keyup', '#pedido', function (e){

		let nt = $(this).val();
		let validate = parseInt(nt);
		let tarjetas = document.getElementById('pedido')

		//Validación que Load batch sea un campo numérico
			if (isNaN(validate))
			{
				alert('ERROR: Debe ingresar sólo números');
			  tarjetas.value='';

			  console.log(isNaN(validate));
			}
		console.log(isNaN(validate));
	});

	$(document).on('keyup', '#correlativo', function (e){

		let cor = $(this).val();
		let validate = parseInt(cor);
		let correlativo = document.getElementById('correlativo')

		//Validación que Load batch sea un campo numérico
			if (isNaN(validate))
			{
				alert('ERROR: Debe ingresar sólo números');
			  correlativo.value='';

			  console.log(isNaN(validate));
			}
		console.log(isNaN(validate));
	});


</script>

@endsection