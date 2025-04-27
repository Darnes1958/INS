<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\halls;
use App\Models\stores\item_type;
use App\Models\stores\items;
use App\Models\stores\place_view;
use App\Models\stores\RepMakzoon;
use App\Models\stores\stores;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class JaradHead extends Component
{
  public $place_no;
  public $place_type;
  public $place_name;
  public $item_type;
    public $place_nameL;
    public $item_typeL;
  public $JarRaseed;
  public $item_no,$item_name,$raseed;
  public $NotZero=false;


  public function ChkItem(){
      if (!$this->place_no) { $this->dispatchBrowserEvent('mmsg', 'يجب اختيار مكان التخزين');return  false;}
      if (!$this->item_type) { $this->dispatchBrowserEvent('mmsg', 'يجب اختيار التصنيف');return  false;}
      if (!$this->item_no) return;

      if ($this->item_no){
          if (!$this->item_type) $this->item_type=items::find($this->item_no)->item_type;
          $res=RepMakzoon::where('place_type',$this->place_type)
              ->where('place_no',$this->place_no)
              ->when($this->item_type,function ($q){
               $q->where('item_type',$this->item_type);
              })
              ->where('item_no',$this->item_no)
              ->first();

          if ($res){
              $this->item_no=$res->item_no;
              $this->item_name=$res->item_name;
              $this->raseed=$res->raseed;
              $this->JarRaseed=$res->place_ras;
              $this->emit('gotonext','JarRaseed');
          }
      }
  }
  public function updated($field){

    if ($field=='place_nameL'){

        $this->place_name=$this->place_nameL;
      $res=place_view::where('place_name',$this->place_name)->first();
      if ($res){
        $this->place_no=$res->place_no;
        $this->place_type=$res->place_type-1;

      }
    }
    if ($field=='item_typeL'){

        $this->item_type=$this->item_typeL;
      $res=RepMakzoon::where('place_type',$this->place_type)
       ->where('place_no',$this->place_no)
       ->where('item_type',$this->item_type)
        ->orderby('item_no')
        ->first();
      if ($res){
        $this->item_no=$res->item_no;
        $this->item_name=$res->item_name;
        $this->raseed=$res->raseed;
        $this->JarRaseed=$res->place_ras;
        $this->emit('gotonext','JarRaseed');
      }
    }

  }

  public function SaveRas(){

    if ($this->JarRaseed>=0){
        $temp_place_type=$this->place_type;
        $temp_place_no=$this->place_no;
        $temp_item_no=$this->item_no;
        $temp_item_type=$this->item_type;


       if ($this->place_type==0)
       stores::where('st_no',$this->place_no)
            ->where('item_no',$this->item_no)
            ->update(['raseed'=>$this->JarRaseed,]);
       else
           halls::where('hall_no',$this->place_no)
               ->where('item_no',$this->item_no)
               ->update(['raseed'=>$this->JarRaseed,]);

      $sum1=stores::where('item_no',$this->item_no)->sum('raseed');
      $sum2=halls::where('item_no',$this->item_no)->sum('raseed');
      items::where('item_no',$this->item_no)
          ->update(['raseed'=>$sum1+$sum2,]);
        $this->place_type=$temp_place_type;
        $this->place_no=$temp_place_no;
        $this->item_no=$temp_item_no;
        $this->item_type=$temp_item_type;
      $res=RepMakzoon::where('place_type',$this->place_type)
          ->where('place_no',$this->place_no)
          ->where('item_type',$this->item_type)
          ->where('item_no','>',$this->item_no)
          ->orderby('item_no')
          ->first();

        if ($res){
            $this->item_no=$res->item_no;
            $this->item_name=$res->item_name;
            $this->raseed=$res->raseed;
            $this->JarRaseed=$res->place_ras;

        }


    }
  }
  public function render()
    {

        return view('livewire.stores.jarad-head',[
          'places'=>place_view::all(),
          'item_types'=>item_type::all(),

          'RepMak'=>RepMakzoon::where('place_type',$this->place_type)
            ->where('place_no',$this->place_no)
            ->where('item_type',$this->item_type)
            ->when($this->NotZero,function ($q){
                  $q->where('raseed','!=',0);
              })
              ->orderby('item_no')
              ->get(),
          'RepMak2'=>RepMakzoon::when($this->item_no!=null,function ($q){$q->where('item_no',$this->item_no);})
              ->when($this->item_no==null,function ($q){$q->where('item_no',null);})
              ->get(),

        ]);
    }
}
