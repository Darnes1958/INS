@extends('PrnView.PrnMasterOneAll')

@section('mainrep')
  @foreach($res as $key => $item)
    <div>
      <label style="font-size: 20pt; margin-right: 12px;margin-bottom: 0;margin-top: 0;padding: 0;" >{{$comp_name}}</label>
    </div>
    <div >
      <label style="font-size: 16pt; margin-right: 12px;margin-bottom: 0;margin-top: 0;padding: 0;">{{$cus->CompanyNameSuffix}}</label>
    </div>
    <br>

  <div style="display:flex; flex-direction: row; justify-content:
     center; align-items: center; margin-right: 80px; font-size: 16pt;">
    <label> {{$bank_name}}</label>
    <label >السادة المحترومون / </label>
  </div>

  <label style="margin-right: 80px; font-size: 16pt;">تحية طيبة </label>
  <br>
  <br>
  <div style="display:flex; flex-direction: row; justify-content:
     center; align-items: center; margin-right: 80px; font-size: 14pt;">
    <label style="font-weight: bold;font-family: DejaVu Sans, sans-serif;
           font-size: 11pt;"> {{$item->name}}</label>
    <label >نأمل منكم إيقاف خصم الأقساط من حساب السيد / </label>
  </div>
  <div style="display:flex; flex-direction: row; justify-content:
     center; align-items: center; margin-right: 80px; font-size: 14pt;">
    <label style="font-weight: bold;font-family: DejaVu Sans, sans-serif;
           font-size: 11pt;"> {{$item->acc}}</label>
    <label >حساب جاري رقم  </label>
  </div>
  <div style="display:flex; flex-direction: row; justify-content:
     center; align-items: center; margin-right: 80px; font-size: 14pt;">
    <label style="font-weight: bold;font-family: DejaVu Sans, sans-serif;
           font-size: 11pt;"> {{$item->kst}}</label>
    <label >وقيمة القسط  </label>
  </div>
  <div style="display:flex; flex-direction: row; justify-content:
     center; align-items: center; margin-right: 80px; font-size: 14pt;">
    <label style="font-weight: bold;font-family: DejaVu Sans, sans-serif;
           font-size: 11pt;"> {{$TajAcc}}</label>
    <label >لحساب الشركة التجميعي رقم   </label>
  </div>
  <label style="margin-right: 80px; font-size: 14pt;">مع رفع الحجز إن وجد  </label>
  <br><br>
  <label style="margin-right: 100px; font-size: 14pt;">نشكركم علي حسن تعاونكم  </label>
  <br><br>
  <div style="text-align: center;font-size: 14pt;">
    والسلام عليكم ورحمة الله وبركاته
  </div>

  <br>
  <br><br>
  <div style="text-align: left; margin-left: 100px; font-size: 14pt;">التوقيع ...................  </div>
  <div style="text-align: left; margin-left: 100px;font-size: 14pt;">مدير الشركة  </div>
  <div class="page-break"></div>
  @endforeach
@endsection

