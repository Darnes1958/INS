<?php

namespace App\Models\buy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class charge_type extends Model
{
  use HasFactory;
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'charge_type';
  protected $primaryKey ='type_no';

  public $timestamps = false;

}
