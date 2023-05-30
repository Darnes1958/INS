<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class KlasaBuSellMakXls implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
  public $date1;
  public $date2;
  public function __construct(string $date1,string $date2)
  {
    $this->date1 = $date1  ;
    $this->date2=$date2;


  }
  public function map($SellTableMak): array
  {
    return [
      $SellTableMak->place_name,
      $SellTableMak->type_name,
      $SellTableMak->tot1,
      $SellTableMak->ksm,
      $SellTableMak->tot,
      $SellTableMak->cash,
      $SellTableMak->not_cash,

    ];
  }
  public function collection()
    {
      $SellTableMak=DB::connection(Auth()->user()->company)->table('sells')
        ->join('price_type','sells.price_type','=','price_type.type_no')
        ->join('stores_names','sells.place_no','=','stores_names.st_no')
        ->where('sell_type',1)
        ->whereBetween('order_date',[$this->date1,$this->date2])
        ->selectRaw('stores_names.st_no place_no,st_name as place_name,type_no,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
        ->groupBy('stores_names.st_no','st_name','type_no','type_name')->get();
      return $SellTableMak; //
    }
}
