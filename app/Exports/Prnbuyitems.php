<?php

namespace App\Exports;

use App\Models\buy\buy_tran;
use App\Models\Customers;
use App\Models\stores\items;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Prnbuyitems implements  FromCollection,WithMapping, WithEvents,WithColumnWidths,WithColumnFormatting
,WithCustomStartCell
{
    public  $order_no;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $order_no)
    {
        $this->order_no = $order_no;
    }
    public function startCell(): string
    {
        return 'B2';
    }

    public function columnWidths(): array
    {
        return [
            'B' => 50,
            'C' => 20,

        ];
    }
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,



        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
                $event->sheet->getDelegate()->getStyle('C')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            }
        ];

    }
    /**
     * @var items $items
     */
    public function map($items): array
    {
        return [

            $items->item_name,
            $items->price_sell,


        ];
    }
    public function collection()
    {
        return items::whereIn('item_no',buy_tran::where('order_no',$this->order_no)->pluck('item_no'))->get();
    }
}
