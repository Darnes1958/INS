<?php

namespace App\Exports;

use App\Models\aksat\kst_deffer_view;
use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DefferXls implements FromCollection,WithMapping, WithHeadings,
  WithEvents,WithColumnWidths,WithColumnFormatting,WithStyles
{
  public $bank;
  public $bank_name;
  public $text;
  public $deffer;
  public $By;
  public $TajNo;
  public function __construct(int $bank,int $deffer,string $By,int $TajNo)
  {
    $this->bank = $bank;
    $this->deffer = $deffer;
    $this->By=$By;
    $this->TajNo=$TajNo;
    if ($this->By=='Taj') {
      $this->bank_name=BankTajmeehy::find($this->TajNo)->TajName;
      $this->text='التجميعي';
    }
    else {
      $this->bank_name = bank::find($this->bank)->bank_name;
      $this->text='المصرف';
    }
  }
  /**
   * @return array
   */
  /**
   * @var kst_deffer_view $kst_deffer_view
   */


  public function map($kst_deffer_view): array
  {
    return [
      $kst_deffer_view->no,
      $kst_deffer_view->acc,
      $kst_deffer_view->name,
      $kst_deffer_view->kst,
      $kst_deffer_view->ksm,
      $kst_deffer_view->ksm_date,

    ];
  }
  public function registerEvents(): array
  {
    return [

      AfterSheet::class => function(AfterSheet $event)  {
        $event->sheet
          ->getStyle('A8:F8')
          ->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()
          ->setARGB('E8E1E1');

        $event->sheet->getDelegate()->getStyle('B')
          ->getAlignment()
          ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $event->sheet->getDelegate()->getStyle('F')
          ->getAlignment()
          ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $event->sheet->setCellValue('B6', 'كشف بالأقساط المخصومة والغير مطابقة لقيمة القسط فالعقد حتي تاريخ  '.date('Y-m-d'));

        $event->sheet->getDelegate()->setRightToLeft(true);

      },
    ];
  }
  public function styles(Worksheet $sheet)
  {
    return [
      8    => ['font' => ['bold' => true]],
      'A1'  => ['font' => ['size' => 20]],
      'A2'  => ['font' => ['size' => 18]],
      'D6'  => ['font' => ['bold' => true]],
      'A4'  => ['font' => ['bold' => true]],
      'B4'  => ['font' => ['bold' => true]],
      'A6'  => ['font' => ['bold' => true]],

    ];
  }
  public function columnFormats(): array
  {
    return [
      'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

    ];
  }
  public function columnWidths(): array
  {
    return [
      'A' => 10,
      'B' => 20,
      'C' => 30,
      'D' => 12,
      'E' => 12,
      'F' => 14,


    ];
  }
  public function headings(): array
  {
    $cus=Customers::where('Company',Auth::user()->company)->first();
    return [
      [$cus->CompanyName],
      [$cus->CompanyNameSuffix],
      [' '],
      [$this->text,$this->bank_name],
      [''],
      [''],
      [''],
      ['رقم العقد','رقم الحساب','الاسم','القسط','الخصم','تاريخ الخصم'],
    ];
  }

    public function collection()
    {



      return kst_deffer_view::
        when($this->By=='Bank',function ($q){
          $q->where('bank', '=', $this->bank);
        })
        ->when($this->By=='Taj',function ($qq){
          $qq->whereIn('bank', function($q){
            $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
        })
        ->where('deffer', '>', $this->deffer)
        ->orderBy('no')
        ->orderBy('ksm_date')
        ->get();

    }
}
