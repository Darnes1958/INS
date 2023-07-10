<?php

namespace App\Imports;

use App\Models\excel\FromExcelModel;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FromExcelImportS implements  ToModel, WithHeadingRow
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    if ($row['name']==null || $row['name']=='' || !isset($row['ksm']) || !isset($row['name']) || !isset($row['acc'])   ) {
      return null;
    }
    $rec= FromExcelModel::on(auth()->user()->company)->create(
      [
        'name' => $row['name'],
        'acc' => $row['acc'],
        'ksm' => $row['ksm'],
        'ksm_date' => Date::excelToDateTimeObject($row['ksm_date']),
        'bank' => 0,
        'hafitha_tajmeehy' => 0,
        'h_no' => 1,

      ]
    );

    return  $rec;
  }

  public function headingRow(): int
  {
    return 18;
  }
}
