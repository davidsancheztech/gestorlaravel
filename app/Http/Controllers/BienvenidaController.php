<?php namespace GestorImagenes\Http\Controllers;

class BienvenidaController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function getIndex()
	{
		return view('bienvenida');
	}

}
