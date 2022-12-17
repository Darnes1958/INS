<div class="col-md-10 col-lg-12">
  <form >
    <div class="row g-3">
      <div class="col-md-6">
        <label for="edittar_date" class="form-label">التاريخ</label>
        <input wire:model="edittar_date" wire:keydown.enter="$emit('gotonextover','editkst')"
               type="date" class="form-control" id="edittar_date"  >
        @error('edittar_date') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-6">
        <label for="editkst" class="form-label">المبلغ</label>
        <input wire:model="editkst"  wire:keydown.enter="$emit('gotonextover','oversavebtn')"
               type="number" class="form-control"
               id="editkst"  >
        @error('editkst') <span class="error">{{ $message }}</span> @enderror
      </div>

    </div>
    <input type="button"  id="saveoverbtn"
           class="w-100 btn btn-outline-success  waves-effect waves-light  my-2 "
           wire:click.prevent="SaveVal"   value="تخزين" />
    <br>
  </form>
</div>

@push('scripts')
  <script type="text/javascript">
      Livewire.on('gotonextover',postid=>  {
          if (postid=='edittar_date') {  $("#edittar_date").focus(); $("#edittar_date").select();};
          if (postid=='editkst') { $("#editkst").focus();  $("#editkst").select(); };

          if (postid=='oversavebtn') { setTimeout(function() { document.getElementById('saveoverbtn').focus(); },100);};
      })
  </script>
@endpush

