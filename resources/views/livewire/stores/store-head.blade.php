<div x-data    class="row gy-3 my-1" style="border:1px solid lightgray;background: white; " >
  <div  class="col-md-5">
    <label  for="place_no1" class="form-label-me ">{{ $From }}</label>
    <input x-bind:disabled="!$wire.HeadOpen" wire:model="place_no1"  wire:keydown.enter="ChkPlace1AndGo" type="text" class=" form-control "
           id="place_no1"   autofocus >
    @error('place_no1') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div   class="col-md-7" >
    <label  class="form-label-me">.</label>
    @livewire('stores.store-select1',['table'=>$Table1])
  </div>

  <div class="col-md-5">
    <label  for="place_no2" class="form-label-me ">{{ $To }}</label>
    <input x-bind:disabled="!$wire.HeadOpen" wire:model="place_no2"  wire:keydown.enter="ChkPlace2AndGo" type="text" class=" form-control "
           id="place_no2"   autofocus >
    @error('place_no2') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div   class="col-md-7" >
    <label  class="form-label-me">.</label>
    @livewire('stores.store-select2',['table'=>$Table2])
  </div>

  <div  class="my-3 align-center justify-content-center "  style="display: flex">
    <input  type="button"  id="head-btn"   class=" btn btn-outline-success  waves-effect waves-light   "
            x-bind:disabled="!$wire.PlaceGeted || !$wire.HeadOpen" wire:click.prevent="BtnHeader"   value="موافق" />
  </div>

</div>

@push('scripts')


  <script type="text/javascript">
      Livewire.on('goto',postid=>  {
          if (postid=='place_no1') {  $("#place_no1").focus();$("#place_no1").select(); }
          if (postid=='place_no2') {  $("#place_no2").focus();$("#place_no2").select(); }
          if (postid=='head-btn') {
              setTimeout(function() { document.getElementById('head-btn').focus(); },100);};
      })
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });

      $(document).ready(function ()
      {
          $('#Place_L1').select2({
              closeOnSelect: true
          });
          $('#Place_L1').on('change', function (e) {
              var data = $('#Place_L1').select2("val");
          @this.set('place_no1', data);
          @this.set('ThePlace1ListIsSelected', 1);
          });
      });
      window.livewire.on('place1-change-event',()=>{
          $('#Place_L1').select2({
              closeOnSelect: true
          });
      });
      $(document).ready(function ()
      {
          $('#Place_L2').select2({
              closeOnSelect: true
          });
          $('#Place_L2').on('change', function (e) {
              var data = $('#Place_L2').select2("val");
          @this.set('place_no2', data);
          @this.set('ThePlace2ListIsSelected', 1);
          });
      });
      window.livewire.on('place2-change-event',()=>{
          $('#Place_L2').select2({
              closeOnSelect: true
          });
      });

  </script>
@endpush
