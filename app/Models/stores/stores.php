<?php

namespace App\Models\stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stores extends Model
{
    use HasFactory;
    protected $connection = 'other';
    protected $guarded = [];
    protected $table = 'stores';
    protected $primaryKey ='rec_no';

    public $timestamps = false;

    public function storeitems()
    {

        return $this->belongsTo(items:: class, 'item_no', 'item_no');

    }


}
