<div>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-3 my-2 d-inline-flex ">
      <label  class="form-label mx-0 text-left " style="width: 30%; ">من تاريخ</label>
      <input wire:model="date1"   class="form-control mr-0 text-center" type="date"  id="date1" style="width: 70%; ">
      @error('date1') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-3 my-2 d-inline-flex ">
      <label  class="form-label  text-right " style="width: 30%; ">إلي تاريخ</label>
      <input wire:model="date2" wire:keydown.enter="Date2Chk" class="form-control mr-0 text-center" type="date"  id="date2" style="width: 70%; ">
      @error('date2') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="col-md-2"> </div>

    <div  class="col-md-2 my-2 ">

      <a  href="{{route('pdfklasa',['date1'=>$date1,'date2'=>$date2])}}"
          class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
    </div>

    <div  class="col-md-2 my-2 ">
     <a  href="{{route('klasaex',['date1'=>$date1,'date2'=>$date2])}}"
        class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fas fa-file-excel"> &nbsp;&nbsp;إكسل&nbsp;&nbsp;</i></a>
    </div>


  </div>

<div>

  <div class="row">
    @if ($BuyTable )
    <div class="col-md-8">
      <table class="table table-sm table-bordered table-striped table-light " style="width:100%"   >
        <caption style="caption-side:top;text-align: right;font-weight: bold;color: blue">مشتريات</caption>
        <thead class="font-size-12">
        <tr>
          <th >المخزن</th>
          <th style="width: 14%;">طريقة الدفع</th>
          <th style="width: 10%;">الإجمالي</th>
          <th style="width: 10%;">الخصم</th>
          <th style="width: 10%;">المطلوب</th>
          <th style="width: 10%;">المدفوع</th>
          <th style="width: 10%;">الباقي</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @php $sumtot1=0;$sumksm=0;$sumtot=0;$sumcash=0;$sumnot_cash=0;
               @endphp

          @foreach($BuyTable as $key=>$item)
            <tr class="font-size-12">
              <td >{{$item->place_name}}  </td>
              <td> {{$item->type_name}}  </td>
              <td> {{number_format($item->tot1, 2, '.', ',')}} </td>
              <td> {{number_format($item->ksm, 2, '.', ',')}} </td>
              <td> {{number_format($item->tot, 2, '.', ',')}} </td>
              <td> {{number_format($item->cash, 2, '.', ',')}} </td>
              <td> {{number_format($item->not_cash, 2, '.', ',')}} </td>
            </tr>
            @php $sumtot1+=$item->tot1;$sumksm+=$item->ksm;$sumtot+=$item->tot;
                 $sumcash+=$item->cash;$sumnot_cash+=$item->not_cash; @endphp
          @endforeach

          <tr class="font-size-12 " style="font-weight: bold">
            <td >الإجمــــــــالي  </td>
            <td>   </td>
            <td> {{number_format($sumtot1, 2, '.', ',')}} </td>
            <td> {{number_format($sumksm, 2, '.', ',')}} </td>
            <td> {{number_format($sumtot, 2, '.', ',')}} </td>
            <td> {{number_format($sumcash, 2, '.', ',')}} </td>
            <td> {{number_format($sumnot_cash, 2, '.', ',')}} </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endif
    <div class="col-md-4">
     @if ($TransTableImp )
      <table class="table table-sm table-bordered table-striped table-light " style="width:100%"   >
        <caption style="caption-side:top;text-align: right;font-weight: bold;color: blue">ايصالات قبض</caption>
        <thead class="font-size-12">
        <tr>
          <th style="width: 30%;">نوع الإيصال</th>
          <th style="width: 30%;">طريقة الدفع</th>
          <th style="width: 20%;">الإجمالي</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @php $sumval=0 @endphp
        @foreach($TransTableImp as $key=>$item)
          <tr class="font-size-12">
            <td >{{$item->who_name}}  </td>
            <td> {{$item->type_name}}  </td>
            <td> {{number_format($item->val, 2, '.', ',')}} </td>
          </tr>
           @php $sumval+=$item->val; @endphp
        @endforeach
        <tr class="font-size-12 " style="font-weight: bold">
          <td >الإجمــــــــالي  </td>
          <td>   </td>
          <td> {{number_format($sumval, 2, '.', ',')}} </td>
        </tr>
        </tbody>
      </table>
    @endif
    </div>
  </div>

