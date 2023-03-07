<div class="row  ">
  <div  class="col-md-12  d-inline-flex my-2 " >
    <label  class="form-label-me mx-1" style="width: 10%; ">الاسم</label>
    <input wire:model="Name" class="form-control mx-1 " type="text"    id="name" style="width: 80%; " readonly>
  </div >
  <div  class="col-md-12  d-inline-flex my-2 " >
    <label  class="form-label-me mx-1" style="width: 10%; ">المرتب</label>
    <input wire:model="Sal" class="form-control mx-1 text-center" type="number"    id="Sal" style="width: 50%; " readonly>
  </div >
  <div class="col-md-12 my-4 mx-4" >
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
  <div  class="col-md-12  d-inline-flex my-2 " >
    <label  class="form-label-me mx-1" style="width: 10%;">المبلغ</label>
    <input wire:model="Val" wire:keydown.enter="$emit('gotonext','Notes')"
           class="form-control mx-1 text-center" type="number"    id="Val" style="width: 50%; " autofocus>
    @error('Val') <span class="error">{{ $message }}</span> @enderror
  </div >
  <div  class="col-md-12  d-inline-flex my-2 " >
    <label  class="form-label-me mx-1" style="width: 10%;">ملاحظات</label>
    <input wire:model="Notes" wire:keydown.enter="$emit('gotonext','save-btn')"
           class="form-control mx-1 text-center" type="text"    id="Notes" style="width: 80%; " >

  </div >
  <div   class="my-4 col-md-12  " style="width: 30%;margin: auto">
    <button  wire:click="Save" class=" mx-1 btn btn-primary " id="save-btn" style="width: 100%">
      تخزين
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
          if (postid=='Val') {  $("#Val").focus(); $("#Val").select();};
          if (postid=='Notes') {  $("#Notes").focus(); $("#Notes").select();};
          if (postid=='save-btn') {
              setTimeout(function() { document.getElementById('save-btn').focus(); },100);};
      })

  </script>

@endpush
