<?php

namespace App\Models\buy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class charge_by extends Model
{
  use HasFactory;
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'charge_by';
  protected $primaryKey ='no';

  public $timestamps = false;

}
