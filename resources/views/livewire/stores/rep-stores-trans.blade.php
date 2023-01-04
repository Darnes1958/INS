
<div  >


  <div class="row my-2 ">
    <div class="col-md-2 " style="border:1px solid lightgray;background: white;">
      <div class="my-4">
        <label  class="form-label-me">التاريخ</label>
        <input wire:model="per_date" wire:keydown.enter="ChkDate" type="date"
                 class="form-control  "   >
        @error('order_date') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="my-4" >
        <input class="form-check-input" type="radio" wire:model="Report"  name="inlineRadioOptions" id="inlineRadio1" value="imp">
        <label class="form-check-label" for="inlineRadio1">اذونات الاستلام</label>
      </div>
      <div class="my-4">
        <input class="form-check-input" type="radio" wire:model="Report"  name="inlineRadioOptions" id="inlineRadio1" value="exp">
        <label class="form-check-label" for="inlineRadio1">اذونات التسليم</label>
      </div>
      <div class="my-4">
        <input class="form-check-input" type="radio" wire:model="Report"  name="inlineRadioOptions" id="inlineRadio1" value="imptot">
        <label class="form-check-label" for="inlineRadio1">اجمالي المستلم</label>
      </div>
      <div class="my-4">
        <input class="form-check-input" type="radio" wire:model="Report"  name="inlineRadioOptions" id="inlineRadio1" value="exptot">
        <label class="form-check-label" for="inlineRadio1">اجمالي المنصرف</label>
      </div>

    </div>
    <div x-data class="col-md-8">
      <div x-show="$wire.Report=='imp'">
        <table  class="table table-striped table-bordered table-sm">
          <thead class="font-size-12">
          <tr>
            <th style="width: 10%">رقم إذن الاستلام</th>
            <th style="width: 25%">إلــــــــي</th>
            <th style="width: 10%">رقم فاتورة الشراء</th>
            <th style="width: 10%">رقم الصنف</th>
            <th style="width: 25%">اسم الصنف</th>
            <th style="width: 10%">الكمية</th>
            <th style="width: 10%">السعر</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($ImpTable as $key=> $item)
            <tr class="font-size-12">
              <td> {{ $item->per_no }}</td>
              <td> {{$item->st_name }} </td>
              <td> {{$item->order_no }} </td>
              <td> {{$item->item_no }} </td>
              <td> {{$item->item_name }} </td>
              <td> {{$item->quant }} </td>
              <td> {{$item->price }} </td>
            </tr>
          @endforeach
          </tbody>
        </table>
        {{ $ImpTable->links() }}
      </div>
      <div x-show="$wire.Report=='exp'">
        <table class="table table-striped table-bordered table-sm">
          <thead class="font-size-12">
          <tr>
            <th style="width: 10%">رقم إذن الاستلام</th>
            <th style="width: 10%">مــــــــن</th>
            <th style="width: 25%">إلــــــــي</th>
            <th style="width: 10%">رقم الصنف</th>
            <th style="width: 25%">اسم الصنف</th>
            <th style="width: 10%">الكمية</th>
            <th style="width: 10%">رقم فاتورة البيع</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($ExpTable as $key=> $item)
            <tr class="font-size-12">
              <td> {{ $item->per_no }} </td>
              <td> {{$item->st_name }} </td>
              <td> {{$item->place_name }} </td>
              <td> {{$item->item_no }} </td>
              <td> {{$item->item_name }} </td>
              <td> {{$item->quant }} </td>
              <td> {{$item->order_no }} </td>
            </tr>
          @endforeach
          </tbody>
        </table>
        {{ $ExpTable->links() }}
      </div>
      <div x-show="$wire.Report=='imptot'">
        <table  class="table table-striped table-bordered table-sm">
          <thead class="font-size-12">
          <tr>
            <th style="width: 30%">إلــــــــي</th>
            <th style="width: 15%">رقم الصنف</th>
            <th style="width: 30%">اسم الصنف</th>
            <th style="width: 15%">الكمية</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($ImpTotTable as $key=> $item)
            <tr class="font-size-12">
              <td> {{$item->st_name }} </td>
              <td> {{$item->item_no }} </td>
              <td> {{$item->item_name }} </td>
              <td> {{$item->quant }} </td>
            </tr>
          @endforeach
          </tbody>
        </table>
        {{ $ImpTotTable->links() }}
      </div>
      <div x-show="$wire.Report=='exptot'">
        <table  class="table table-striped table-bordered table-sm">
          <thead class="font-size-12">
          <tr>
            <th style="width: 30%">مــــــــــــن</th>
            <th style="width: 15%">رقم الصنف</th>
            <th style="width: 30%">اسم الصنف</th>
            <th style="width: 15%">الكمية</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($ExpTotTable as $key=> $item)
            <tr class="font-size-12">
              <td> {{$item->st_name }} </td>
              <td> {{$item->item_no }} </td>
              <td> {{$item->item_name }} </td>
              <td> {{$item->quant }} </td>
            </tr>
          @endforeach
          </tbody>
        </table>
        {{ $ExpTotTable->links() }}
      </div>

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

