<?php
namespace App\Exports;

use App\Invoice;
use App\Models\Customers;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;


class MosdadaEx implements FromView, WithMapping
 {
    public $bank;
    public $baky;
    public function __construct(int $bank,int $baky)
    {
        $this->bank = $bank;
        $this->baky = $baky;
    }
    /**
     * @var Customers $Customers
     */
    public function map($Customers): array
    {
        $Cname=$Customers->where('Company',Auth::user()->company)->first()->CompanyName;
        $CSuf=$Customers->where('Company',Auth::user()->company)->first()->CompanyNameSuffix;
        return [
            $Cname,
            $CSuf,

        ];
    }

  public function view(): View
   {

     return view('Exports.Mosdada_View', [
         'RepTable'=>DB::connection(Auth()->user()->company)->table('main_view')
             ->where('bank', '=', $this->bank)
             ->where('raseed','<=',$this->baky)
             ->get(),
         'cus'=>Customers::where('Company',Auth::user()->company)->first(),

         ]);
   }
 }
