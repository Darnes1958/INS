<div class="row  ">
  <div  class="col-md-12  d-inline-flex my-2 " >
    <label  class="form-label-me mx-1">السنة</label>
    <input wire:model="year" class="form-control mx-1 text-center" type="number"    id="year" style="width: 50%; " readonly>
  </div >

  <div  class="col-md-12  d-inline-flex my-2 " >
    <label  class="form-label-me mx-1">الشهر</label>
    <input wire:model="month" wire:keydown.enter="ChkMonth" min="1" max="12"
           class="form-control mx-1 text-center" type="number"    id="month" style="width: 50%; " autofocus>
    @error('month') <span class="error">{{ $message }}</span> @enderror
  </div >
  <div   class="my-4 col-md-12  ">
    <button  wire:click="Save" class=" mx-1 btn btn-primary" id="save-btn">
      ادراج المرتب
    </button>
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

      @this.set('IsSave', false);
          if (postid=='month') {  $("#month").focus(); $("#month").select();};
          if (postid=='save-btn') {
              setTimeout(function() { document.getElementById('save-btn').focus(); },100);};
      })

  </script>

@endpush
