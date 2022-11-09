<?php

namespace App\Models\aksat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ksm_type extends Model
{
    use HasFactory;
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'ksm_type';
  protected $primaryKey ='ksm_type_no';
  public $incrementing = false;
  public $timestamps = false;
}
