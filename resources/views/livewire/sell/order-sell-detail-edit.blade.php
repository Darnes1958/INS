
<div x-data="{ $wire.OrderDetailOpen: true }" x-show="$wire.OrderDetailOpen"
     class="row g-3 " style="border:1px solid lightgray;background: white;">

  <div class="col-md-12" x-show="$wire.DetailOpen"  >
    <div class="row g-2 ">
      <div class="col-md-12" >
        @livewire('stores.item-select', ['PlaceSelectType' => $OrderPlacetype,'PlaceToselect' => $OrderPlaceId])
      </div>
    </div>
  </div>

  <div class="col-md-4" >
    <label  for="itemno" class="form-label-me ">رقم الصنف</label>
    <input wire:model="item"  wire:keydown.enter="ChkItemAndGo"  x-bind:disabled="!$wire.DetailOpen"
           type="text" class="form-control"  id="itemno" name="itemno" style="text-align: center;height: 39px;">
  </div>
  <div class="col-md-8">
    <label  for="item_name" class="form-label-me ">اسم الصنف</label>
    <textarea wire:model="item_name" name="item_name" class="form-control"
              style="color: #0b5ed7; "
              readonly id="item_name" ></textarea>
    @error('item') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-6 ">
    <label for="quant" class="form-label-me " >الكمية</label>
    <input wire:model="quant" wire:keydown.enter="ChkQuant"  x-bind:disabled="!$wire.DetailOpen"
           class="form-control " name="quant" type="text" value="1"
           id="quant"  style="text-align: center" >
    @error('quant') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-6 ">
    <label for="raseed" class="form-label-me" >الرصيد الكلي</label>
    <input wire:model="raseed" class="form-control " name="raseed" type="text" readonly
           id="raseed"   >
  </div>
  <div class="col-6">
    <label for="price" class="form-label-me">السعر</label>
    <input wire:model="price" wire:keydown.enter="ChkRec" class="form-control" name="price" type="text" value=""
           id="price"  style="text-align: center"  x-bind:disabled="!$wire.DetailOpen">
    <br>

    @error('price') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-6 ">
    <label for="st_raseed" class="form-label-me " >{{$st_label}}</label>
    <input wire:model="st_raseed" class="form-control " name="st_raseed" type="text" readonly
           id="st_raseed"   >
  </div>
</div>


@push('scripts')
  <script type="text/javascript">
      Livewire.on('itemchange',postid=>{

          $("#itemno").focus();
      });

      Livewire.on('gotonext',postid=>  {

          if (postid=='quant') {  $("#quant").focus();  $("#quant").select();};

          if (postid=='item_no') {  $("#itemno").focus(); $("#itemno").select(); };
          if (postid=='price') {  $("#price").focus(); $("#price").select();};
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

