<?php

namespace App\Models\excel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FromExcelModel extends Model
{
  use HasFactory;

  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'FromExcel';


  public $timestamps = false;
}
