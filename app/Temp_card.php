<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Temp_card extends Model
{
    use SoftDeletes;

	public $timestamps = false;

	protected $primaryKey = 'id_cards';

    protected $fillable = [
        'card_code', 'access_code',
    ];

    protected $hidden = [
        'access_code',
    ];

}
