<div class="col-md-10 col-lg-12">

  <form >
    <div class="row g-3">
      <div class="col-md-6">
        <label for="editksm_date" class="form-label">تاريخ الخصم</label>
        <input wire:model="EditKsm_Date" wire:keydown.enter="$emit('gotonext','editksm')" type="date" class="form-control" id="editksm_date"  >
        @error('ksm_date') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-6">
        <label for="editksm" class="form-label">القسط</label>
        <input wire:model="EditKsm"  wire:keydown.enter="$emit('gotonext','editksmnotes')" type="text" class="form-control"
               id="editksm" placeholder="ادخال اسم الصنف" >
        @error('ksm') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="col-md-12">
        <label for="editnotes" class="form-label">ملاحظات</label>
        <input wire:model="EditNotes"  wire:keydown.enter="$emit('gotonext','edit-save-ksm')"  type="text" class="form-control" id="editnotes"  >
        @error('notes') <span class="error">{{ $message }}</span> @enderror
      </div>
    </div>


    <input type="button"  id="edit-save-ksm"
           class="w-100 btn btn-outline-success  waves-effect waves-light   "
           wire:click.prevent="EditSaveKsm"  wire:keydown.enter="EditSaveKsm" value="موافق" />
    <br>
  </form>
</div>

@push('scripts')
  <script type="text/javascript">


      Livewire.on('gotonext',postid=>  {


          if (postid=='editksmdate') {  $("#editksm_date").focus(); $("#editksm_date").select();};
          if (postid=='editksm') { $("#editksm").focus();  $("#editksm").select(); };
          if (postid=='editksmnotes') {  $("#editnotes").focus(); $("#editnotes").select();};

          if (postid=='edit-save-ksm') { setTimeout(function() { document.getElementById('edit-save-ksm').focus(); },100);};

      })

  </script>
@endpush
