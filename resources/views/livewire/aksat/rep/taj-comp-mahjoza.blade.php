<div x-data  class="row gy-1 my-1"  >
  <div class="col-md-2 ">
    <label  for="TajNo" class="form-label-me " >المصرف التجميعي</label>
  </div>
  <div class="col-md-3 ">
   <input wire:model="TajNo"  wire:keydown.enter="ChkTajAndGo" type="text" class=" form-control  "
           id="TajNo"   autofocus >
    @error('TajNo') <span class="error">{{ $message }}</span> @enderror
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
  <div   class="col-md-7 mx-0" >
    @livewire('admin.taj-mahjoza-select')
  </div>
</div>

@push('scripts')
  <script>
      Livewire.on('goto',postid=>  {
          if (postid=='TajNo') {  $("#TajNo").focus();$("#TajNo").select(); }
      })
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
      $(document).ready(function ()
      {
          $('#TajNo_L_Mahjoza').select2({
              closeOnSelect: true
          });
          $('#TajNo_L_Mahjoza').on('change', function (e) {
              var data = $('#TajNo_L_Mahjoza').select2("val");
          @this.set('TajNo', data);
          @this.set('TheTajListIsSelectd', 1);



          });
      });
      window.livewire.on('taj-mahjoza-change-event',()=>{
          $('#TajNo_L_Mahjoza').select2({
              closeOnSelect: true
          });
      });
  </script>
@endpush

