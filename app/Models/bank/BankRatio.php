<?php

namespace App\Models\bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankRatio extends Model
{
  use HasFactory;


  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'BankRatio';


  public $timestamps = false;

}
