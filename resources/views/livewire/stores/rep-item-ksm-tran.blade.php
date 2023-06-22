
<div  >
  <div class="row my-2">
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

    <div  class="col-md-2 ">
      <a  href="{{route('pdfitemksmtran',['item_no'=>$item_no,'item_name'=>$item_name,'tran_date'=>$tran_date])}}"
          class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
    </div>
  </div>

  <table style="width:80%" class="table table-sm table-bordered table-striped table-light  "   >
    <thead class="font-size-12">
    <tr>
      <th style="width: 12%">رقم العقد</th>
      <th style="width: 12%">رقم الحساب</th>
      <th >الإسم</th>
      <th style="width: 12%">التاريخ</th>
      <th style="width: 10%">القسط</th>
      <th style="width: 10%">البيان</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($RepTable as $key=> $item)
      <tr class="font-size-12">
        <td> {{ $item->no }} </td>
        <td> {{ $item->acc }} </td>
        <td> {{ $item->name }} </td>
        <td> {{ $item->ksm_date }} </td>
        <td> {{ $item->ksm }} </td>
        <td> {{ $item->MainOrArc }} </td>
      </tr>

    @endforeach
    <tr class="font-size-12 ">
      <td>  </td>
      <td>  </td>
      <td>  </td>

      <td style="font-weight: bold"> الإجمالي </td>
      <td style="font-weight: bold"> {{ number_format($SumKsm,2, '.', ',') }} </td>
      <td>  </td>
    </tr>
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

