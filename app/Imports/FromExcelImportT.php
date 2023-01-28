<?php

namespace App\Imports;

use App\Models\excel\FromExcelModel;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FromExcelImportT implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row['ksm']) || !isset($row['name']) || !isset($row['acc'])
            || !isset($row['ksm_date'])) {
            return null;
        }
        return new FromExcelModel([
            'ksm' => $row['ksm'],
            'name' => $row['name'],
            'acc' => $row['acc'],
            'ksm_date' => Date::excelToDateTimeObject($row['ksm_date']),
            'bank' => 0,
            'hafitha_tajmeehy' => 0,
            'h_no' => 1,
        ]);
    }
    public function headingRow(): int
    {
        return 18;
    }
}
