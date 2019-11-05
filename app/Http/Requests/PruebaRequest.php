<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PruebaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'serialI' => 'required|numeric',
            'serialF' => 'required|numeric',
            'load_batch' => 'required|numeric',
            'proveedor' => 'required',
            'vf' => 'required|numeric',
            'total' => 'required|numeric',
            'retailer_id' => 'required|numeric',
            'fechaExp' => 'required',
            'saldoExp' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'num_tarjeta' => 'required|numeric',
            'correlativo' => 'required|numeric|min:1',
        ];
    }
}
