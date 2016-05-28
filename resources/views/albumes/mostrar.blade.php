@extends('app')

@section('content')

@if (Session::has('creado') || Session::has('actualizado'))
	<div class="alert alert-success">
		<p>{{Session::get('creado')}}{{Session::get('actualizado')}}</p>
	</div>
@endif

@if (Session::has('eliminado'))
	<div class="alert alert-danger">
		<p>{{Session::get('eliminado')}}</p>
	</div>
@endif

<div class="container-fluid">
<p><a href="/validado/albumes/crear-album" class="btn btn-primary" role="button">Crear Álbum</a></p>
@if(sizeof($albumes) > 0)
	@foreach($albumes as $inxex => $album)
		@if($inxex%3 == 0)
		<div class="row">
		@endif
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
					<div class="caption">
						<h3>{{$album->nombre}}</h3>
						<p>{{$album->descripcion}}</p>
						<p><a href="/validado/fotos?id={{$album->id}}" class="btn btn-primary" role="button">Ver fotos</a></p>
						<p><a href="/validado/albumes/actualizar-album/{{$album->id}}" class="btn btn-primary" role="button">Editar album</a></p>
						<form class="form-horizontal" role="form" method="POST" action="/validado/albumes/eliminar-album">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="id" value="{{$album->id}}">
						<input type="submit" role="submit" class="btn btn-danger" value="Eliminar">
						</form>
					</div>
				</div>
			</div>
		@if(($inxex+1)%3 == 0)
		</div>
		@endif
	@endforeach	
@else
	<div class="alert alert-danger">
		<p>Al parecer no tienes álbumes. Crea uno.</p>
	</div>
@endif
</div>
@endsection
