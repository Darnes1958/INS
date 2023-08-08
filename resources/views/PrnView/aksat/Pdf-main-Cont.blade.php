@extends('PrnView.PrnCont')

@section('mainrep')
<div style="text-align: left;">
    <label style="padding-left: 4px;" > {{$res->no}} </label>
    <label > رقم العقد </label>
</div>
<div style="text-align: center;font-size: 16pt;">
    <label  > عقد بيع لأجل </label>
</div>
<div style="text-align: center;font-size: 16pt;">
    <label  > {{$cus->CompanyName}} </label>
</div>
<div style="text-align: right;font-size: 16pt;color: #bf800c">
    <label  > أولا بيانات تعبأ من قبل المحل </label>
</div>

<div  style="text-align: right;font-size: 12pt;padding: 4pt;">
    <label  style="display:inline-block;">نرجو منكم إستقطاع الأقساط الشهرية المترتبة علي</label>
    <label id="mainlabel" style="width: 300px;">{{$res->bank_name}}</label>
    <label  style="display:inline-block;">الإخوة مصرف / </label>
</div>
<div style="text-align: right;font-size: 12pt;padding: 4pt;">
    <label  style="display:inline-block;">لصالح هذه الشركة علماً بان القيمة الإجمالية المترتبة علي هذه</label>
    <label  id="mainlabel" style="width: 300px;">{{$res->name}}</label>
    <label  style="display:inline-block;">الأخ / </label>
</div>
<div style="text-align: right;font-size: 12pt;padding: 4pt;">
    <label  id="mainlabel" style="width: 200px;">{{$mindate}}</label>
    <label  style="display:inline-block;">دينار ليبي علي أن يبدا الإستقطاع من شهر </label>
    <label  id="mainlabel" style="width: 200px;">{{$res->sul}}</label>
    <label  style="display:inline-block;">الأقساط</label>
</div>

@endsection







