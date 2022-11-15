<?php

namespace App\Models\sell;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sells extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'sells';
    protected $primaryKey ='order_no';
    public $incrementing = false;
    public $timestamps = false;
    public function orderselljeha()
    {
        return $this->belongsTo(jeha::class,'jeha','jeha_no');
    }
}
