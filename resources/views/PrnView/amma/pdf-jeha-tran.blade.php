@extends('PrnView.PrnMaster')

@section('mainrep')
  <div  >

    <div style="text-align: center">
      <label style="font-size: 10pt;">{{$tran_date}}</label>
      <label style="font-size: 14pt;margin-right: 12px;" >من تاريخ : </label>
      <label style="font-size: 10pt;">{{$jeha_name}}</label>
      <label style="font-size: 14pt;margin-right: 12px;" >كشف حساب العميل : </label>
    </div>


    <table   >
      <thead style="  margin-top: 8px;">

      <tr style="background:lightgray">
        <th style="width: 20%;">طريقة الدفع</th>
        <th style="width: 12%;">رقم المستند</th>
        <th style="width: 12%;">دائن</th>
        <th style="width: 12%;">مدين</th>
        <th style="width: 12%;">التاريخ</th>
        <th >البيان</th>
      </tr>
      </thead>
      <tbody >
      <tr  >
        <td>  </td>
        <td>  </td>
        <td style="color: red"> {{ number_format($DaenBefore,2, '.', ',') }} </td>
        <td style="color: blue"> {{ number_format($MdenBefore,2, '.', ',') }} </td>
        <td>  رصيد سابق</td>
        <td>  </td>
      </tr>

      @foreach($RepTable as $key=>$item)
        <tr >
          <td> {{ $item->type_name }} </td>
          <td> {{ $item->order_no }} </td>
          <td> {{ $item->daen }} </td>
          <td> {{ $item->mden }} </td>
          <td> {{ $item->order_date }} </td>
          <td> {{ $item->data }} </td>
        </tr>
        <div id="footer" style="height: 50px; width: 100%; margin-bottom: 0px; margin-top: 10px;
                              display: flex;  justify-content: center;">
          <label class="page"></label>
          <label> صفحة رقم </label>
        </div>
      @endforeach

      <tr  >
        <td>  </td>
        <td> {{ number_format($Mden-$Daen,2, '.', ',') }} </td>
        <td style="color: red"> {{ number_format($Daen,2, '.', ',') }} </td>
        <td style="color: blue"> {{ number_format($Mden,2, '.', ',') }} </td>
        <td>  الإجمالي</td>
        <td>  </td>
      </tr>


      </tbody>
    </table>


  </div>



@endsection
