<?php

namespace App\Http\Controllers\Pines;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Temp_card;
use DB;

class PinsController extends Controller
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

//====================================================================================
//==================== Formulario principal para crear pines =========================
//====================================================================================
    public function view()
    {
        $del_total = Temp_card::all()->count();
            
    	return view('form.pin', compact('del_total'));
    }

//====================================================================================
//========================= GENERACION COMPLETA DE PINES =============================
//====================================================================================
    public function test()
    {
        $this->deltas(); //Retorna los valores de los delta

        $save_serial = Temp_card::max('card_code')+1;
        // echo $save_serial.'<br><br>';

        $i=0;
        $cant_delta = $this->request->cant_delta;
        $regXdelta = $this->request->regXdelta;
        $max = $cant_delta * $regXdelta;
        $date = now()->format('d-m-Y');

        $name_log = $date . '_generation.log';

        $log_text = 'Cantidad de archivos: '.$cant_delta .
                    ' Cantidad de registros por archivos: '. $regXdelta .
                    ' Total: '. $max;

        $log = fopen('/laragon/www/proyecto/public/files/LOGS/generation_LOGS/'.$name_log, 'a') or die ('No se puede crear el archivo '.$name_log);
        fwrite($log, $log_text);
        fclose($log);
        
            while ($i < $max)
            {
                $cadena = $this->cadena(); //Se genera la primera parte de la cadena de numeros aleatorios
                $cadena2 = $this->cadena2($cadena); //Completa la cantidad de digitos necesarios a la cadena

                    $serial[$i] = $save_serial + $i;
                    $total[$i] = $cadena . $cadena2;

                        $exist1 = Temp_card::where('access_code', $total[$i])->exists();
                            if ($exist1 == true)
                            {
                                while ($exist1 == true)
                                {
                                    $total[$i] = $total[$i]+1;
                                    $exist1 = Temp_card::where('access_code', $total[$i])->exists();
                                }
                            }

                            // $var=response()->json([

                            //     'card_code' => $serial[$i],
                            //     'access_code' => $total[$i]

                            // ]);

                            // // var_dump($var);

                            // foreach ($var as $v) {
                            //     echo $v->card_code;
                            // }

                        $fill = new Temp_card();
                        $fill->card_code = $serial[$i];
                        $fill->access_code = $total[$i];
                        $fill->created_at = $date;
                        $fill->save();

                    $todo[$i] = $serial[$i].','.$total[$i];
                    $i++;
            }

            

	            $i=1;
	            $j=0;
            while ($i<=$cant_delta)
            {
            	$name[$i] = 'PINS_'. $i .'.txt';
            	$file = fopen('/laragon/www/proyecto/public/files/pines/'.$name[$i], 'a') or die ('No se puede crear el archivo '.$name[$i]);
            	// echo $name[$i].'<br>';
	            	while ($j<$regXdelta)
		            {
		            	// echo $todo[$j].'<br>';

		            	if ($j==$regXdelta-1) {
		            		fwrite($file, $todo[$j]);
		            	} else {
							fwrite($file, $todo[$j].PHP_EOL);
						}

		            	$j++;
		            }
	            $regXdelta = $regXdelta + $this->request->regXdelta;
	            $i++;
            }
				fclose($file);

            

		return redirect()->route('generar')->with('alert',$max);
    }

//====================================================================================
//========= Genera numeros aleatorios 'delta' para la creacion de pines ==============
//====================================================================================
    public function deltas()
    {
        $cant_delta = $this->request->cant_delta;
        $regXdelta = $this->request->regXdelta;

        $i = 1;
        $fin = $cant_delta;
        $cant = $regXdelta;
        $num = 1;
        $k=0;

            while ($i <= $fin)      //Bucle para generar los deltas
            {
                $deli = 'delta_' . $i;       //Para seleccionar tabla en BD

                    while ($num <= $cant)   //Generacion de numero aleatorio
                    {
                        $random_delta[$k] = rand(1, 99999999999); //Se almacena en un arreglo

                        #Se verifica si se repite el valor del delta generado
                        $exist = DB::table($deli)->where('num', $random_delta[$k])->exists();

                            if ($exist == true)
                            {
                                while ($exist == true)
                                {
                                    $random_delta[$k] = rand(1, 99999999999);
                                    $exist = DB::table($deli)->where('num', $random_delta[$k])->exists();
                                }
                            }

                        #Se guarda el num en tabla $deli
                        DB::table($deli)->insert(['num'=>$random_delta[$k]]);
                        $num++;
                        $k++;
                    }

                $num = 1;
                $i++;
            }

        return $random_delta;
    }

