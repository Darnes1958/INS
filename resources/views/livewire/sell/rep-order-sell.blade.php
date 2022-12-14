<div class="row">
<div x-data class="col-md-5 my-2"  >

  <div   class="row g-2 " style="border:1px solid lightgray;background: white;">
    <div class="col-md-12" >
      @livewire('sell.sell-select')
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-4">
          <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
        </div>
        <div class="col-md-8">
          <input wire:model="order_no"  wire:keydown.enter="ChkOrderNoAndGo" type="text" class=" form-control "
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
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-2">
          <label   class="form-label-me ">ظريقة الدفع </label>
        </div>
        <div class="col-md-10">
          <input wire:model="type_name"   class="form-control" readonly    type="text"   >
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
  </div>
</div>


<div class=" col-md-7" style="border:1px solid lightgray;background: white;">
    <table class="table-sm table-bordered " width="100%"  id="orderlist" >
      <thead>
      <tr style="background: #9dc1d3">
        <th width="15%">رقم الصنف</th>
        <th>اسم الصنف </th>
        <th width="10%">الكمية</th>
        <th width="15%">السعر </th>
        <th width="18%">المجموع</th>

      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($orderdetail as $key => $item)

        <tr class="font-size-12">
          <td style="color: #0c63e4; text-align: center"> {{ $item['item_no'] }} </td>
          <td > {{ $item['item_name'] }} </td>
          <td style=" text-align: center"> {{ $item['quant'] }} </td>
          <td> {{ $item['price'] }} </td>
          <td> {{ $item['sub_tot'] }}</td>
        </tr>
      @endforeach
      </tbody>
      <tbody>
    </table><br>
  {{ $orderdetail->links() }}



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

  <script type="text/javascript">


      Livewire.on('gotonext',postid=>  {
          if (postid=='orderno') {  $("#order_no").focus();$("#order_no").select(); };


      })

  </script>
  <script>

      $(document).ready(function ()
      {
          $('#Sell_L').select2({
              closeOnSelect: true
          });
          $('#Sell_L').on('change', function (e) {
              var data = $('#Sell_L').select2("val");
          @this.set('order_no', data);
          @this.set('TheOrderListSelected',1);
          });
      });
      window.livewire.on('sell-change-event',()=>{
          $('#Sell_L').select2({
              closeOnSelect: true
          });
      });


  </script>

@endpush
