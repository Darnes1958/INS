<?php

namespace App\Models\masr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasCenters extends Model
{
    use HasFactory;

    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'MasCenters';
    protected $primaryKey ='CenterNo';
    public $incrementing = false;
    public $timestamps = false;
}
