<?php

namespace App\Models\stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class halls_names extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'halls_names';
    protected $primaryKey ='hall_no';
    public $incrementing = false;
    public $timestamps = false;

}
