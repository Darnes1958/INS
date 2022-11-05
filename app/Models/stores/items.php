<?php

namespace App\Models\stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'items';
    protected $primaryKey ='item_no';
    public $incrementing = false;
    public $timestamps = false;

    public function iteminstore()
    {

        return $this->hasOne(stores:: class, 'item_no', 'item_no');

    }


}
