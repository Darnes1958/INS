<?php

namespace App\Models\masr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasView extends Model
{
    use HasFactory;

    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'MasView';
    protected $primaryKey =null;
    public $incrementing = false;
    public $timestamps = false;
}
