<?php

namespace App\Models\aksat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kst_type extends Model
{
    use HasFactory;
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'kst_type';
  protected $primaryKey ='kst_type_no';
  public $incrementing = false;
  public $timestamps = false;
}
