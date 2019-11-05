<?php

namespace App\Http\Controllers\Pines;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Card;


class CardsController extends Controller
{

//====================================================================================
//=========================== Guardar en tabla "cards" ===============================
//====================================================================================
    public function guardar(Request $request){

    	$cards = new Card();

    	$cards->retailer_id = $request->retailer_id;
    	$cards->order_id = $request->order_id;
    	$cards->creation_date = $request->creation_date;
    	$cards->status = $request->status;
    	$cards->card_amount = $request->vf;

    	$cards->save();

    }


    public function test2(){
        $var = now()->tz('America/La_Paz')->format('d-m-Y H:i:s');
        var_dump($var);
    }

    public function insertar($total, $serial)
    {
        // $fill = new Temp_card();

        // $fill->card_code = $serial[$k];
        // $fill->access_code = $total[$i];
    }


}