<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AdminController extends Controller
{
  public function ManagerPage (){

    return view('backend.manager');

  }
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    } //End Method

    public function Profile (){
        $id = Auth::user()->id;
        $admindata = User::find($id);
        return view('admin.body.admin_profile_view',compact('admindata'));

    } // end method

    public function EditProfile (){
        $id = Auth::user()->id;
        $editdata = User::find($id);
        return view('admin.body.admin_profile_edit',compact('editdata'));

    } // end method
    public function StoreProfile (Request $request){
        $id = Auth::user()->id;
        $data=User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            //$data['profile_image'] = $filename;
            $data->profile_image = $filename;
        }
        $data->save();

        $notification = array(
            'message'=> 'تم تخزين البيانات بنجاح','alert-type'=>'success'
        );
        return redirect()->route('admin.profile')->with($notification);


    } //end method




}
