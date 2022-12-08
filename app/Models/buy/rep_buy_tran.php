<?php

namespace App\Models\buy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rep_buy_tran extends Model
{
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'rep_buy_tran';
  protected $primaryKey =null;
  public $incrementing = false;
  public $timestamps = false;
}
