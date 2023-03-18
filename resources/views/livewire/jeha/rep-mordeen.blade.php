
<div  >


 <div class="row">
    <div class="col-md-6">
      <table class="table table-striped table-bordered table-sm" >

        <thead class="font-size-14">
        <tr>
          @if($Favorite==1)
           <th style="width: 5%"> <i wire:click="selectFav(0)"
               class=" btn btn-outline-success btn-sm  fas fa-star editable-input" style="margin-left: 2px;"></i></th>
          @else
            <th style="width: 5%"><i wire:click="selectFav(1)"
                                          class="btn btn-outline-warning btn-sm  far fa-star editable-input" style="margin-left: 2px;"></i></th>
          @endif
          @if($Special==1)
            <th style="width: 5%">  <i wire:click="selectSpc(0)"
                                            class="btn btn-outline-success btn-sm  fas fa-user-secret editable-input" style="margin-left: 2px;"></i></th>
          @else
              <th style="width: 5%"> <i wire:click="selectSpc(1)"
                                        class="btn btn-outline-success btn-sm  far fa-user-secret editable-input" style="margin-left: 2px;"></i></th>
          @endif
          <th colspan="4">
            <div class=" form-check form-check-inline">
              <input class="form-check-input" type="checkbox" wire:model="ZeroShow"  name="inlineRadioOptions" id="inlineRadio1" value="yes">
              <label class="form-check-label" for="inlineRadio1">إظهار الأرصدة صفر</label>

            </div>
          </th>


        </tr>
        </thead>

        <thead class="font-size-12">
        <tr>
          <th style="width: 5%">مفضل</th>
          <th style="width: 5%">خاص</th>
          <th >اسم المورد</th>
          <th style="width: 14%">شراء</th>
          <th style="width: 14%">مردودات</th>
          <th style="width: 14%">قبض</th>
          <th style="width: 14%">دفع</th>
          <th style="width: 14%">الإجمالي</th>

        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($RepTable as $key=> $item)
          <tr class="font-size-12">
            @if($item->Favorite==1)
              <td  style="padding-top: 2px;padding-bottom: 2px; ">
                <i wire:click="selectItem({{ $item->jeha_no }},'notfavorite')"
                   class="btn btn-outline-success btn-sm  fas fa-star editable-input" style="margin-left: 2px;"></i>
              </td>
            @else
              <td  style="padding-top: 2px;padding-bottom: 2px; ">
                <i wire:click="selectItem({{ $item->jeha_no }},'favorite')"
                   class="btn btn-outline-warning btn-sm  far fa-star editable-input" style="margin-left: 2px;"></i>
              </td>
            @endif
              @can('عميل خاص')
                @if($item->acc_no==1)
                  <td  style="padding-top: 2px;padding-bottom: 2px; ">
                    <i wire:click="selectItem({{ $item->jeha_no }},'notspecial')"
                       class="btn btn-outline-dark btn-sm  fas fa-user-secret editable-input" style="margin-left: 2px;"></i>
                  </td>
                @else
                  <td  style="padding-top: 2px;padding-bottom: 2px; ">
                    <i wire:click="selectItem({{ $item->jeha_no }},'special')"
                       class="btn btn-outline-secondary btn-sm  far fa-user-secret editable-input" style="margin-left: 2px;"></i>
                  </td>
                @endif
              @endcan
            <td><a wire:click="selectItem({{ $item->jeha_no }},'nothing')" href="#">{{$item->jeha_name}}</a>  </td>
            <td> {{ number_format($item->tot,2, '.', ',') }} </td>
            <td> {{ number_format($item->TarBuy,2, '.', ',') }} </td>
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
        <th></th>
        <th></th>
        <th></th>
        <th style="font-weight: bold">الاجمالي</th>
        <th style="font-weight: bold">{{ number_format($Sum,2, '.', ',') }}</th>

        </tr>
        </tfoot>
      </table>
      {{ $RepTable->links() }}
    </div>
   <div class="col-md-6">
     <table class="table table-sm table-bordered table-striped  " width="100%"  id="mytable3" >
       <caption class="font-size-18 caption-top text-center p-0" style="color: #0a53be">{{$jeha_name}}</caption>
       <thead class="font-size-12 bg-primary text-white">

       <tr style="text-align: center;">
         <th >البيان</th>
         <th style="width: 14% ;">التاريخ</th>
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

