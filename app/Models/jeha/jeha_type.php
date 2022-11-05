<?php

namespace App\Models\jeha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jeha_type extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'jeha_type';
    protected $primaryKey ='type_no';
    public $incrementing = false;
    public $timestamps = false;

    public function jeha()
    {

        return $this->hasMany(jeha::class, 'jeha_type', 'jeha_type');
    }

}
