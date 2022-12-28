<?php

namespace App\Http\Controllers\bank;

use App\Http\Controllers\Controller;
use App\Models\bank\bank;
use App\Models\bank\rep_bank;
use App\Models\bank\rep_banks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class BankReportsController extends Controller
{
    function Rep_Bank ($bankno){


        $datatable=rep_bank::on(auth()->user()->company)->where('bank',$bankno)->paginate(15);

        $bankdata=bank::on(auth()->user()->company)->where('bank_no',$bankno)->first();
        $banklist=bank::on(auth()->user()->company)->get();
        return view('backend.bank.rep_bank',
            compact('datatable','bankdata','banklist'))
            ->withtitle($bankdata->bank_name);


    }

    function PagiRepBank ($bankno)
    {

        if ($bankno==0) {
            $datatable=rep_bank::on(auth()->user()->company)->where('bank',0)->paginate(15);
            $banklist=bank::on(auth()->user()->company)->get();
            return view('backend.bank.rep_bank', compact('datatable','banklist'));
        }
        else {
            $datatable = rep_bank::on(auth()->user()->company)->where('bank', $bankno)->paginate(15);
            return view('backend.bank.bankpaginate', compact('datatable'))->render();
        }
    }
    function SearchRepBank (Request $request)
    {

        $datatable = rep_bank::on(auth()->user()->company)->where('bank',$request->bankid)
        ->where('name', 'like' ,'%'.$request->search_string.'%')
        ->orwhere('sul', 'like' ,'%'.$request->search_string.'%') ->paginate(10);

        if ($datatable->count()>=1) {
            return view('backend.bank.bankpaginate', compact('datatable'))->render();
        } else
        return response()->json([
            'status'=>'Nothing',
        ]);
    }

    function Rep_Banks (){


        $datatable=rep_banks::on(auth()->user()->company)->get();

        return view('backend.bank.rep_banks', compact('datatable'));


    }




}
