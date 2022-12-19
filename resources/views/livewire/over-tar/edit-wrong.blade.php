<div class="col-md-10 col-lg-12">
  <form >
    <div class="row g-3">
      <div class="col-md-6">
        <label for="tar_date" class="form-label">التاريخ</label>
        <input wire:model="tar_date" wire:keydown.enter="$emit('gotonext','acc')" type="date" class="form-control" id="tar_date"  >
        @error('tar_date') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-5 mb-2" >
        <label  for="acc" class="form-label-me">رقم الحساب</label>
        <input   wire:model="acc" wire:keydown.enter="$emit('gotonext','name')"
                class="form-control"  name="acc" type="text"  id="acc" >
        @error('acc') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-5 mb-2" >
        <label  for="name" class="form-label-me">الاسم</label>
        <input   wire:model="name" wire:keydown.enter="$emit('gotonext','kst')"
                class="form-control"   type="text"  id="name" >
        @error('name') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-6 mb-2">
        <label  for="kst" class="form-label-me">المبلغ</label>
        <input  wire:model="kst" wire:keydown.enter="$emit('gotonext','SaveBtn')"
               class="form-control  "
               type="number"  id="kst" >
        @error('kst') <span class="error">{{ $message }}</span> @enderror
      </div>
    </div>
    <input type="button"  id="savebtns"
           class="w-100 btn btn-outline-success  waves-effect waves-light  my-2 "
           wire:click.prevent="SaveWrong"   value="تخزين" />
    <br>
  </form>
</div>

@push('scripts')
  <script type="text/javascript">
      Livewire.on('gotonext',postid=>  {
          if (postid=='tar_date') {  $("#tar_date").focus(); $("#tar_date").select();};
          if (postid=='kst') { $("#kst").focus();  $("#kst").select(); };
          if (postid=='name') {  $("#name").focus(); $("#name").select();};
          if (postid=='acc') {  $("#acc").focus(); $("#acc").select();};
          if (postid=='SaveBtn') { setTimeout(function() { document.getElementById('savebtns').focus(); },100);};
      })

  </script>
@endpush

