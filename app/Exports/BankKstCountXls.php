<?php

namespace App\Exports;

use App\Models\aksat\main_kst_count;
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

class BankKstCountXls implements FromCollection,WithMapping, WithHeadings,WithStyles,
    WithEvents,WithColumnWidths,WithColumnFormatting
{
    public $place_name;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(string $place_name)
    {
        $this->place_name = $place_name;

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

                $event->sheet->getDelegate()->getStyle('B')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->setCellValue('B6', 'كشف باعداد الأقساط المحصلة والمتبقية حتي تاريخ  '.date('Y-m-d'));


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

        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 60,
            'B' => 16,
            'C' => 16,
            'D' => 16,
            'E' => 16,
            'F' => 16,
            'G' => 16,
        ];
    }
    /**
     * @var main_kst_count $main_view
     */
    public function map($main_view): array
    {
        return [
            $main_view->bank_name,
            $main_view->WCOUNT,
            $main_view->sumsul,

            $main_view->sumpay,
            $main_view->sumraseed,
            $main_view->kst_count,
            $main_view->kst_count_not,
        ];
    }
    public function headings(): array
    {
        $cus=Customers::where('Company',Auth::user()->company)->first();
        return [
            [$cus->CompanyName],
            [$cus->CompanyNameSuffix],
            [' '],
            ['نقطة البيع : '.$this->place_name],
            [''],
            [''],
            [''],
            ['المصرف','ع.العقود','الإجمالي','المسدد','المتبقي','ع.المخصومة','ع.المتبقية'],
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
        return  main_kst_count::on(Auth()->user()->company)

            ->selectRaw('place_no,place_name,bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed,sum(kst_count) as kst_count,sum(kst_count_not) as kst_count_not ')

            ->where('place_name','=', $this->place_name)
            ->groupBy('place_no','place_name','bank','bank_name')
            ->orderBy('place_no')->get();
    }

}
