@extends('PrnView.PrnMaster')

@section('mainrep')



  <div >
    <label style="font-size: 10pt;">{{$bank_name}}</label>
    <label style="font-size: 14pt;margin-right: 12px;" >المصرف : </label>
  </div>


  <table  width="100%"   align="right" >
    <caption style="font-size: 12pt; margin: 8px;">{{'كشف برسائل الإيقاف من تاريخ '.$stop_date1.' من إلي تاريخ  '.$stop_date2 }} </caption>
    <thead style=" font-family: DejaVu Sans, sans-serif; margin-top: 8px;" >
    <tr  style="background: #9dc1d3;" >

      <th style="width: 14%">التاريخ</th>
      <th style="width: 14%">القسط</th>
      <th >الاسم</th>
      <th style="width: 20%">رقم الحساب</th>
      <th style="width: 14%">رقم العقد</th>
      <th style="width: 8%">ت</th>

    </tr>
    </thead>
    <tbody style="margin-bottom: 40px; ">
    @php $i=0 @endphp
    @foreach($res as $key => $item)
      <tr >

        <td style="text-align: center;"> {{ $item->stop_date }} </td>
          <td> {{ $item->kst }} </td>
        <td> {{ $item->name }} </td>
        <td > {{ $item->acc }} </td>
        <td> {{ $item->no }} </td>
        <td style="text-align: center;">{{++$i}}</td>
      </tr>
      <div id="footer" style="height: 50px; width: 100%; margin-bottom: 0px; margin-top: 10px;
                              display: flex;  justify-content: center;">
        <label class="page"></label>
        <label> صفحة رقم </label>
      </div>

    @endforeach
    <tr >
    <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
    <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
    <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
    <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
    <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
    </tr>
    </tbody>

  </table>
  </div>
  </div>


@endsection
