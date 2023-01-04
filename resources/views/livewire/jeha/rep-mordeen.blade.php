
<div  >
  <div class="row">
    <div class="col-md-2 form-check form-check-inline">
      <input class="form-check-input" type="checkbox" wire:model="ZeroShow"  name="inlineRadioOptions" id="inlineRadio1" value="yes">
      <label class="form-check-label" for="inlineRadio1">إظهار الأرصدة صفر</label>
    </div>
  </div>

 <div class="row">
    <div class="col-md-6">
      <table class="table table-striped table-bordered table-sm"
             >
        <thead class="font-size-12">
        <tr>
          <th >اسم المورد</th>
          <th style="width: 14%">فواتير الشراء</th>
          <th style="width: 14%">ايصالات القبض</th>
          <th style="width: 14%">ايصالات الدفع</th>
          <th style="width: 14%">الإجمالي</th>

        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($RepTable as $key=> $item)
          <tr class="font-size-12">
            <td><a wire:click="selectItem({{ $item->jeha_no }})" href="#">{{$item->jeha_name}}</a>  </td>
            <td> {{ number_format($item->tot,2, '.', ',') }} </td>
            <td> {{ number_format($item->ValImp,2, '.', ',') }} </td>
            <td> {{ number_format($item->ValExp,2, '.', ',') }} </td>
            <td> {{ number_format($item->differ,2, '.', ',') }} </td>
          </tr>
        @endforeach
        </tbody>

        <tfoot>
        <tr class="font-size-12 font-weight-bold">
        <th></th>
        <th></th>
        <th></th>
        <th style="font-weight: bold">الاجمالي</th>
        <th style="font-weight: bold">{{ number_format($Sum,2, '.', ',') }}</th>
        <th></th>
        </tr>
        </tfoot>
      </table>
      {{ $RepTable->links() }}
    </div>
   <div class="col-md-6">
     <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
       <caption class="font-size-18 caption-top " style="color: #0a53be">{{$jeha_name}}</caption>
       <thead class="font-size-12">
       <tr>
         <th >البيان</th>
         <th style="width: 14%">التاريخ</th>
         <th style="width: 14%">رقم المعاملة</th>
         <th style="width: 14%">الاجمالي</th>
         <th style="width: 14%">المدفوع</th>
         <th style="width: 14%">الأجل</th>

       </tr>
       </thead>
       <tbody id="addRow" class="addRow">
       @foreach($RepTable2 as $key=> $item)
         <tr class="font-size-12">
           <td> {{  $item->wtype }} </td>
           <td> {{ $item->order_date  }}</td>
           <td> {{ $item->order_no }} </td>
           <td> {{ number_format($item->tot,2, '.', ',') }} </td>
           <td> {{ number_format($item->cash,2, '.', ',') }} </td>
           <td> {{ number_format($item->not_cash,2, '.', ',') }} </td>
         </tr>
       @endforeach
       </tbody>
     </table>
     {{ $RepTable2->links() }}

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
          if (postid=='tran_date') {  $("#tran_date").focus();$("#tran_date").select(); };
          if (postid=='jehano') {  $("#jehano").focus(); $("#jehano").select();};
      })

      window.addEventListener('ClosejehaModal', event => {
          $("#ModalRepjeha").modal('hide');
      })
      window.addEventListener('OpenjehaModal', event => {
          $("#ModalRepjeha").modal('show');
      })
  </script>


@endpush

