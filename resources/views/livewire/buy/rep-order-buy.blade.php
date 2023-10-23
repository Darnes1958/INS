<div x-data class="row" id="printableArea" dir="rtl">

<div  class="col-md-5 my-2"  >

  <div   class="row g-2 " style="border:1px solid lightgray;background: white;">
    <div class="col-md-12" >
      @livewire('buy.buy-select')
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-4">
          <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
        </div>
        <div class="col-md-8">
          <input wire:model="orderno"  wire:keydown.enter="ChkOrderNoAndGo" type="text" class=" form-control "
                 id="order_no" name="order_no"   >
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-4">
          <label for="date" class="form-label-me">التاريخ</label>
        </div>
        <div class="col-md-8">
          <input wire:model="order_date"
                 class="form-control  "  name="date" type="date"  id="date" readonly>
        </div>
      </div>
    </div>

      <div class="col-md-6">
        <div class="row">
          <div class="col-md-4">
            <label  for="jehano" class="form-label-me">رقم الزبون</label>
          </div>
          <div class="col-md-8">
            <input wire:model="jeha_no"
                   class="form-control  "  name="jehano" type="text"  id="jehano" readonly>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-2">
            <label   class="form-label-me" > اسم الزبون</label>
          </div>
          <div class="col-md-10">
            <input wire:model="jeha_name"   type="text" class=" form-control "  id="jeha_name"   readonly >
          </div>
        </div>
      </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-2">
          <label   class="form-label-me ">ملاحظات</label>
        </div>
        <div class="col-md-10">
          <input wire:model="notes"   class="form-control" readonly    type="text"   >
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-2">
          <label   class="form-label-me ">صدرت من </label>
        </div>
        <div class="col-md-10">
          <input wire:model="place_name"   class="form-control" readonly    type="text"   >
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="row">
        <div class="col-md-4">
          <label  class="form-label-me ">إجمالي الفاتورة</label>
        </div>
        <div class="col-md-8">
          <input wire:model="tot1"   type="text" class=" form-control "  readonly >
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-4">
          <label  class="form-label-me ">الخصم</label>
        </div>
        <div class="col-md-8">
          <input wire:model="ksm"   type="text" class=" form-control "  readonly >
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-4">
          <label  class="form-label-me ">الاجمالي النهائي</label>
        </div>
        <div class="col-md-8">
          <input wire:model="tot"   type="text" class=" form-control "  readonly >
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-4">
          <label  class="form-label-me ">المدفوع</label>
        </div>
        <div class="col-md-8">
          <input wire:model="cash"   type="text" class=" form-control "  readonly >
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-2">
      <div class="row">
        <div class="col-md-4">
          <label  class="form-label-me ">الباقي</label>
        </div>
        <div class="col-md-8">
          <input wire:model="not_cash"   type="text" class=" form-control "  readonly >
        </div>
      </div>
    </div>
      <div x-show="$wire.TotCharge>0" class="col-md-6 mb-2">
          <div class="row">
              <div class="col-md-4">
                  <label  class="form-label-me ">تكاليف اصافية</label>
              </div>
              <div class="col-md-8">
                  <input wire:model="TotCharge"   type="text" class=" form-control "  readonly >
              </div>
          </div>
      </div>

      <a  href="{{route('reporderbuypdf',
         ['order_no'=>$orderno,'jeha_name'=>$jeha_name,'place_name'=>$place_name])}}"
         class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>

  <!--  <div class="d-print-none">
      <div class="float-end">
        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
        <a href="#" class="btn btn-primary waves-effect waves-light ms-2">Send</a>
        <a href="#" class="btn btn-primary waves-effect waves-light ms-2">Download</a>
      </div>
    </div>
     <a href="{{URL::to('pdf/reporderpdf')}}" class="btnPrint">الحركة اليومية</a>  -->
   <!--   <a href="{{route('livego')}}" class="link-dark d-inline-flex text-decoration-none rounded">الحركة اليومية</a>
        < <div >
          <input type="button"  id="head-btn"
                 class= " btn btn-outline-success  waves-effect waves-light   "
                 wire:click.prevent="printView"  value="  طباعة  " />

        </div>-->

  </div>



</div>


