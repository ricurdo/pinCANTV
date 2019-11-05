<?php

namespace App\Http\Controllers\Charts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Card;
use App\Temp_card;
use Carbon\Carbon;
use DB;

class ChartsController extends Controller
{
	public function index() //No lo uso
	{
		return now();
	}

    public function index_cargas() //Lo que muestra inicialmente mis graficas
    {
    	$fechas = Card::select('creation_date')->distinct()->orderBy('creation_date','asc')->get();

	    $cant = Card::select('creation_date')->distinct()->get()->count();

	    if (!$fechas->isEmpty()) {

            foreach ($fechas as $key)
            {
              $date[] = $key->creation_date;
              $amount[] = Card::where('creation_date', $key->creation_date)->count();
            }

          return view('graficas.charts_cargas', compact('date','amount','cant'));

        } else {
            $date = 0;
            $amount = 0;
          return view('graficas.charts_cargas', compact('date','amount','cant'));
        }

	    //     foreach ($fechas as $fecha) {

	    //   		$date[] = $fecha->creation_date;
	    //   		$amount[] = Card::where('creation_date', $fecha->creation_date)->count();
	    //     }

	    // return view('graficas.charts_cargas', compact('date','amount','cant'));
    }

    public function allDates()//Para cargas, todos los meses
    {	
    	$filtro = Card::select('creation_date')->distinct()->orderBy('creation_date','asc')->get();

	    $cantidad = Card::select('creation_date')->distinct()->get()->count();

		    foreach ($filtro as $key) {
		    	$filter[] = $key->creation_date;
		        $amount[] = Card::where('creation_date', $key->creation_date)->count();
		    }

		$mes = 0;

	    return response()->json([ 'filter' => $filter, 'cantidad' => $cantidad, 'cargas' => $amount, 'mes' => $mes]);
    }

    public function dateChange(Request $request)//Filtrado de los meses CARGAS
    {
    	$month = $request->filtro;

	    if ($month)
	    {
		    $filtro = Card::select('creation_date')->whereMonth('creation_date',$month)->distinct()->get();

		    $cantidad = Card::select('creation_date')->whereMonth('creation_date',$month)->distinct()->get()->count();

		        foreach ($filtro as $key)
		        {
		        	$filter[] = $key->creation_date;
		            $amount[] = Card::where('creation_date', $key->creation_date)->count();
		        }

        	$cont = Card::select('creation_date')->distinct()->get()->count();

	    	$fechas = DB::table('meses')->get();
            foreach ($fechas as $fecha)
            {
                if ($fecha->mes_id==$month)
                {
                  $mes = $fecha->mes;
                }
            }

    		return response()->json([ 'filter' => $filter, 'cantidad' => $cont, 'cargas' => $amount, 'mes' => $mes]);

	    }else{

	        return 'sup';
	    }
	}
//-------------FIN CHARTS CARGAS DE PINES----------------
	public function index_creacion()
	{
		$fechas = Temp_card::select('created_at')->distinct()->orderBy('created_at','asc')->get();

	    $cant = Temp_card::select('created_at')->distinct()->get()->count();


        foreach ($fechas as $fecha) {

      	  $date[] = $fecha->created_at;
      	  $amount[] = Temp_card::where('created_at', $fecha->created_at)->count();
        }

	    return view('graficas.charts_creacion', compact('date','amount','cant'));
	}

	public function allDatesPines()
    {	
    	$filtro = Temp_card::select('created_at')->distinct()->orderBy('created_at','asc')->get();

	    $cantidad = Temp_card::select('created_at')->distinct()->get()->count();

		    foreach ($filtro as $key) {
		    	$filter[] = $key->created_at;
		        $amount[] = Temp_card::where('created_at', $key->created_at)->count();
		    }
		    $mes = 0;

	    return response()->json([ 'filter' => $filter, 'cantidad' => $cantidad, 'cargas' => $amount, 'mes' => $mes]);
    }

    public function dateChangePines(Request $request)
    {
    	$month = $request->filtro;

	    if ($month)
	    {
		    $filtro = Temp_card::select('created_at')->whereMonth('created_at',$month)->distinct()->get();

		    $cantidad = Temp_card::select('created_at')->whereMonth('created_at',$month)->distinct()->get()->count();

		        foreach ($filtro as $key)
		        {
		        	$filter[] = $key->created_at;
		            $amount[] = Temp_card::where('created_at', $key->created_at)->count();
		        }

	        $fechas = DB::table('meses')->get();
	            foreach ($fechas as $fecha)
	            {
	                if ($fecha->mes_id==$month)
	                {
	                  $mes = $fecha->mes;
	                }
	            }

        	$cont = Temp_card::select('created_at')->distinct()->get()->count();

    		return response()->json([ 'filter' => $filter, 'cantidad' => $cont, 'cargas' => $amount, 'mes' => $mes]);

	    }else{

	        return 'sup';// return redirect->back();
	    }
	}

}
