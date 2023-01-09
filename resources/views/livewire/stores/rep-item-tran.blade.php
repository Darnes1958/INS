
<div  >
  <div class="row">
    <div class="col-md-1">
      <label  for="jehano" class="form-label-me">رقم الصنف</label>
    </div>
    <div class="col-md-2">
      <input wire:model="item_no" wire:keydown.enter="ItemKeyDown"
             class="form-control"  type="number"  id="itemno" autofocus>
      @error('item_no') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-3" >
      @livewire('stores.item-select', ['PlaceSelectType' => 'items'])
    </div>
    
    <div class="col-md-3">
      <input wire:model="tran_date" wire:keydown.enter="DateKeyDown" class="form-control  "   type="date"  id="tran_date">
      @error('tran_date') <span class="error">{{ $message }}</span> @enderror
    </div>
  </div>

  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th style="width: 12%">نوع الفاتورة</th>
      <th style="width: 12%">رقم الفاتورة</th>
      <th style="width: 12%">التاريخ</th>
      <th >اسم العميل</th>
      <th style="width: 10%">الكمية</th>
      <th style="width: 12%">السعر</th>
      <th style="width: 12%">المجموع</th>
      <th style="width: 12%">طريقة الدفع</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($RepTable as $key=> $item)
      <tr class="font-size-12">
        <td> {{ $item->order_type }} </td>
        <td> {{ $item->order_no }} </td>
        <td> {{ $item->order_date }} </td>
        <td> {{ $item->jeha_name }} </td>
        <td> {{ $item->quant }} </td>
        <td> {{ $item->price }} </td>
        <td> {{ $item->sub_tot }} </td>
        <td> {{ $item->type_name }} </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $RepTable->links('custom-pagination-links-view') }}

</div>

@push('scripts')


  <script type="text/javascript">
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
      Livewire.on('gotonext',postid=>  {
          if (postid=='tran_date') {  $("#tran_date").focus();$("#tran_date").select(); };
          if (postid=='item_no') {  $("#itemno").focus(); $("#itemno").select();};
      })
      $(document).ready(function ()
      {
          $('#Item_L').select2({
              closeOnSelect: true
          });
          $('#Item_L').on('change', function (e) {
              var data = $('#Item_L').select2("val");
          @this.set('item_no', data);
          @this.set('TheItemListSelected',1);
          });
      });
      window.livewire.on('item-change-event',()=>{
          $('#Item_L').select2({
              closeOnSelect: true
          });
      });



  </script>


@endpush