//====================================================================================
//====================== Primera parte del codigo secreto ============================
//====================================================================================

    public function cadena()
    {
        $delta_temp = $this->request->cant_delta;
        $delta1 = rand(1, $delta_temp);
        $delta2 = rand(1, $delta_temp);
        $delta3 = rand(1, $delta_temp);

            while ($delta1==$delta2 || $delta2==$delta3 || $delta1==$delta3)
            {
                if ($delta1==$delta2 || $delta2==$delta3)
                {
                    $delta2 = rand(1, $delta_temp);

                } elseif ($delta3==$delta1) {

                    $delta3 = rand(1, $delta_temp);

                } 

            }

        $delta1 = 'delta_' . $delta1;
        $delta2 = 'delta_' . $delta2;
        $delta3 = 'delta_' . $delta3;

//Esta seccion es para randomizar la cadena de numeros
        $val = rand(1, $this->request->regXdelta)-1;

        $num1= DB::table($delta1)->select('num')->skip($val)->take(1)->get();
            foreach ($num1 as $num) { //Foreach para almacenar el valor del campo 'num'
                $num1=$num->num;
            }

        
        $num2= DB::table($delta2)->select('num')->skip($val)->take(1)->get();
            foreach ($num2 as $num) { //Foreach para almacenar el valor del campo 'num'
                $num2=$num->num;
            }


        $num3= DB::table($delta3)->select('num')->skip($val)->take(1)->get();
            foreach ($num3 as $num) { //Foreach para almacenar el valor del campo 'num'
                $num3=$num->num;
            }
                
                if (strlen($num1)<=4 && strlen($num2)<=4 && strlen($num3)<=4) {

                    $cadena = $num1 * $num2 * $num3;
                    
                    } elseif ((strlen($num1)<=4||strlen($num2)<=4)&&(strlen($num3)>4)) {

                        $cadena = $num1 * $num2 + $num3;

                        } elseif ((strlen($num1)<=4||strlen($num3)<=4)&&(strlen($num2)>4)) {

                            $cadena = $num1 * $num3 + $num2;

                            } elseif ((strlen($num2)<=4||strlen($num3)<=4)&&(strlen($num1)>4)) {

                                $cadena = $num3 * $num2 + $num1;
                                } else {
                                    $cadena = $num1 + $num2 + $num3;
                                }

            $mult = rand(1, 999);
            $cadena = $cadena * $mult;
            return $cadena;
    }

//====================================================================================
//====================== Segunda parte del codigo secreto ============================
//====================================================================================
    public function cadena2($cadena)
    {
        if (strlen($cadena) < 16)
        {
            $length=16-strlen($cadena);

            $valu = 10;
            $c=1;
                while ($c < $length)
                {
                    $valu = $valu * 10;
                    $c++;
                }

                $val_max = $valu-1;

                    if ($length==1)
                    {
                        $val_min = 1;
                    }
                    else
                    {
                        $f = 2;
                        for ($f=2; $f < 16; $f++)
                        { 
                            if ($length==$f)
                            {
                                $val_min = 10;
                                $h = 2;

                                while ($h < $length)
                                {
                                    $val_min = $val_min * 10;
                                    $h++;
                                }
                            }
                        }
                    }

                $cadena2 = rand($val_min, $val_max);
                return $cadena2;

        } else {
            echo 'EL NUMERO ES MAYOR A 16 DIGITOS';
            return false;
        }
    }


//=============================================================================
//%#$&#&#%&#$&$#&#$&%#$&$#&#$&#$&$#&$#&$#&#$&#$&|||||||||||||||||||||||||||||||
//$#"$#"$#"%#"%#"%"#     TEST FUNCTIONS 		|||||||||||||||||||||||||||||||
//%#$&#&#%&#$&$#&#$&%#$&$#&#$&#$&$#&$#&$#&#$&#$&|||||||||||||||||||||||||||||||
//=============================================================================

    public function test2()
    {
        $var = new Temp_card();
        $var = $var->all();

        foreach ($var as $ver) {
            echo $ver->access_code.'<br>';
        }
    }

}
