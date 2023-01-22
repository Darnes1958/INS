@extends('PrnView.PrnMaster')

@section('mainrep')

    <div style="position: fixed; text-align: center;  width: 100%;  margin: 10px;
                              display: flex;  justify-content: center;">
      <label >{{$res->no}}</label>
      <label  style="width: 20%">رقم العقد</label>
    </div>
    <br>

    <div class="float-container">
      <div class="float-child" style="width: 10%;">
        <label  >اســــــم الزبون</label>
      </div>
      <div class="float-child" style=" width: 50%; border-bottom: 1px solid gray; ">
        <label  >{{$res->name}}</label>
      </div>
        <div class="float-child" style="width: 10%;margin-right: 20px;">
            <label  >تاريخ العقد</label>
        </div>
        <div class="float-child" style=" width: 16%; border-bottom: 1px solid gray; text-align: center">
            <label style="text-align: center">{{$res->sul_date}}</label>
        </div>
    </div>
    <div style=" padding: 20px;border: 3px solid #fff;">
        <div style="float: right;
          padding: 2px;width: 14%;">
            <label  >اســـم المصرف</label>
        </div>
        <div  style="float: right;
          padding: 2px; width: 46%; border-bottom: 1px solid gray; ">
            <label  >{{$res->bank_name}}</label>
        </div>
        <div  style="float: right;
          padding: 2px; width: 10%;margin-right: 20px;">
            <label  >رقم الحساب</label>
        </div>
        <div  style="float: right;
          padding: 2px; width: 16%; border-bottom: 1px solid gray; text-align: center">
            <label style="text-align: center">{{$res->acc}}</label>
        </div>
    </div>
    <div  style=" padding: 20px;border: 3px solid #fff;">
        <div  style="float: right;
          padding: 2px;width: 12%; ">
            <label  >إجمالي الفاتورة</label>
        </div>
        <div  style="float: right;
          padding: 2px; width: 16%; border-bottom: 1px solid gray; text-align: center">
            <label style="text-align: center" >{{$res->sul_tot}}</label>
        </div>
      <div  style="float: right;
          padding: 2px;width: 12%; margin-right: 20px;">
        <label  >اجمالي التقسيط</label>
      </div>
      <div  style="float: right;
          padding: 2px; width: 16%; border-bottom: 1px solid gray; text-align: center">
        <label style="text-align: center" >{{$res->sul}}</label>
      </div>
    </div>
    <div class="float-container">
        <div class="float-child" style="width: 12%; ">
            <label  >المسدد</label>
        </div>
        <div class="float-child" style=" width: 16%; border-bottom: 1px solid gray; text-align: center">
            <label style="text-align: center" >{{$res->sul_pay}}</label>
        </div>
        <div class="float-child" style="width: 12%; margin-right: 20px;">
            <label  >المطلوب</label>
        </div>
        <div class="float-child" style=" width: 16%; border-bottom: 1px solid gray; text-align: center">
            <label style="text-align: center" >{{$res->raseed}}</label>
        </div>
    </div>
    <div class="float-container">
        <div class="float-child" style="width: 12%; ">
            <label  >عدد الأقساط</label>
        </div>
        <div class="float-child" style=" width: 16%; border-bottom: 1px solid gray; text-align: center">
            <label style="text-align: center" >{{$res->kst_count}}</label>
        </div>
        <div class="float-child" style="width: 12%; margin-right: 20px;">
            <label  >القسط</label>
        </div>
        <div class="float-child" style=" width: 16%; border-bottom: 1px solid gray; text-align: center">
            <label style="text-align: center" >{{$res->kst}}</label>
        </div>
    </div>
<br>

    <table style="width:  80%; margin-left: 10%;margin-right: 10%;">

        <thead style=" font-family: DejaVu Sans, sans-serif; margin-top: 8px;" >
        <tr  style="background: #9dc1d3;" >
            <th style="width: 32%">طريقة الخصم</th>
            <th style="width: 16%">الخصم</th>
            <th style="width: 20%">تاريخ الخصم</th>
            <th style="width: 20%">تاريخ الاستحقاق</th>
            <th style="width: 12%">ت</th>

        </tr>
        </thead>
        <tbody style="margin-bottom: 40px; ">
        @foreach($res2 as $key => $item)
            <tr>
                <td> {{ $item->ksm_type_name }} </td>
                <td> {{ $item->ksm }} </td>
                <td style="text-align: center"> {{ $item->ksm_date }} </td>
                <td style="text-align: center"> {{ $item->kst_date }} </td>
                <td style="text-align: center"> {{ $item->ser }} </td>
            </tr>
        @endforeach
        </tbody>

    </table>

@endsection







