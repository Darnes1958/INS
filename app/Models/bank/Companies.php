<?php

namespace App\Models\bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Companies extends Model
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $connection = 'other';
  protected $guarded = [];
  protected $table = 'Companies';
  protected $primaryKey ='CompNo';

  public $timestamps = false;
}
