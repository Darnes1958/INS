<?php

namespace App\Models\others;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class price_type extends Model
{
  use HasFactory;
  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'price_type';
  protected $primaryKey ='type_no';
  public $incrementing = false;
  public $timestamps = false;
}
