<div x-data x-show="$wire.StoreDetailOpen"   class="row g-3 my-1 " style="border:1px solid lightgray;background: white;">

  <div class="col-md-12" x-show="$wire.StoreDetailOpen"  >
    <div class="row g-2 ">
      <div class="col-md-12" >
        @livewire('stores.item-select', ['PlaceSelectType' => $Table1,'PlaceToselect' => $place_no1])
      </div>
    </div>
  </div>

  <div class="col-md-4" >
    <label  for="itemno" class="form-label-me ">رقم الصنف</label>
    <input wire:model="item"  wire:keydown.enter="ChkItemAndGo"
           type="number" class="form-control"  id="itemno" name="itemno" style="text-align: center;">
  </div>

  <div class="col-4 ">
    <label for="quant" class="form-label-me " >الكمية</label>
    <input wire:model="quant" wire:keydown.enter="ChkQuant"  x-bind:disabled="!$wire.ItemGeted"
           class="form-control " name="quant" type="number" value="1"
           id="quant"  style="text-align: center" >
    @error('quant') <span class="error">{{ $message }}</span> @enderror
  </div>
  @can('سعر الشراء')
  <div class="col-4">
    <label for="price" class="form-label-me">السعر</label>
    <input wire:model="price"  class="form-control" name="price" type="number" value=""
           id="price"  style="text-align: center"  readonly>
  </div>
  @endcan
  <div class="col-4 my-3">
    <label for="raseed" class="form-label-me" >الرصيد الكلي</label>
    <input wire:model="raseed" class="form-control " name="raseed" type="text" readonly
           id="raseed"   >
  </div>
  <div class="col-4 my-3">
    <label for="place1_raseed" class="form-label-me " >{{$place1_label}}</label>
    <input wire:model="place1_raseed" class="form-control "  type="text" readonly
           id="place1_raseed"   >
  </div>
  <div class="col-4 my-3">
    <label for="place2_raseed" class="form-label-me " >{{$place2_label}}</label>
    <input wire:model="place2_raseed" class="form-control "  type="text" readonly
           id="place2_raseed"   >
  </div>

</div>


@push('scripts')
  <script type="text/javascript">
      Livewire.on('itemchange',postid=>{

          $("#itemno").focus();
      });

      Livewire.on('gotonext',postid=>  {

          if (postid=='quant') {  $("#quant").focus();  $("#quant").select();};

          if (postid=='item') {  $("#itemno").focus(); $("#itemno").select(); };
          if (postid=='detail-btn') {
              setTimeout(function() { document.getElementById('detail-btn').focus(); },100);};
      });


  </script>

  <script>
      $(document).ready(function ()
      {
          $('#Item_L').select2({
              closeOnSelect: true
          });
          $('#Item_L').on('change', function (e) {
              var data = $('#Item_L').select2("val");
          @this.set('item', data);
          @this.set('TheItemListIsSelectd', 1);

          });
      });
      window.livewire.on('item-change-event',()=>{
          $('#Item_L').select2({
              closeOnSelect: true

          });


      });
  </script>

@endpush