</div>
    @if ($SellTableMak )
    <div class="row">
      <div class="col-md-8">
       <table class="table table-sm table-bordered table-striped table-light " style="width:100%"   >
        <caption style="caption-side:top;text-align: right;font-weight: bold;color: blue">مبيعات مخازن</caption>
        <thead class="font-size-12">
        <tr>
          <th >المخزن</th>
          <th style="width: 14%;">طريقة الدفع</th>
          <th style="width: 10%;">الإجمالي</th>
          <th style="width: 10%;">الخصم</th>
          <th style="width: 10%;">المطلوب</th>
          <th style="width: 10%;">المدفوع</th>
          <th style="width: 10%;">الباقي</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @php $sumtot1=0;$sumksm=0;$sumtot=0;$sumcash=0;$sumnot_cash=0;
               $sumtot1_all=0;$sumksm_all=0;$sumtot_all=0;$sumcash_all=0;$sumnot_cash_all=0;
        @endphp
        @foreach($SellTableMak as $key=>$item)
          <tr class="font-size-12">
            <td >{{$item->place_name}}  </td>
            <td> {{$item->type_name}}  </td>
            <td> {{number_format($item->tot1, 2, '.', ',')}} </td>
            <td> {{number_format($item->ksm, 2, '.', ',')}} </td>
            <td> {{number_format($item->tot, 2, '.', ',')}} </td>
            <td> {{number_format($item->cash, 2, '.', ',')}} </td>
            <td> {{number_format($item->not_cash, 2, '.', ',')}} </td>
          </tr>
          @php $sumtot1+=$item->tot1;$sumksm+=$item->ksm;$sumtot+=$item->tot;
                 $sumcash+=$item->cash;$sumnot_cash+=$item->not_cash;
          @endphp
        @endforeach
        @php
            $sumtot1_all+=$sumtot1;$sumksm_all+=$sumksm;$sumtot_all+=$sumtot;
                   $sumcash_all+=$sumcash;$sumnot_cash_all+=$sumnot_cash;
        @endphp
        <tr class="font-size-12 " style="font-weight: bold">
          <td >الإجمــــــــالي  </td>
          <td>   </td>
          <td> {{number_format($sumtot1, 2, '.', ',')}} </td>
          <td> {{number_format($sumksm, 2, '.', ',')}} </td>
          <td> {{number_format($sumtot, 2, '.', ',')}} </td>
          <td> {{number_format($sumcash, 2, '.', ',')}} </td>
          <td> {{number_format($sumnot_cash, 2, '.', ',')}} </td>
        </tr>
      </table>
      </div>
      <div class="col-md-4">
        @if ($TransTableExp )
          <table class="table table-sm table-bordered table-striped table-light " style="width:100%"   >
            <caption style="caption-side:top;text-align: right;font-weight: bold;color: blue">ايصالات دفع</caption>
            <thead class="font-size-12">
            <tr>
              <th style="width: 30%;">نوع الإيصال</th>
              <th style="width: 30%;">طريقة الدفع</th>
              <th style="width: 20%;">الإجمالي</th>
            </tr>
            </thead>
            <tbody id="addRow" class="addRow">
            @php $sumval=0 @endphp
            @foreach($TransTableExp as $key=>$item)
              <tr class="font-size-12">
                <td >{{$item->who_name}}  </td>
                <td> {{$item->type_name}}  </td>
                <td> {{number_format($item->val, 2, '.', ',')}} </td>
              </tr>
              @php $sumval+=$item->val; @endphp
            @endforeach
            <tr class="font-size-12 " style="font-weight: bold">
              <td >الإجمــــــــالي  </td>
              <td>   </td>
              <td> {{number_format($sumval, 2, '.', ',')}} </td>
            </tr>

            </tbody>
          </table>
        @endif
      </div>
    </div>

    @endif

    @if ($SellTableSalat )
    <div class="row">
     <div class="col-md-8">
      <table class="table table-sm table-bordered table-striped table-light " style="width:100%"   >
        <caption style="caption-side:top;text-align: right;font-weight: bold;color: blue">مبيعات صالات</caption>
        <thead class="font-size-12">
        <tr>
          <th >الصالة</th>
          <th style="width: 14%;">طريقة الدفع</th>
          <th style="width: 10%;">الإجمالي</th>
          <th style="width: 10%;">الخصم</th>
          <th style="width: 10%;">المطلوب</th>
          <th style="width: 10%;">المدفوع</th>
          <th style="width: 10%;">الباقي</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @php $sumtot1=0;$sumksm=0;$sumtot=0;$sumcash=0;$sumnot_cash=0; @endphp
        @foreach($SellTableSalat as $key=>$item)
          <tr class="font-size-12">
            <td >{{$item->place_name}}  </td>
            <td> {{$item->type_name}}  </td>
            <td> {{number_format($item->tot1, 2, '.', ',')}} </td>
            <td> {{number_format($item->ksm, 2, '.', ',')}} </td>
            <td> {{number_format($item->tot, 2, '.', ',')}} </td>
            <td> {{number_format($item->cash, 2, '.', ',')}} </td>
            <td> {{number_format($item->not_cash, 2, '.', ',')}} </td>

          </tr>
          @php $sumtot1+=$item->tot1;$sumksm+=$item->ksm;$sumtot+=$item->tot;
                 $sumcash+=$item->cash;$sumnot_cash+=$item->not_cash; @endphp

        @endforeach
        @php
            $sumtot1_all+=$sumtot1;$sumksm_all+=$sumksm;$sumtot_all+=$sumtot;
                   $sumcash_all+=$sumcash;$sumnot_cash_all+=$sumnot_cash;
        @endphp
        <tr class="font-size-12 " style="font-weight: bold">
          <td >الإجمــــــــالي  </td>
          <td>   </td>
          <td> {{number_format($sumtot1, 2, '.', ',')}} </td>
          <td> {{number_format($sumksm, 2, '.', ',')}} </td>
          <td> {{number_format($sumtot, 2, '.', ',')}} </td>
          <td> {{number_format($sumcash, 2, '.', ',')}} </td>
          <td> {{number_format($sumnot_cash, 2, '.', ',')}} </td>
        </tr>
        </tbody>

          <tbody  >
          <tr><td colspan="7"></td></tr>
          <tr class="font-size-12" style="font-weight: bold">
              <td >اجمالي المبيعات  </td>
              <td>   </td>
              <td> {{number_format($sumtot1_all, 2, '.', ',')}} </td>
              <td> {{number_format($sumksm_all, 2, '.', ',')}} </td>
              <td> {{number_format($sumtot_all, 2, '.', ',')}} </td>
              <td> {{number_format($sumcash_all, 2, '.', ',')}} </td>
              <td> {{number_format($sumnot_cash_all, 2, '.', ',')}} </td>
          </tr>
          </tbody>

      </table>
     </div>
    </div>

    @endif




</div>

</div>
@push('scripts')
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>
@endpush
