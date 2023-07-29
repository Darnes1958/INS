<?php

namespace App\Exports;

use App\Models\bank\BankTajmeehy;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NotThereXls implements FromCollection,WithMapping, WithHeadings,
    WithEvents,WithColumnWidths,WithStyles,WithColumnFormatting
{
  public $bank_no;
  public $TajNo;
  public $TajName;
    /**
     * @return array
     */
    public function __construct(int $bank_no,int $TajNo)
    {
        $this->bank_no = $bank_no;
        $this->TajNo = $TajNo;
    }
    /**
     * @var main $main
     */
    public function map($main): array
    {
        return [
            $main->no,
            $main->acc,
            $main->name,
            $main->sul_date,
            $main->kst,

        ];
    }
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function(AfterSheet $event)  {
                $event->sheet
                    ->getStyle('A8:I8')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('E8E1E1');

                $event->sheet->getDelegate()->getStyle('B')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $event->sheet->getDelegate()->getStyle('D')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->setCellValue('D6', 'كشف بالعقود المدرجة لدينا والغير قائمة بالمصرف بتاريخ '.date('Y-m-d'));


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
            'B' => NumberFormat::FORMAT_NUMBER,

        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 14,
            'B' => 30,
            'C' => 30,
            'D' => 14,
            'E' => 14,


        ];
    }

    public function headings(): array
    {
        $cus=Customers::where('Company',Auth::user()->company)->first();
        return [
            [$cus->CompanyName],
            [$cus->CompanyNameSuffix],
            [' '],
            ['المصرف التجميعي ',BankTajmeehy::where('TajNo',$this->TajNo)->first()->TajName],
            [''],
            [''],
            [''],
            ['رقم العقد','رقم الحساب','الاسم','تاريخ العقد','القسط'],
        ];
    }
    public function collection()
    {

      return  DB::connection(Auth::user()->company)->table("main")->select('*')
        ->when($this->bank_no!=0,function($q){
            return $q->where('bank', '=', $this->bank_no);})
        ->whereNotIn('acc',function($query){
            $query->select('acc')->from('kaema')
                ->whereIn('bank',function ($q){
                    $q->select('bank_no')->from('bank')->where('bank_tajmeeh', $this->TajNo);
                });
        })->get();

    }
}
