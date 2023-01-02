@extends('PrnView.PrnMaster')

@section('mainrep')

    <div style="position: fixed; text-align: center;  width: 100%;  margin: 10px;
                              display: flex;  justify-content: center;">
      <label >{{$res->no}}</label>
      <label  style="width: 20%">رقم العقد</label>
    </div>
    <br><br>

    <div class="float-container">
      <div class="float-child" style="width: 10%;">
        <label  >اســــــم الزبون</label>
      </div>
      <div class="float-child" style=" width: 60%; border-bottom: 1px solid gray; ">
        <label  >{{$res->name}}</label>
      </div>
    </div>
    <div class="float-container">
      <div class="float-child" style="width: 10%;">
        <label  >تاريخ العقد</label>
      </div>
      <div class="float-child" style=" width: 16%; border-bottom: 1px solid gray; text-align: center">
        <label style="text-align: center">{{$res->sul_date}}</label>
      </div>
      <div class="float-child" style="width: 12%; margin-right: 20px;">
        <label  >اجمالي التقسيط</label>
      </div>
      <div class="float-child" style=" width: 16%; border-bottom: 1px solid gray; text-align: center">
        <label style="text-align: center" >{{$res->sul}}</label>
      </div>
      <div class="float-child" style="width: 12%; margin-right: 20px;">
        <label  >إجمالي الفاتورة</label>
      </div>
      <div class="float-child" style=" width: 16%; border-bottom: 1px solid gray; text-align: center">
        <label style="text-align: center" >{{$res->sul_tot}}</label>
      </div>

    </div>


    <br>


    <div class="content">
      <label  style="width: 20%">{{$res->raseed}}</label>
      <label  style="width: 20% ">&nbsp;&nbsp;المطلوب</label>
      <label  style="width: 20%">{{$res->sul_pay}}</label>
      <label  style="width: 20% ">المسدد</label>
    </div>
    <div class="content">
      <label  style="width: 20%">{{$res->kst}}</label>
      <label  style="width: 20% ">&nbsp;&nbsp;القسط</label>
      <label  style="width: 20%">{{$res->kst_count}}</label>
      <label  style="width: 20% ">عدد الأقساط</label>
    </div>
    <div class="content">
      <label  style="width: 20%">{{$res->chk_out}}</label>
      <label  style="width: 20% ">صكوك مرجعة</label>
      <label  style="width: 20%">{{$res->chk_in}}</label>
      <label  style="width: 20% ">صكوك مستلمة</label>
    </div>
    <div class="content">
      <label  style="width: 20%">{{$res->notes}}</label>
      <label style="width: 80%">ملاحظات</label>
    </div>



@endsection




