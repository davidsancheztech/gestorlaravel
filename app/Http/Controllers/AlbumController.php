<?php namespace GestorImagenes\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use GestorImagenes\Http\Requests\CrearAlbumRequest;
use GestorImagenes\Http\Requests\ActualizarAlbumRequest;
use GestorImagenes\Http\Requests\EliminarAlbumRequest;
use GestorImagenes\Album;

class AlbumController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */

	public function getIndex()
	{
		$usuario = Auth::user();

		$albumes = $usuario->albumes;

		return view('albumes.mostrar', ['albumes' => $albumes]);
	}

	public function getCrearAlbum()
	{
		return view('albumes.crear-album');
	}

	public function postCrearAlbum(CrearAlbumRequest $request)
	{
		$usuario = Auth::user();

		Album::create
		(
			[
				'nombre' => $request->get('nombre'),
				'descripcion' => $request->get('descripcion'),
				'usuario_id' => $usuario->id,
			]
		);

		return redirect('validado/albumes')->with('creado','El album fue creado correctamente');
	}

	public function getActualizarAlbum($id)
	{
		$album = Album::find($id);

		return view('albumes.actualizar-album', ['album' => $album]);
	}

	public function postActualizarAlbum(ActualizarAlbumRequest $request)
	{
		$album = Album::find($request->get('id'));

		$album->nombre = $request->get('nombre');
		$album->descripcion = $request->get('descripcion');

		$album->save();

		return redirect('validado/albumes')->with('actualizado','El albúm se actualizó');
	}

	public function postEliminarAlbum(EliminarAlbumRequest $request)
	{
		$album = Album::find($request->get('id'));

		//Eliminamos las fotos
		$fotos = $album->fotos;
		foreach($fotos as $foto)
		{
			$imagen = getcwd().$foto->ruta;
			if(file_exists($imagen))
					unlink(realpath($imagen));
		}
		$album->fotos()->delete();
		$album->delete();

		return redirect('/validado/albumes')->with('eliminado','El abum fue eliminado');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}
}
