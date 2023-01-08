<?php

namespace App\Models\masr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasTypeDetails extends Model
{
    use HasFactory;

    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'MasTypeDetails';
    protected $primaryKey ='DetailNo';
    public $incrementing = false;
    public $timestamps = false;
}
