<?php

namespace App\Models\bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTajmeehy extends Model
{
    use HasFactory;


  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'BankTajmeehy';
  protected $primaryKey ='TajNo';

  public $timestamps = false;
}
