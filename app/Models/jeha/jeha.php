<?php

namespace App\Models\jeha;

use App\Models\buy\buys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jeha extends Model
{
    use HasFactory;

    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'jeha';
    protected $primaryKey ='jeha_no';
    public $incrementing = false;
    public $timestamps = false;




    public function jehatype()
    {

        return $this->belongsTo(jeha_type:: class, 'jeha_type', 'type_no');

    }
    public function jehaorderbuy()
    {
        return $this->hasOne(buys::class,'jeha','jeha_no');
    }

}
