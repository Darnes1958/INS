<?php

namespace App\Http\Controllers\jeha;

use App\Http\Controllers\Controller;
use App\Models\jeha\jeha;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;


class customercontroller extends Controller
{
  function CustomerAll (Request $request)
  {
      $jeharep = jeha::on(auth()->user()->company)->where('jeha_type',1)->paginate(15);
      if ($request->ajax()) {
          return view('backend.jeha.CustomerPagi', compact('jeharep'));
      } else {
          return view('backend.jeha.customer_all', compact('jeharep'));
      }
  }
    function CustomerAdd (Request $request)
    {
        return view('backend.jeha.customer_add');
    }
    function CustomerStore (Request $request)
    {

       $wid = jeha::on(auth()->user()->company)->max('jeha_no')+1;
        jeha::on(auth()->user()->company)->insert([
            'jeha_no'=>$wid,
            'jeha_name'=>$request->jeha_name,
           'jeha_type'=>1,
           'address'=>$request->address,
           'libyana'=>$request->libyana,
           'mdar'=>$request->mdar,
           'others'=>$request->others,
           'charge_by'=>1,
           'emp'=>auth::user()->empno,
           'available'=>1,

       ]);
        $notification = array(
            'message'=> 'تم تخزين البيانات بنجاح','alert-type'=>'success'
        );
        return redirect()->route('customer.all')->with($notification);
    }
    function CustomerEdit ($id)
    {

      $customer=jeha::on(auth()->user()->company)->findorfail($id);
        return view('backend.jeha.customer_edit',compact('customer'));
    }

    function CustomerUpdate (Request $request)
    {

        $wid = $request->id;
        jeha::on(auth()->user()->company)->findorfail($wid)->update([

            'jeha_name'=>$request->jeha_name,

            'address'=>$request->address,
            'libyana'=>$request->libyana,
            'mdar'=>$request->mdar,
            'others'=>$request->others,

            'emp'=>auth::user()->empno,


        ]);
        $notification = array(
            'message'=> 'تم تحديث البيانات بنجاح','alert-type'=>'success'
        );
        return redirect()->route('customer.all')->with($notification);
    }
    function CustomerDelete ($id)
    {
        Config::set('database.connections.other.database', Auth::user()->company);

        jeha::on(auth()->user()->company)->findorfail($id)->delete();
        $notification = array(
            'message'=> 'تم الغاء البيانات بنجاح','alert-type'=>'success'
        );
        return redirect()->back()->with($notification);
    }



    function SearchCustomerall (Request $request)
    {

        $jeharep = jeha::on(auth()->user()->company)->where('jeha_type',1)
            ->where('Jeha_name', 'like' ,'%'.$request->search_string.'%')
            ->orwhere('address', 'like' ,'%'.$request->search_string.'%')
            ->orwhere('libyana', 'like' ,'%'.$request->search_string.'%')
            ->orwhere('mdar', 'like' ,'%'.$request->search_string.'%')
            ->orwhere('others', 'like' ,'%'.$request->search_string.'%')->paginate(15);

        if ($jeharep->count()>=1) {
            return view('backend.jeha.CustomerPagi', compact('jeharep'))->render();
        } else
            return response()->json([
                'status'=>'Nothing',
            ]);
    }


}
