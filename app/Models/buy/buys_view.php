<?php

namespace App\Models\buy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buys_view extends Model
{
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'buys_view';
  protected $primaryKey =null;
  public $incrementing = false;
  public $timestamps = false;
}
