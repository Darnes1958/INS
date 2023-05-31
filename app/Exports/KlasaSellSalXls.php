<?php

namespace App\Exports;

use App\Models\Customers;
use App\Models\sell\sells;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KlasaSellSalXls implements FromCollection, WithHeadings, WithEvents,WithColumnWidths,WithColumnFormatting, WithTitle,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
  public $date1;
  public $date2;
  public $tot1;
  public $ksm;
  public $tot;
  public $cash;
  public $not_cash;
  public $rowcount;
  public function __construct(string $date1,string $date2)
  {
    $this->date1 = $date1  ;
    $this->date2=$date2;


  }
  public function map($SellTableSAl): array
  {
    return [
      $SellTableSAl->place_name,
      $SellTableSAl->type_name,
      $SellTableSAl->tot1,
      $SellTableSAl->ksm,
      $SellTableSAl->tot,
      $SellTableSAl->cash,
      $SellTableSAl->not_cash,

    ];
  }
  public function headings(): array
  {
    $cus=Customers::where('Company',Auth::user()->company)->first();
    return [
      [$cus->CompanyName],
      [$cus->CompanyNameSuffix],
      [' '],
      [''],
      [''],
      [''],
      [''],
      ['المخزن','طريقة الدفع','الإجمالي','الخصم','المطلوب','المدفوع','الباقي'],
    ];
  }
  public function columnWidths(): array
  {
    return [
      'A' => 30,
      'B' => 20,
      'C' => 16,
      'D' => 16,
      'E' => 16,
      'F' => 16,
      'G' => 16,

    ];
  }
  public function registerEvents(): array
  {
    return [

      AfterSheet::class => function(AfterSheet $event)  {
        $event->sheet
          ->getStyle('A8:G8')
          ->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()
          ->setARGB('E8E1E1');

        $event->sheet->setCellValue('C6', 'خلاصة مبيعات الصالات من  '.$this->date1.' إلي '.$this->date2);
        $event->sheet->getDelegate()->setRightToLeft(true);
        $event->sheet->setCellValue('B'.$this->rowcount+9, 'الإجمالـــــــــي');
        $event->sheet->setCellValue('C'.$this->rowcount+9, $this->tot1);
        $event->sheet->setCellValue('D'.$this->rowcount+9, $this->ksm);
        $event->sheet->setCellValue('E'.$this->rowcount+9, $this->tot);
        $event->sheet->setCellValue('F'.$this->rowcount+9, $this->cash);
        $event->sheet->setCellValue('G'.$this->rowcount+9, $this->not_cash);
        $event->sheet->getDelegate()->setRightToLeft(true);
        $event->sheet
          ->getStyle('A'.($this->rowcount+9).':G'.$this->rowcount+9)
          ->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()
          ->setARGB('E8E1E1');
        $event->sheet->getDelegate()->setRightToLeft(true);

      },
    ];
  }
  public function columnFormats(): array
  {
    return [
      'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

    ];
  }
  public function styles(Worksheet $sheet)
  {

    return [

      'A1'  => ['font' => ['size' => 18]],
      'A2'  => ['font' => ['size' => 16]],
      'C6'  => ['font' => ['bold' => true]],
      'B'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'C'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'D'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'E'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'F'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'G'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'C'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
      'D'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
      'E'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
      'F'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
      'G'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],


    ];


  }
  public function title(): string
  {
    return 'مبيعات الصالات ' ;
  }
    public function collection()
    {
      $SellTableSal=DB::connection(Auth()->user()->company)->table('sells')
      ->join('price_type','sells.price_type','=','price_type.type_no')
      ->join('halls_names','sells.place_no','=','halls_names.hall_no')
      ->where('sell_type',2)
      ->whereBetween('order_date',[$this->date1,$this->date2])
      ->selectRaw('hall_name as place_name,type_name,
                                     sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
      ->groupBy('halls_names.hall_no','hall_name','type_no','type_name')
      ->orderBy('hall_no')->get();
      $tot=sells::
      whereBetween('order_date',[$this->date1,$this->date2])
        ->where('sell_type',2)
        ->selectRaw('sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
        ->first();

      $this->rowcount=$SellTableSal->count();
      $this->tot1=$tot->tot1;

      $this->ksm=$tot->ksm;
      $this->tot=$tot->tot;
      $this->cash=$tot->cash;
      $this->not_cash=$tot->not_cash;
      return $SellTableSal;
    }
}
