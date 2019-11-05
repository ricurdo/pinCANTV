<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{

	public $timestamps = false;

	protected $primaryKey = 'id';

	protected $date = 'creation_date';
    protected $fillable = [
        'card_code', 'retailer_id', 'load_batch', 'amount_id','creation_date',
    ];

}
