<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KlasaXls implements WithMultipleSheets
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
  public function map($BuyTable): array
  {
    return [
      $BuyTable->place_name,
      $BuyTable->type_name,
      $BuyTable->tot1,
      $BuyTable->ksm,
      $BuyTable->tot,
      $BuyTable->cash,
      $BuyTable->not_cash,

    ];
  }

  public function sheets(): array
  {

    $sheets = [];


      $sheets[] = new KlasaBuyXls($this->date1, $this->date2);
      $sheets[] = new KlasaSellMakXls($this->date1, $this->date2);
      $sheets[] = new KlasaSellSalXls($this->date1, $this->date2);
      $sheets[] = new KlasaImpXls($this->date1, $this->date2);
      $sheets[] = new KlasaExpXls($this->date1, $this->date2);


    return $sheets;
  }
}
