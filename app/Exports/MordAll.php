<?php

namespace App\Exports;

use App\Models\bank\bank;
use App\Models\Customers;
use App\Models\jeha\jeha;
use App\Models\jeha\Mordeen_Master_View;
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

class MordAll implements FromCollection,WithMapping, WithHeadings,WithStyles,
    WithEvents,WithColumnWidths,WithColumnFormatting
{
    public $zeroShow;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(string $zeroShow)
    {
        $this->zeroShow = $zeroShow;

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


                $event->sheet->setCellValue('B6', 'كشف بجميع الموردين  ');


                $event->sheet->getDelegate()->setRightToLeft(true);

            },
        ];
    }

    public function columnFormats(): array
    {
        return [


            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

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
     * @var Mordeen_Master_view $main_view
     */
    public function map($main_view): array
    {
        return [
            $main_view->jeha_name,
            $main_view->tot,
            $main_view->TarBuy,

            $main_view->ValImp,
            $main_view->ValExp,
            $main_view->differ,
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
            ['اسم المورد','شراء','مردودات','قبض','دفع','الإجمالي',],
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
        return
            Mordeen_Master_View::
                where('available', 1)
                ->when($this->zeroShow != 'yes', function ($q) {
                    return $q->where('differ', '!=', 0);
                })->get()  ;

    }

}
