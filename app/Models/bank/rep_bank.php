<?php

namespace App\Models\bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rep_bank extends Model
{
    use HasFactory;

    protected $connection = 'other';

    protected $table = 'main_view';
    protected $primaryKey ='bank';
    public $incrementing = false;
    public $timestamps = false;
}
