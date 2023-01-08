<?php

namespace App\Models\masr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masrofat extends Model
{
    use HasFactory;

    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'Masrofat';
    protected $primaryKey ='MasNo';

    public $timestamps = false;
}
