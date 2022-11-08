<div class="col-md-10 col-lg-12">

    <form >
        <div class="row g-3">
            <div class="col-md-4">
                <label for="item_no" class="form-label">رقم الصنف</label>
                <input wire:model="item_no"  wire:keydown.enter="$emit('gotonext','item_name')"  type="text" class="form-control" id="item_no" placeholder="" value="" >
                @error('item_no') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-8">
                <label for="item_name" class="form-label">اسم الصنف</label>
                <input wire:model="item_name"  wire:keydown.enter="$emit('gotonext','itemtype')" type="text" class="form-control" id="item_name" placeholder="ادخال اسم الصنف" >
                @error('item_name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4">
                <label for="item_type" class="form-label">نوع الصنف</label>
                <input wire:model="itemtype"  wire:keydown.enter="$emit('gotonext','price_buy')"  type="text" class="form-control" id="item_type" placeholder="النوع" >
                @error('itemtype') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-8">
                <label  class="form-label"> .  </label>
                <div class="row g-2 ">
                   <div class="col-md-10" >
                     <select  wire:model="itemtypel" name="item_type_l" id="item_type_l" class="form-control  form-select "
                         style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"  >
                       <option value="">اختيار من القائمة</option>
                      @foreach($item_types as $s)
                        <option value="{{ $s->type_no }}">{{ $s->type_name }}</option>
                      @endforeach
                     </select>
                   </div>
                    <div class="col-md-2" >
                        <button type="button" class="btn btn-outline-primary btn-sm fa fa-plus"
                                wire:click="OpenSecond"></button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label for="price_buy" class="form-label">سعر الشراء</label>
                <input wire:model="price_buy"  wire:keydown.enter="$emit('gotonext','price_sell')"  type="text" class="form-control" id="price_buy" placeholder="" >
                @error('price_buy') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="price_sell" class="form-label">سعر البيع</label>
                <input wire:model="price_sell" wire:keydown.enter="$emit('gotonext','save-item')"  type="text" class="form-control" id="price_sell" placeholder="" >
                @error('price_sell') <span class="error">{{ $message }}</span> @enderror
            </div>

        </div>
        <br>

        <input type="button"  id="save-item"
               class="w-100 btn btn-outline-success  waves-effect waves-light   "
               wire:click.prevent="SaveItem"  wire:keydown.enter="SaveItem" value="موافق" />
        <br>
    </form>
</div>

@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {

            if (postid=='item_no') {  $("#item_no").focus(); $("#item_no").select();};
            if (postid=='item_name') {  $("#item_name").focus(); $("#item_name").select();};
            if (postid=='itemtype') {  $("#item_type").focus(); $("#item_type").select();};
            if (postid=='price_buy') {  $("#price_buy").focus(); $("#price_buy").select();};
            if (postid=='price_sell') {  $("#price_sell").focus(); $("#price_sell").select(); };
            if (postid=='save-item') { setTimeout(function() { document.getElementById('save-item').focus(); },100);};

        })

    </script>
@endpush
