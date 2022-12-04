<?php

namespace App\Models\aksat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chk_tasleem extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'chk_tasleem';
    protected $primaryKey ='rec_no';

    public $timestamps = false;
}
