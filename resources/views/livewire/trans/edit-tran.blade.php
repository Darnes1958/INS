<div class="col-md-10 col-lg-12">
  <form >
    <div class="row g-3">
      <div class="col-md-6">
        <label for="edittran_date" class="form-label">التاريخ</label>
        <input wire:model="edittran_date" wire:keydown.enter="$emit('gotonext','editval')" type="date" class="form-control" id="edittran_date"  >
        @error('edittran_date') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-6">
        <label for="editval" class="form-label">المبلغ</label>
        <input wire:model="editval"  wire:keydown.enter="$emit('gotonext','editnotes')" type="text" class="form-control"
               id="editval"  >
        @error('editval') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-12">
        <label for="editnotes" class="form-label">ملاحظات</label>
        <input wire:model="editnotes"  wire:keydown.enter="$emit('gotonext','savebtns')"  type="text" class="form-control" id="editnotes"  >
        @error('editnotes') <span class="error">{{ $message }}</span> @enderror
      </div>
    </div>
    <input type="button"  id="savebtns"
           class="w-100 btn btn-outline-success  waves-effect waves-light  my-2 "
           wire:click.prevent="SaveVal"   value="تخزين" />
    <br>
  </form>
</div>

@push('scripts')
  <script type="text/javascript">


      Livewire.on('gotonext',postid=>  {
          if (postid=='edittran_date') {  $("#edittran_date").focus(); $("#edittran_date").select();};
          if (postid=='editval') { $("#editval").focus();  $("#editval").select(); };
          if (postid=='editnotes') {  $("#editnotes").focus(); $("#editnotes").select();};
          if (postid=='savebtns') { setTimeout(function() { document.getElementById('savebtn').focus(); },100);};
      })

  </script>
@endpush

