<div x-data  class="row gy-1 my-1"  >
  <div class="col-md-2 mx-0">
    <label  for="bank_no" class="form-label mx-0" >المصرف</label>
  </div>
  <div class="col-md-4 mx-0">
   <input wire:model="bank_no"  wire:keydown.enter="ChkBankAndGo" type="text" class=" form-control mx-0 "
           id="bank_no"   autofocus >
    @error('bank_no') <span class="error">{{ $message }}</span> @enderror
  </div>
  @if (session()->has('message'))
    <div class="d-inline-flex align-items-center mt-2 mb-0" style="height: 20px;">
      <div style="height: 20px; width: 50%">
      </div>
      <div class="alert alert-danger text-center p-0 " style="height: 20px; width: 50%">
        {{ session('message') }}
      </div>
    </div>
  @endif
  <div   class="col-md-6 mx-0" >
    @livewire('bank.bank-select')
  </div>
</div>

@push('scripts')
  <script>
      Livewire.on('goto',postid=>  {
          if (postid=='bank_no') {  $("#bank_no").focus();$("#bank_no").select(); }
      })
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
      $(document).ready(function ()
      {
          $('#Bank_L').select2({
              closeOnSelect: true
          });
          $('#Bank_L').on('change', function (e) {
              var data = $('#Bank_L').select2("val");
          @this.set('bank_no', data);
          @this.set('TheBankListIsSelectd', 1);
          });
      });
      window.livewire.on('bank-change-event',()=>{
          $('#Bank_L').select2({
              closeOnSelect: true
          });
      });
  </script>
@endpush

