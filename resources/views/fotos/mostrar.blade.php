@extends('app')

@section('content')

@if(Session::has('editada'))
	<div class="alert alert-success">
		<p>{{ Session::get('editada') }}</p>
	</div>
@endif

@if (Session::has('eliminada'))
	<div class="alert alert-danger">
		<p>{{Session::get('eliminada')}}</p>
	</div>
@endif

<div class="container-fluid">
<p><a href="/validado/fotos/crear-foto?id={{$id}}" class="btn btn-primary" role="button">Crear foto</a></p>
@if(sizeof($fotos) > 0)
	@foreach($fotos as $index => $foto)
		@if($index%3 == 0)
		<div class="row">
		@endif
			<div class="col-sm-6 col-md-3">
				<div class="thumbnail">
					<img src="{{$foto->ruta}}">
					<div class="caption">
						<h3>{{$foto->nombre}}</h3>
						<p>{{$foto->descripcion}}</p>
					</div>
					<p><a href="/validado/fotos/actualizar-foto/{{$foto->id}}" class="btn btn-primary" role="button">Editar foto</a></p>
					<form class="form-horizontal" role="form" method="POST" action="/validado/fotos/eliminar-foto">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" value="{{$foto->id}}">
					<input type="submit" role="submit" class="btn btn-danger" value="Eliminar">
					</form>
				</div>
			</div>
		@if(($index+1)%3 == 0)
		</div>
		@endif
	@endforeach	
@else
	<div class="alert alert-danger">
		<p>Al parecer no tiene fotos. Crea una.</p>
	</div>
@endif
</div>
@endsection
