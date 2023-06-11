<?php

namespace App\Imports;

use App\Models\excel\KaemaModel;
use App\Models\excel\MahjozaModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MahjozaModelImport implements ToModel, WithHeadingRow
{
/**
 * @param array $row
 *
 * @return \Illuminate\Database\Eloquent\Model|null
 */
  public function model(array $row)
{

    if (!isset($row['aksat_count']) || !isset($row['name']) || !isset($row['acc'])
        || !isset($row['sal_date'])) {
        return null;
    }

    $rec= MahjozaModel::on(auth()->user()->company)->create(
        [
            'name' => $row['name'],
            'acc' => $row['acc'],
            'aksat_tot' => $row['aksat_tot'],
            'aksat_count' => $row['aksat_count'],
            'sal_date' => Date::excelToDateTimeObject($row['sal_date']),
        ]
    );

    return  $rec;
}//
  public function headingRow(): int
{
    return 7;
}
}
