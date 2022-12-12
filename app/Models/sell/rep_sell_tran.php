<?php

namespace App\Models\sell;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rep_sell_tran extends Model
{
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'rep_sell_tran';
  protected $primaryKey =null;
  public $incrementing = false;
  public $timestamps = false;
}
