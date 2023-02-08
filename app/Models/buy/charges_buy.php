<?php

namespace App\Models\buy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class charges_buy extends Model
{
  use HasFactory;
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'charges_buy';
  protected $primaryKey ='rec_no';

  public $timestamps = false;
}