<div class=" col-md-7" >
  <div class="row">
      <div class=" col-md-12" style="border:1px solid lightgray;background: white;">
          <table class="table-sm table-bordered " width="100%"  id="orderlist" >
              <thead>
              <tr style="background: #9dc1d3">
                  <th width="8%">رقم الصنف</th>
                  <th>اسم الصنف </th>
                  <th width="8%">الكمية</th>
                  @if($has_tar)
                   <th width="8%">ترجيع</th>
                  @endif
                <th width="12%">سعر الشراء</th>
                <th width="12%">سعر التكلفة</th>
                <th width="12%">مجموع الشراء</th>
                <th width="12%">مجموع التكلفة</th>
              </tr>
              </thead>
              <tbody id="addRow" class="addRow">
              @foreach($orderdetail as $key => $item)

                  <tr class="font-size-12">
                      <td style="color: #0c63e4; text-align: center"> {{ $item['item_no'] }} </td>
                      <td > {{ $item['item_name'] }} </td>
                      <td style=" text-align: center"> {{ $item['quant'] }} </td>
                      @if($has_tar)
                        @if($item['tarjeeh']==1)
                          <td  style="padding-top: 2px;padding-bottom: 2px; ">
                              <i class="btn btn-outline-success btn-sm fa fa-check "></i>
                          </td>
                          @else
                            <td></td>
                        @endif
                      @endif
                      <td> {{ $item['price_input'] }} </td>
                      <td> {{ $item['price'] }} </td>
                      <td> {{ number_format($item['sub_tot'], 3, '.', '') }}</td>
                      <td> {{ $item['sub_cost'] }}</td>
                  </tr>
              @endforeach
              </tbody>
              <tbody>
          </table><br>
          {{ $orderdetail->links() }}
      </div>
      <div x-show="$wire.TotCharge>0" class="pt-3 col-md-12 " >
          <table class="table-sm w-75 table-bordered table-striped"   id="chargelist" >
              <caption class="caption-top w-25 mx-auto py-0 text-info">تكاليف اضافية</caption>
              <thead>
              <tr style="background: #9dc1d3;font-size: 9pt;">
                  <th width="35%">البيان</th>
                  <th width="35%">المنفذ</th>
                  <th width="20%">المبلغ</th>
              </tr>
              </thead>
              <tbody id="addRow" class="addRow">
              @foreach($chargedetail as $key => $item)
                  <tr class="font-size-12">
                      <td style="color: #0c63e4; "> {{ $item->type_name }} </td>
                      <td > {{ $item->name }} </td>
                      <td> {{ $item->val }} </td>
                  </tr>
              @endforeach
              </tbody>
              <tbody>
          </table><br>
          {{ $chargedetail->links() }}
      </div>
      @if($has_tar)
          <div class="pt-3 col-md-12 ">
              <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
                  <caption class="caption-top  w-25 mx-auto py-0 text-info">مردودات</caption>
                  <thead class="font-size-12">
                  <tr>
                      <th width="16%">التاريخ</th>
                      <th width="12%">رقم الصنف</th>
                      <th >اسم الصنف</th>
                      <th width="8%">الكمية</th>
                      <th width="12%">السعر</th>
                      <th width="14%">المجموع</th>
                  </tr>
                  </thead>
                  <tbody id="addRow" class="addRow">
                  @php $tot=0; @endphp
                  @foreach($TarList as  $item)
                      <tr class="font-size-12">
                          <td>{{$item->tar_date}}</td>
                          <td>{{$item->item_no}}</td>
                          <td>{{$item->item_name}}</td>
                          <td>{{$item->quant}}</td>
                          <td>{{$item->price_input}}</td>
                          <td>{{$item->sub_tot}}</td>
                      </tr>
                    @php($tot=$tot+$item->sub_tot)
                  @endforeach
                  <tr class="font-size-12">
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="font-weight: bold"> الإجمالي</td>
                      <td style="font-weight: bold">{{  number_format($tot,3, '.', '')}}</td>
                  </tr>
                  </tbody>
              </table>
              {{ $TarList->links() }}
          </div>
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

      Livewire.on('gotonext',postid=>  {
          if (postid=='orderno') {  $("#order_no").focus();$("#order_no").select(); };
      })

      $(document).ready(function()
      {
          $('.btnPrint').printPage();
      });

      $(document).ready(function ()
      {
          $('#Buy_L').select2({
              closeOnSelect: true
          });
          $('#Buy_L').on('change', function (e) {
              var data = $('#Buy_L').select2("val");
          @this.set('orderno', data);
          @this.set('TheOrderListSelected',1);
          });
      });
      window.livewire.on('buy-change-event',()=>{
          $('#Buy_L').select2({
              closeOnSelect: true
          });
      });
      function printableDiv(printableAreaDivId) {
          var printContents = document.getElementById(printableAreaDivId).innerHTML;
          var originalContents = document.body.innerHTML;

          document.body.innerHTML = printContents;

          window.print();

          document.body.innerHTML = originalContents;
      }


  </script>

@endpush
