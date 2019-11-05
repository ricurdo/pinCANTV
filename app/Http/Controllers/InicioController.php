<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class InicioController extends Controller
{

	public $request;

	public function __construct(Request $request)
	{
        // return $this->middleware('auth');
		// return $this->request = $request; //Lo que se envie con el formulario
	}

    public function inicio()
    {
    	return view('form.login');
    }
//el Hash::make('clave') creo q encripta
    public function LoginVerif(Request $request)
    {
        return 'sup';
        //Verificar datos de login
    //1. Verificar clave
        // $datos = usuarios::where('user', $this->request->user);
        // return $datos;

    }


    /**De esta manera es equivalente a la de abajo, esto es para
        no escribir el atributo y usar directamente el parametro
        del metodo y no es necesario tener un metodo constructor*/

    // public function store(ContactRequest $request)
    // {
    //     return $request->all();
    // }

    // public function test()
    // {
    //     echo '<div class="alert alert-success">
    //         <strong>Listo!</strong> Sesión iniciada
    //           </div>';
    // }

    public function store(Request $request)
    {
        // function test()
        // {
        // echo '<div class="alert alert-success">
        //     <strong>Listo!</strong> Sesión iniciada
        //       </div>';
        // }

        //echo 'Yes';
        return $this->request->all();
    }
}


?>