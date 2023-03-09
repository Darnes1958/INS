<div class="row  ">
  <div class="col-md-4 ">
   <div class="row">
    <div  class="col-md-12  d-inline-flex my-2 " >
      @livewire('salary.emp-select')
    </div >
     <div  class="col-md-12  d-inline-flex my-2 " >
       <label  class="form-label-me mx-1" style="width: 15%;">مكان العمل</label>
       <input wire:model="CenterName"
              class="form-control mx-1 "  style="width: 85%; " readonly>

     </div >
     <div  class="col-md-12  d-inline-flex my-2 " >
       <label  class="form-label-me mx-1" style="width: 15%;">الرصيد</label>
       <input wire:model="Raseed"
              class="form-control mx-1 "  style="width: 50%; " readonly>

     </div >
    <div  class="col-md-12  d-inline-flex my-2 " >
      <label  class="form-label-me mx-1" style="width: 15%;">المبلغ</label>
      <input wire:model="Val" wire:keydown.enter="$emit('gotonext','Notes')"
             class="form-control mx-1 text-center" type="number"    id="Val" style="width: 50%; " autofocus>
      @error('Val') <span class="error">{{ $message }}</span> @enderror
    </div >
    <div  class="col-md-12  d-inline-flex my-2 " >
      <label  class="form-label-me mx-1" style="width: 15%;">ملاحظات</label>
      <textarea wire:model="Notes" wire:keydown.enter="$emit('gotonext','save-btn')"
             class="form-control mx-1 "     id="Notes" style="width: 85%; " ></textarea>

    </div >
    <div   class="my-4 col-md-12  " style="width: 30%;margin: auto">
      <button  wire:click="Save" class=" mx-1 btn btn-primary " id="save-btn" style="width: 100%">
        تخزين
      </button>
    </div>
   </div>
  </div>

  <div class="col-md-8 my-2">
    <table class="table table-sm table-bordered table-striped " width="100%"  id="mytable3" >
      <thead class="font-size-12 bg-primary text-white" >
      <tr >
        <th width="12%">الرقم الألي</th>
        <th width="18%" >التاريخ</th>
        <th width="12%">المبلغ</th>
        <th >ملاحظات</th>
        <th width="5%"></th>
        <th width="5%"></th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TransList as  $item)
        <tr class="font-size-12">
          <td >{{$item->id  }}   </td>
          <td style="text-align: center">{{$item->TranDate  }}   </td>
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

          if (postid=='save-btn') {
              setTimeout(function() { document.getElementById('save-btn').focus(); },100);};
      })

      $(document).ready(function ()
      {
          $('#SalId_L').select2({
              closeOnSelect: true
          });
          $('#SalId_L').on('change', function (e) {
              var data = $('#SalId_L').select2("val");

          @this.set('SalId', data);
          @this.set('TheSalIdListIsSelected', 1);
          });
      });
      window.livewire.on('salid-change-event',()=>{
          $('#SalId_L').select2({
              closeOnSelect: true
          });
      });

  </script>

@endpush
