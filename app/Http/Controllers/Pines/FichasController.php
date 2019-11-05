<?php

namespace App\Http\Controllers\Pines;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Card;
use App\Temp_card;
use Carbon\Carbon;
use DB;
use App\Http\Requests\PruebaRequest;

class FichasController extends Controller
{

    public function index()
    {
        $s_inicio = Card::max('card_code')+1;
        return view('form.fichas', compact('s_inicio'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'serialI' => 'required',
        //     'serialF' => 'required',
        //     'load_batch' => 'required',
        //     'proveedor' => 'required',
        //     'vf' => 'required',
        //     'retailer_id' => 'required',
        //     'cantidad' => 'required',
        //     'num_tarjetas' => 'required',
        //     'correlativo' => 'required',
        // ]);
        
        $date = now()->format('d-m-Y');

        $rangoi         = $request->serialI;
        $rangof         = $request->serialF;
        $vf             = $request->vf;

        $prov           = $request->proveedor;
        $retid          = $request->retailer_id;
        $fechaExp       = '12312025';
        $saldoExp       = $request->saldoExp;//365;
        $num_tarjetas   = $request->num_tarjetas;
        $cantidad       = $request->cantidad;
        $load_batch     = $request->load_batch;
        $correlativo    = $request->correlativo;
        // $pin            = '1234567890987654';
            $codes = Temp_card::whereBetween('card_code', [$rangoi, $rangof])->get();

            Temp_card::whereBetween('card_code', [$rangoi, $rangof])->delete();

            // $codes2 = $codes->toJson();
            // var_dump($codes2);
                $o = 0;
                foreach ($codes as $code) {
                    $pin = $code->access_code;
                    $pines[$o] = $pin;
                    $o++;
                }

        $valor          = ($rangof-$rangoi+1);
        $valorLote      = $num_tarjetas*$vf;


        $cantTotal      = $num_tarjetas*$cantidad;

        
        $rango_usado = $rangoi;
        $can = $num_tarjetas;

        //-----------------------------------------------------------------------------------
        //===================================================================================
        //-----------------------------------------------------------------------------------
            
            //Sección de validación para agregar ceros a la izquierda de estos valores {
                    $load_batch0 = str_pad($load_batch, 8, '0', STR_PAD_LEFT);

                    $num_tarjetas0 = str_pad($num_tarjetas, 8, '0', STR_PAD_LEFT);

                    $retid0 = str_pad($retid, 8, '0', STR_PAD_LEFT);

                    $rangoi0 = str_pad($rangoi, 16, '0', STR_PAD_LEFT);

                    $valorLote0 = str_pad($valorLote, 12, '0', STR_PAD_LEFT);

                    $vf0 = str_pad($vf, 9, '0', STR_PAD_LEFT);
            //=========================================================================}
                $k=$cantidad;
                $j=1;
                $h=0;
                $limite = $num_tarjetas;
                $o=0;

                while ($k>0)
                {

                    if (strlen($correlativo)==1) {
                        $fname = 'fichas0'.$correlativo.'.txt';
                    } else {
                        $fname = 'fichas'.$correlativo.'.txt';
                    }

                    $file = fopen('/laragon/www/proyecto/public/files/FIC/'.$fname, 'a') or die ('No se puede crear el archivo '.$fname);

                    
                    for ($i=$h; $i < $limite ; $i++)
                    {
                        
                        $serial[$i] = $rangoi;
                        $current = $rangoi++;

                        $serial0[$i] = str_pad($serial[$i], 16, '0', STR_PAD_LEFT);
                        $load_batch0 = str_pad($load_batch, 8, '0', STR_PAD_LEFT);

                        $fichas[$i] = '01' . $load_batch0 . $serial0[$i] . $pines[$o] . '    ' . $saldoExp . $fechaExp . $vf0 . '.0000' . '01010100010101000100' . $retid0;

                            if ($i==$limite-1) {
                                fwrite($file, $fichas[$i]);
                            } else {
                                fwrite($file, $fichas[$i].PHP_EOL);
                            }
                        $o++;

                    }
                        fclose($file);
                        echo 'done';

                        if (strlen($correlativo)==1) {
                            $hfname = 'hfichas0'.$correlativo.'.txt';
                        } else {
                            $hfname = 'hfichas'.$correlativo.'.txt';
                        }

                        $file1 = fopen('/laragon/www/proyecto/public/files/FIC/'.$hfname, 'a') or die ('No se puede crear el archivo '.$hfname);

                    $hfichas[$j]= '01' . $load_batch0 . $rangoi0 . $num_tarjetas0 . $valorLote0 .'.0000' . '2000000000.000020002' . $fechaExp . '1';

                            
                        fwrite($file1, $hfichas[$j]);
                        fclose($file1);
                        echo "<br>done hfichas";


                    $h=$i;
                    $limite = $limite + $num_tarjetas;
                    $load_batch++;
                    $k--;
                    $j++;
                    $correlativo++;

                }


                    $i=0;
                    while ($i<$valor)
                    {
                        $cards = new Card();
                        $cards->retailer_id = $request->retailer_id;
                        
                            $cards->load_batch = $request->load_batch;//Aumentar valor cada lote de $cantidad
                        $cards->amount_id = $request->vf;
                        $cards->status = 1;
                        $cards->status_date = $date;

                            $cards->card_code = $serial[$i];
                            $cards->access_code = $pines[$i];

                        $cards->creation_date = $date;
                        $cards->save();
                        $i++;
                    }

                    
                    return redirect()->route('fichas')->with('alert',$cantTotal);
        // return view('test.listafichas', compact('fichas','hfichas'));

        
    }

    public function test()
    {
        return view('test.listafichas');
    }

    public function destroy()
    {
        DB::table('cards')->delete();
        $button = '<a href="home">Atras</a>';
        return 'it worked! ' . $button;
    }
}
