<?php

namespace App\Models\masr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasTypes extends Model
{
    use HasFactory;

    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'MasTypes';
    protected $primaryKey ='MasTypeNo';
    public $incrementing = false;
    public $timestamps = false;
}
