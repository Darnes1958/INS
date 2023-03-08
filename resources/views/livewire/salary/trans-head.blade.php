<div class="row  ">
  <div  class="col-md-12  d-inline-flex my-1 " >
    <label  class="form-label-me mx-1" style="width: 10%; ">السنة</label>
    <input wire:model="year"  wire:keydown.enter="ChkYear"
           class="form-control mx-1 text-center" type="number"    id="year" style="width: 35%; " autofocus>

    <label  class="form-label-me mx-2" style="width: 10%; ">الشهر</label>
    <input wire:model="month" wire:keydown.enter="ChkMonth" min="1" max="12"
           class="form-control mx-1 text-center" type="number"    id="month" style="width: 30%; " >
    @error('month') <span class="error">{{ $message }}</span> @enderror
    @error('year') <span class="error">{{ $message }}</span> @enderror
  </div >
  <div  class="col-md-12  d-inline-flex my-1 " >
    <label  class="form-label-me mx-1" style="width: 10%; ">الاسم</label>
    <input wire:model="Name" class="form-control mx-1 " type="text"    id="name" style="width: 80%; " readonly>
  </div >

  <div class="col-md-12 my-1 mx-4" >
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="TranType"  name="inlineRadioOptions" id="inlineRadio2" value="2">
      <label class="form-check-label" for="inlineRadio2">سحب</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="TranType"  name="inlineRadioOptions" id="inlineRadio1" value="3">
      <label class="form-check-label" for="inlineRadio1">إضافة</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="TranType"  name="inlineRadioOptions" id="inlineRadio2" value="4">
      <label class="form-check-label" for="inlineRadio2">خصم</label>
    </div>
  </div>
  <div  class="col-md-12  d-inline-flex my-1 " >
    <label  class="form-label-me mx-1" style="width: 10%;">المبلغ</label>
    <input wire:model="Val" wire:keydown.enter="$emit('gotonext','Notes')"
           class="form-control mx-1 text-center" type="number"    id="Val" style="width: 50%; " autofocus>
    @error('Val') <span class="error">{{ $message }}</span> @enderror
  </div >
  <div  class="col-md-12  d-inline-flex my-1 " >
    <label  class="form-label-me mx-1" style="width: 10%;">ملاحظات</label>
    <input wire:model="Notes" wire:keydown.enter="$emit('gotonext','save-btn')"
           class="form-control mx-1 text-center" type="text"    id="Notes" style="width: 80%; " >

  </div >
  <div   class="my-2 col-md-12  " style="width: 30%;margin: auto">
    <button  wire:click="Save" class=" mx-1 btn btn-primary " id="save-btn" style="width: 100%">
      تخزين
    </button>
  </div>

  <div class="col-md-12">
    <table class="table table-sm table-bordered table-striped " width="100%"  id="mytable3" >
      <thead class="font-size-12 bg-primary text-white" >
      <tr >

        <th width="20%">التاريخ</th>
        <th width="10%">البيان</th>
        <th width="10%">المبلغ</th>
        <th >ملاحظات</th>
        <th width="5%"></th>
        <th width="5%"></th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TransList as  $item)
        <tr class="font-size-12">

          <td >{{$item->TranDate  }}   </td>
          <td >{{$item->TypeName  }}   </td>
          <td >{{$item->Val  }}   </td>
          <td >{{$item->Notes  }}   </td>
          <td  style="padding-top: 2px;padding-bottom: 2px; ">
            <i wire:click="selectItem({{ $item->id }},{{$item->Val}},'{{$item->Notes}}','update')"
               class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
          </td>
          <td  style="padding-top: 2px;padding-bottom: 2px; ">
            <i wire:click="selectItem({{ $item->id }},{{$item->Val}},'{{$item->Notes}}','delete')"
               class="btn btn-outline-danger btn-sm fa fa-times "></i>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    {{ $TransList->links() }}
  </div>
  <div class="modal fade" id="ModalMyDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
          <button wire:click="CloseDeleteDialog" type="button" class="close"  >
            <span aria-hidden="true close-btn">×</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>هل أنت متأكد من الإلغاء ?</h5>
        </div>
        <div class="modal-footer">
          <button  wire:click="CloseDeleteDialog" type="button" class="btn btn-secondary close-btn" >تراجع</button>
          <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">نعم متأكد</button>
        </div>
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
      window.addEventListener('OpenMyDelete', event => {
          $("#ModalMyDelete").modal('show');
      })
      window.addEventListener('CloseMyDelete', event => {
          $("#ModalMyDelete").modal('hide');
      })
      Livewire.on('gotonext',postid=>  {

      @this.set('IsSave', false);
          if (postid=='Val') {  $("#Val").focus(); $("#Val").select();};
          if (postid=='Notes') {  $("#Notes").focus(); $("#Notes").select();};
          if (postid=='year') {  $("#year").focus(); $("#year").select();};
          if (postid=='month') {  $("#month").focus(); $("#month").select();};
          if (postid=='save-btn') {
              setTimeout(function() { document.getElementById('save-btn').focus(); },100);};
      })

  </script>

@endpush
