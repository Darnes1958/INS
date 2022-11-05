<?php

namespace App\Models\trans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'trans';
    protected $primaryKey ='tran_no';
    public $incrementing = false;
    public $timestamps = false;

}
