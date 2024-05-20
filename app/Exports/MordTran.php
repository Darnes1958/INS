<?php

namespace App\Exports;

use App\Models\bank\bank;
use App\Models\Customers;
use App\Models\jeha\jeha;
use App\Models\jeha\MordeenDetailView;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MordTran implements FromCollection,WithMapping, WithHeadings,WithStyles,
    WithEvents,WithColumnWidths,WithColumnFormatting
{
    public $jeha_no;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(int $jeha)
    {
        $this->jeha_no = $jeha;

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
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->setCellValue('B6', 'كشف حساب بتاريخ  '.date('Y-m-d'));


                $event->sheet->getDelegate()->setRightToLeft(true);

            },
        ];
    }

    public function columnFormats(): array
    {
        return [

            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 16,
            'C' => 14,
            'D' => 14,
            'E' => 14,
            'F' => 14,
        ];
    }
    /**
     * @var MordeenDetailView $main_view
     */
    public function map($main_view): array
    {
        return [
            $main_view->wtype,
            $main_view->order_date,
            $main_view->order_no,

            $main_view->tot,
            $main_view->cash,
            $main_view->not_cash,
        ];
    }
    public function headings(): array
    {
        $cus=Customers::where('Company',Auth::user()->company)->first();
        return [
            [$cus->CompanyName],
            [$cus->CompanyNameSuffix],
            [' '],
            ['اسم المورد : '.jeha::find($this->jeha_no)->jeha_name],
            [''],
            [''],
            [''],
            ['البيان','التاريخ','رقم المعاملة','الاجمالي','المدفوع','الأجل',],
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
    public function collection()
    {
        return  DB::connection(Auth()->user()->company)->table('MordeenDetailView')
        ->where('jeha',$this->jeha_no)
        ->orderBy('order_date')
        ->get();
    }

}
