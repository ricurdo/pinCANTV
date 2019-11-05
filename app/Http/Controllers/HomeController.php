<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Card;
use App\Temp_card;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }


    public function index()
    {
      $fecha = now();
      $mes = $fecha->month;

      $fechas = DB::table('meses')->get();

          foreach ($fechas as $fecha)
          {
              if ($fecha->mes_id==$mes)
              {
                  $month = $fecha->mes;
              }
          }

      $values = $this->ChartCargasActual($mes);
      $valuesP= $this->ChartPinesActual($mes);

      $cant = Card::select('creation_date')->whereMonth('creation_date',$mes)->distinct()->get()->count();

      $cantP = Temp_card::select('created_at')->whereMonth('created_at',$mes)->distinct()->get()->count();

  //-------Cantidades disponibles----------------
      $pines = Temp_card::all()->count();
      $fichas = Card::where('status',1)->count();

          if ($pines<$fichas)
          {
              $warning = true;
          } else {
              $warning = false;
          }
  //---------------------------------------------

  //-------Ultimas fechas de actualizaciones---------
      $valorG = Temp_card::max('created_at');
      $Y = substr($valorG, 0, -6);
      $M = substr($valorG, 5, -3);
      $D = substr($valorG, 8);
      
      $lastUpdateG = $D.'-'.$M.'-'.$Y;

      $valorC = Card::max('creation_date');
      $Y = substr($valorC, 0, -6);
      $M = substr($valorC, 5, -3);
      $D = substr($valorC, 8);
      
      $lastUpdateC = $D.'-'.$M.'-'.$Y;
  //-------------------------------------------------
      // return var_dump($valor);
      return view('principal', compact('month','values','valuesP','cant','cantP','pines','fichas', 'lastUpdateG', 'lastUpdateC', 'warning'));
    }


    public function ChartCargasActual($mes)
    {

      $filter = Card::select('creation_date')->whereMonth('creation_date',$mes)->distinct()->get();

      $cant = Card::select('creation_date')->whereMonth('creation_date',$mes)->distinct()->get()->count();

        if (!$filter->isEmpty()) {

            foreach ($filter as $key)
            {
              $date[] = $key->creation_date;
              $amount[] = Card::where('creation_date', $key->creation_date)->count();
            }

          return [$date, $amount];

        } else {
            $date = 0;
            $amount = 0;
          return [$date, $amount];
        }
    }

    public function ChartPinesActual($mes)
    {

      $filter = Temp_card::select('created_at')->whereMonth('created_at',$mes)->distinct()->get();

      $cant = Temp_card::select('created_at')->whereMonth('created_at',$mes)->distinct()->get()->count();

        if (!$filter->isEmpty()) {

          foreach ($filter as $key)
          {
            $date[] = $key->created_at;
            $amount[] = Temp_card::where('created_at', $key->created_at)->count();
          }
          
          return [$date, $amount];

        } else {
          $date = 0;
          $amount = 0;
          return [$date, $amount];
        }
    }
}
