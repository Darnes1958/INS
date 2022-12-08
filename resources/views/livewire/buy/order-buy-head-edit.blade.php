 <div x-data class="col-md-12 " style="margin-bottom: 20px;margin-top: 16px;" xmlns="http://www.w3.org/1999/html">

    <div  class="row g-3 " style="border:1px solid lightgray;background: white;">
      <div class="col-md-6">
          <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
          <input wire:model="order_no"  wire:keydown.enter="ChkOrderNoAndGo" type="text" class=" form-control "
                 id="order_no" name="order_no"  autofocus >
          @error('order_no') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-6">
          <label  x-bind:disabled="!OrderNofound" for="date" class="form-label-me">التاريخ</label>
          <input wire:model="order_date" wire:keydown.enter="$emit('gotonext','jehano')"
                 class="form-control  "
                 name="date" type="date"  id="date" >
          @error('order_date') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="row g-3 ">
        <div class="col-md-12">
          <label   class="form-label-me">المورد</label>
          <input wire:model="jeha_name"   class="form-control" readonly    type="text"   >
        </div>
        <div class="col-md-12">
          <label   class="form-label-me">المخزن</label>
          <input wire:model="st_name"   class="form-control" readonly    type="text"   >
        </div>
      </div>

      <div class="my-3 align-center justify-content-center "  style="display: flex">

        <input type="button"  id="head-btn"
              class=" btn btn-outline-success  waves-effect waves-light   "
              wire:click.prevent="BtnHeader"  wire:keydown.enter="BtnHeader" value="موافق" />

    </div>
    </div>



 </div>

@push('scripts')
  <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {
            if (postid=='orderno') {  $("#order_no").focus();$("#order_no").select(); };
            if (postid=='date') {  $("#date").focus();$("#date").select(); };

            if (postid=='head-btn') {
                setTimeout(function() { document.getElementById('head-btn').focus(); },100);};
        })
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
  </script>
@endpush
