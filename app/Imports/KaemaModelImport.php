<?php

namespace App\Imports;

use App\Models\excel\FromExcelModel;

use App\Models\excel\KaemaModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KaemaModelImport implements ToModel, WithHeadingRow
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {

    if (!isset($row['kst']) || !isset($row['name']) || !isset($row['acc'])
      || !isset($row['sul_date'])) {
      return null;
    }

     else
       $rec= KaemaModel::on(auth()->user()->company)->create(
         [
           'name' => $row['name'],
           'acc' => $row['acc'],
           'kst' => $row['kst'],
           'sul_date' => Date::excelToDateTimeObject($row['sul_date']),
           'bankcode' => $row['bankcode'],

         ]
       );

    return  $rec;
  }//
  public function headingRow(): int
  {
    return 4;
  }
}
