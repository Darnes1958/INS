<?php

namespace App\Models\aksat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hafitha extends Model
{
    use HasFactory;
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'hafitha';
  protected $primaryKey ='hafitha_no';
  public $incrementing = false;
  public $timestamps = false;
}
