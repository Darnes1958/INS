<?php

namespace App\Models\bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class bank extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'bank';
    protected $primaryKey ='bank_no';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'bank_no',
        'bank_name',
        'bank_acc',
        'acc_tajmeeh',
        'bank_tajmeeh',
        'bank_acc_no',
        'bank_code',

    ];
}

