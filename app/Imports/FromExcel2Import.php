<?php

namespace App\Imports;

use App\Models\excel\FromExcel2Model;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FromExcel2Import implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

      if ( !isset($row['exname']) || !isset($row['oldacc'])
           || !isset($row['newacc']) || !isset($row['exkst'])) {
            return null;}
        $rec= FromExcel2Model::on(auth()->user()->company)->create(
          [

            'EXname' => $row['exname'],
            'OldAcc' => $row['oldacc'],
            'NewAcc' => $row['newacc'],
            'EXkst' => $row['exkst'],
          ]
        );

        return  $rec;
    }
  public function headingRow(): int
  {
    return 18;
  }
}
