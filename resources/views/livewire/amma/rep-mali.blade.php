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
  </div>
  <div class="row gy-1 my-1" style="border:1px solid black;background: lightgray; " >
    <div class="col-md-1 my-1 mx-1" style="border:1px solid blue ;background: white; ">
     <div class="text-center">
      <label class="form-label" style="color: #bf800c">مشتريات</label>
     </div>
     <div class="text-center">
      <label class="form-label" >{{number_format($buys, 0, '.', ',')}}</label>
     </div>
    </div>
    <div class="col-md-3 my-1 mx-1"  >
     <div class="row">
       <div class="col-md-12 text-center" style="border:1px solid blue ;background: white; ">
         <label class="form-check-label" style="color: #bf800c" >مبيعات</label>
         <label class="form-check-label" >{{number_format($sells, 0, '.', ',')}}</label>
       </div>
       <div class="col-md-6" style="border-left:1px solid blue ;border-right:1px solid blue ;background: white; ">
         <label class="form-check-label"style="color: #bf800c" >نقدية</label>
         <label class="form-check-label" >{{number_format($sellnakdy, 0, '.', ',')}}</label>
       </div>
       <div class="col-md-6" style="border-left:1px solid blue ;background: white; ">
         <label class="form-check-label" style="color: #bf800c" >مدفوع</label>
         <label class="form-check-label" >{{number_format($sellcash, 0, '.', ',')}}</label>
       </div>
       <div class="col-md-6" style="border: 1px solid blue ;background: white; ">
         <label class="form-check-label" style="color: #bf800c" >بالتقسيط</label>
         <label class="form-check-label" >{{number_format($selltak, 0, '.', ',')}}</label>
       </div>
       <div class="col-md-6" style="border:1px solid blue ;border-right: 1px none ;background: white; ">
         <label class="form-check-label" style="color: #bf800c" >أجل</label>
         <label class="form-check-label" >{{number_format($sellnotcash, 0, '.', ',')}}</label>
       </div>
     </div>
    </div>

    <div class="col-md-1 my-1 mr-1" style="border:1px solid blue ; background: white; ">
      <div class="text-center">
        <label class="form-label" style="color: #bf800c">خزينة</label>
      </div>
      <div class="text-center">
        <label class="form-label" >{{number_format($trans, 0, '.', ',')}}</label>
      </div>
    </div>
    <div class="col-md-1 my-1 " >
      <div class="row" style="border:1px solid blue ;border-bottom: none;border-right: none ;background: white; ">
         <div class="col-md-12" >
          <label class="form-check-label" style="color: #bf800c">دفع</label>
          <label class="form-check-label" >{{number_format($transexp, 0, '.', ',')}}</label>
         </div>
        <div class="col-md-12" style="border-top:1px solid blue ; background: white;">
          <label class="form-check-label"style="color: #bf800c" >قبض</label>
          <label class="form-check-label" >{{number_format($transimp, 0, '.', ',')}}</label>
        </div>
        <div class="col-md-12" style="border:1px solid blue ;border-right: none; ;border-left: none; background: white;">
          <label class="form-check-label" style="color: #bf800c">أقساط</label>
          <label class="form-check-label" >{{number_format($aksat, 0, '.', ',')}}</label>
        </div>
      </div>
    </div>

    <div class="col-md-1 my-1 mx-1" style="border:1px solid blue ;background: white; ">
      <div >
        <div class="text-center">
          <label class="form-check-label" style="color: #bf800c">عقود</label>
        </div>
        <div class="text-center">
          <label class="form-check-label" >{{number_format($okod, 0, '.', ',')}}</label>
        </div>
      </div>
      <div >
        <div class="text-center">
          <label class="form-check-label" style="color: #bf800c">أقساط</label>
        </div>
        <div class="text-center">
          <label class="form-check-label" >{{number_format($aksat, 0, '.', ',')}}</label>
        </div>
      </div>
    </div>
    <div class="col-md-1 my-1 mx-1" style="border:1px solid blue ;background: white; ">
      <div >
        <div class="text-center">
          <label class="form-check-label" style="color: #bf800c">فائض</label>
        </div>
        <div class="text-center">
          <label class="form-check-label" >{{number_format($over, 0, '.', ',')}}</label>
        </div>
      </div>
      <div >
        <div class="text-center">
          <label class="form-check-label" style="color: #bf800c">نرجيع</label>
        </div>
        <div class="text-center">
          <label class="form-check-label" >{{number_format($tar, 0, '.', ',')}}</label>
        </div>
      </div>
    </div>
    <div class="col-md-1 my-1 mx-1" style="border:1px solid blue ;background: white; ">
      <div >
        <div class="text-center">
          <label class="form-check-label" style="color: #bf800c">بالخطا</label>
        </div>
        <div class="text-center">
          <label class="form-check-label" >{{number_format($wrong, 0, '.', ',')}}</label>
        </div>
      </div>
      <div >
        <div class="text-center">
          <label class="form-check-label" style="color: #bf800c">ترجيع</label>
        </div>
        <div class="text-center">
          <label class="form-check-label" >{{number_format($wrongtar, 0, '.', ',')}}</label>
        </div>
      </div>
    </div>
      <div class="col-md-1 my-1 " >
          <div class="row" style="border:1px solid blue ;border-bottom: none;background: white; ">
              <div class="col-md-12" >
                  <label class="form-check-label font-size-12" style="color: #bf800c">مصروفات</label>
                  <label class="form-check-label" >{{number_format($masrofat, 0, '.', ',')}}</label>
              </div>
              <div class="col-md-12" style="border-top:1px solid blue ; background: white;">
                  <label class="form-check-label"style="color: #bf800c" >مرتبات</label>
                  <label class="form-check-label" >{{number_format($mortbat, 0, '.', ',')}}</label>
              </div>


          </div>
      </div>
    <div class="col-md-1 my-1 mx-1" style="border:1px solid blue ;background: white; ">
      <div >
        <div class="text-center">
          <label class="form-check-label" style="color: #bf800c">المصروفات</label>
        </div>
        <div class="text-center">
          <label class="form-check-label" >{{number_format($masrofat+$mortbat, 0, '.', ',')}}</label>
        </div>
      </div>
      <div >
        <div class="text-center">
          <label class="form-check-label" style="color: #bf800c">هامش الربح</label>
        </div>
        <div class="text-center">
          <label class="form-check-label" >{{number_format($rebh, 0, '.', ',')}}</label>
        </div>
      </div>
    </div>

  </div>


  <div x-data class="row">

    <div class="col-md-12">
      <table class="table table-sm table-bordered table-striped table-light " width="100%" style="border:1px solid #bf800c"  >

        <tr>
          <td rowspan="2" style="width: 10%;"></td>
          <th colspan="5" scope="colgroup" style="text-align: center;">المبيعات</th>
          <th colspan="6" scope="colgroup" style="text-align: center;">العقود</th>
          <th rowspan="2" scope="colgroup" style="width: 6%;text-align: center;">مصروفات ومرتبات</th>
          <th rowspan="2" scope="colgroup" style="width: 6%;text-align: center;">الربح النقدي</th>
          <th rowspan="2" scope="colgroup" style="width: 6%;text-align: center;">الربح تقسيط</th>
          <th rowspan="2" scope="colgroup" style="width: 6%;text-align: center;">الإجمالي</th>
          <th rowspan="2" scope="colgroup" style="width: 6%;text-align: center;">صافي الربح</th>
        </tr>
        <tr>
          <th scope="col" style="width: 6%;">مبيعات</th>
          <th scope="col" style="width: 6%;">نقدي</th>
          <th scope="col" style="width: 6%;">تقسيط</th>
          <th scope="col" style="width: 5%;">مدفوع</th>
          <th scope="col" style="width: 6%;">أجل</th>
          <th scope="col" style="width: 6%;">عقود</th>
          <th scope="col" style="width: 6%;">مسدد</th>
          <th scope="col" style="width: 6%;">مطلوب</th>
          <th scope="col" style="width: 6%;">أقساط</th>
          <th scope="col" style="width: 5%;">فائض</th>
          <th scope="col" style="width: 5%;">مرجع</th>
        </tr>
        @if ($RepTable )
          @foreach($RepTable as $key=>$item)
            <tr class="font-size-12">
              <td > {{ $item->Place_name }} </td>
              <td> {{number_format($item->tot, 0, '.', ',')}}</td>
              <td> {{number_format($item->Nakdy, 0, '.', ',')}}</td>
              <td> {{number_format($item->Tak, 0, '.', ',')}}</td>
              <td> {{number_format($item->cash, 0, '.', ',')}}</td>
              <td> {{number_format($item->NotCash, 0, '.', ',')}} </td>
              <td >{{number_format($item->sul, 0, '.', ',')}}  </td>
              <td> {{number_format($item->sul_pay, 0, '.', ',')}}</td>
              <td> {{number_format($item->raseed, 0, '.', ',')}} </td>
              <td> {{number_format($item->ksm, 0, '.', ',')}}</td>
              <td> {{number_format($item->overKst, 0, '.', ',')}}</td>
              <td> {{number_format($item->tarKst, 0, '.', ',')}} </td>
              <td >{{number_format($item->Masr, 0, '.', ',')}} </td>
              <td> {{number_format($item->Rebh_Nakdy, 0, '.', ',')}}</td>
              <td> {{number_format($item->Rebh_Takseet, 0, '.', ',')}}</td>
              <td> {{number_format($item->Rebh, 0, '.', ',')}}</td>
              <td> {{number_format($item->Safi, 0, '.', ',')}} </td>
            </tr>
            @endforeach
            @endif

      </table>

      @if ($RepTable )
        {{ $RepTable->links() }}
      @endif




    </div>


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
