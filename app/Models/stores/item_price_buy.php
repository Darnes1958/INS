<?php

namespace App\Models\stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item_price_buy extends Model
{
    use HasFactory;

    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'item_price_buy';
    protected $primaryKey ='rec_no';
    public $timestamps = false;
}
