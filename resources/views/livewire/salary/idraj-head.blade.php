<div class="row  ">
  <div class="col-md-6">
  <div  class="d-inline-flex my-2 " >
    <label  class="form-label-me mx-1">السنة</label>
    <input wire:model="year" class="form-control mx-1 text-center" type="number"    id="year" style="width: 50%; " readonly>
  </div >

  <div  class="d-inline-flex my-2 " >
    <label  class="form-label-me mx-1">الشهر</label>
    <input wire:model="month" wire:keydown.enter="ChkMonth"
           class="form-control mx-1 text-center" type="number"    id="month" style="width: 50%; " autofocus>
    @error('month') <span class="error">{{ $message }}</span> @enderror
  </div >
  </div>
  <div   class="my-4 col-md-6 ">
    <button  wire:click="ConfirmDel" class=" mx-1 btn btn-danger" id="delete-btn">
      حذف اخر مرتب
    </button>
  </div>
  <div   class="my-4 col-md-12  ">
    <button  wire:click="Save" class=" mx-1 btn btn-primary" id="save-btn">
      ادراج المرتب
    </button>
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
          <button  wire:click.prevent="CloseDeleteDialog" type="button" class="btn btn-secondary close-btn" >تراجع</button>
          <button type="button" wire:click="Delete" class="btn btn-danger close-modal" data-dismiss="modal">نعم متأكد</button>
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
          if (postid=='month') {  $("#month").focus(); $("#month").select();};
          if (postid=='save-btn') {
              setTimeout(function() { document.getElementById('save-btn').focus(); },100);};
      })

  </script>

@endpush
