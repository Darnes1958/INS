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

class JehaTran implements FromCollection,WithMapping, WithHeadings,WithStyles,
    WithEvents,WithColumnWidths,WithColumnFormatting
{
    public $jeha_no;
    public $date1;
    public $jeha_name;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(int $jeha,string $date1)
    {
        $this->jeha_no = $jeha;
        $this->date1=$date1;
        $this->jeha_name=jeha::find($this->jeha_no)->jeha_name;
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

                $event->sheet->setCellValue('B6', 'كشف حساب العميل  '.$this->jeha_name.' من تاريخ '.$this->date1);


                $event->sheet->getDelegate()->setRightToLeft(true);

            },
        ];
    }

    public function columnFormats(): array
    {
        return [

            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,


        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 16,
            'C' => 14,
            'D' => 14,
            'E' => 14,
            'F' => 14,
            'G' => 80,
        ];
    }

    public function map($main_view): array
    {
        return [
            $main_view->data,
            $main_view->order_date,


            $main_view->mden,
            $main_view->daen,
            $main_view->order_no,
            $main_view->type_name,
            $main_view->notes,
        ];
    }
    public function headings(): array
    {
        $cus=Customers::where('Company',Auth::user()->company)->first();
        return [
            [$cus->CompanyName],
            [$cus->CompanyNameSuffix],
            [' '],
            ['اسم الزبون : '.jeha::find($this->jeha_no)->jeha_name],
            [''],
            [''],
            [''],
            ['البيان','التاريخ','مدين','دائن','رقم المستند','طريقة الدفع','ملاحظات'],
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

      return  collect(
          DB::connection(Auth()->user()->company)->
              select('Select * from dbo.frep_jeha_tran (?) as result where order_date>=? order by order_date,order_no '
            ,array($this->jeha_no,$this->date1)
          )
      );
    }

}
