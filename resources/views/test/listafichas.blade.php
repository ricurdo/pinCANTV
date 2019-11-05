@extends('layouts.app')
@include('header')

<script type="text/javascript" charset="utf-8">
	document.querySelector('#prueba-btn').addEventListener('click', function(){
		alert('texto de test');
	});
</script>

@section('content')

<div class="container">
	<div class="row">
		<form action="#" method="get">
				
			<input type="text" id="prueba" placeholder="Texto aqui">

			<button type="submit" id="prueba-btn">Search</button>

		</form>
	</div>
</div>

@endsection