
<div x-data class="row">
  <div class="col-4">
    <div class="card">
      <div class="card-header" style="background: #0e8cdb;color: white">شاشة تعديل أسعار البيع لصنف</div>
        <div class="card-body">
          <div class="row my-2">
            <div class="col-md-12 mb-2"   >
               @livewire('stores.item-select')
            </div>

            <div class="col-md-12" >
                <label  for="item_no" class="form-label ">رقم الصنف</label>
                <input wire:model="item_no"  wire:keydown.enter="ChkItemAndGo"
                       type="number" class="form-control"  id="item_no"  >
                @error('item_no') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-12 ">
                <label for="price_nakdy" class="form-label " >سعر البيع نقداً</label>
                <input wire:model="price_nakdy" wire:keydown.enter="$emit('gotonext','price_tak')"  x-bind:disabled="!$wire.ItemGeted"
                       class="form-control "  type="number"
                       id="price_nakdy"   >
                @error('price_nakdy') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 ">
                <label for="price_tak" class="form-label-me">سعر البيع تقسيط</label>
                <input wire:model="price_tak" wire:keydown.enter="$emit('gotonext','btn-save')"  x-bind:disabled="!$wire.ItemGeted"
                       class="form-control "  type="number"
                       id="price_tak"   >
                @error('price_tak') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="my-3 align-center justify-content-center "  style="display: flex">
                <input type="button"  id="btn-save"
                       class=" btn btn-outline-success  waves-effect waves-light   "
                       wire:click.prevent="Save"   value="موافق" />
            </div>
          </div>
        </div>
    </div>
  </div>

</div>


@push('scripts')
    <script type="text/javascript">


        Livewire.on('gotonext',postid=>  {

            if (postid=='price_nakdy') {  $("#price_nakdy").focus();  $("#price_nakdy").select();};

            if (postid=='item_no') {  $("#item_no").focus(); $("#item_no").select();};
            if (postid=='price_tak') {  $("#price_tak").focus(); $("#price_tak").select();};
            if (postid=='btn-save') {
                setTimeout(function() { document.getElementById('btn-save').focus(); },100);};
        });

        $(document).ready(function ()
        {
            $('#Item_L').select2({
                closeOnSelect: true
            });
            $('#Item_L').on('change', function (e) {
                var data = $('#Item_L').select2("val");
            @this.set('item_no', data);
            @this.set('TheItemIsSelected', 1);
            });
        });
        window.livewire.on('item-change-event',()=>{
            $('#Item_L').select2({
                closeOnSelect: true
            });


        });
    </script>

@endpush


