<?php

namespace App\Models\buy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buys extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'buys';
    protected $primaryKey ='order_no';
    public $incrementing = false;
    public $timestamps = false;
    public function orderbuyjeha()
    {
        return $this->belongsTo(jeha::class,'jeha','jeha_no');
    }

}
