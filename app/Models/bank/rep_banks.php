<?php

namespace App\Models\bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rep_banks extends Model
{
    use HasFactory;
    protected $connection = 'other';

    protected $table = 'rep_banks';
    protected $primaryKey ='bank';
    public $incrementing = false;
    public $timestamps = false;
}
