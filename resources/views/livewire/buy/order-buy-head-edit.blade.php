 <div x-data class="col-md-12 " style="margin-bottom: 20px;margin-top: 16px;" xmlns="http://www.w3.org/1999/html">

    <div x-show="$wire.HeadOpen" class="row g-3 " style="border:1px solid lightgray;background: white;">
      <div class="col-md-12" >
        @livewire('buy.buy-select')
      </div>
      <div class="col-md-6">
          <label  for="orderno" class="form-label-me ">رقم الفاتورة</label>
          <input wire:model="orderno"  wire:keydown.enter="ChkOrderNoAndGo" type="text" class=" form-control "
                 id="orderno" name="orderno"  autofocus >
          @error('orderno') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-6">
          <label   for="date" class="form-label-me">التاريخ</label>
          <input x-bind:disabled="!$wire.OrderNoFound" wire:model="order_date" wire:keydown.enter="$emit('gotonext','jehano')"
                 class="form-control  "
                  type="date"  id="order_date" >
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
               x-bind:hidden="!$wire.OrderNoFound" class= " btn btn-outline-success  waves-effect waves-light   "
              wire:click.prevent="BtnHeader"  value="موافق" />

    </div>
    </div>



 </div>

@push('scripts')
  <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {
            if (postid=='orderno') {  $("#orderno").focus();$("#orderno").select(); };
            if (postid=='order_date') {  $("#order_date").focus();$("#order_date").select(); };

            if (postid=='head-btn') {
                setTimeout(function() { document.getElementById('head-btn').focus(); },100);};
        });
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
        $(document).ready(function ()
        {
            $('#Buy_L').select2({
                closeOnSelect: true
            });
            $('#Buy_L').on('change', function (e) {
                var data = $('#Buy_L').select2("val");
            @this.set('orderno', data);
            @this.set('TheOrderListSelected',1);
            });
        });
        window.livewire.on('buy-change-event',()=>{
            $('#Order_L').select2({
                closeOnSelect: true
            });
        });
  </script>
@endpush
