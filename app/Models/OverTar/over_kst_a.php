<?php

namespace App\Models\OverTar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class over_kst_a extends Model
{
  use HasFactory;
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'over_kst_a';
  protected $primaryKey ='wrec_no';

  public $timestamps = false;
}
