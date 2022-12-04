<?php

namespace App\Models\OverTar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tar_kst extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'tar_kst';
    protected $primaryKey ='wrec_no';

    public $timestamps = false;
}
