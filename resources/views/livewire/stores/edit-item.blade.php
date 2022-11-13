<div class="col-md-10 col-lg-12">

  <form >
    <div class="row g-3">
      <div class="col-md-4">
        <label for="itemno" class="form-label">رقم الصنف</label>
        <input wire:model="item_no" type="text" class="form-control" id="itemno" placeholder="" readonly >

      </div>
      <div class="col-md-8">
        <label for="edititemname" class="form-label">اسم الصنف</label>
        <input wire:model="item_name"  wire:keydown.enter="$emit('gotonext','edititemtype')" type="text" class="form-control"
               id="edititemname" placeholder="ادخال اسم الصنف" >
        @error('item_name') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="col-md-4">
        <label for="itemtype" class="form-label">نوع الصنف</label>
        <input wire:model="item_type"  wire:keydown.enter="$emit('gotonext','pricebuy')"  type="text" class="form-control" id="edititemtype" placeholder="النوع" >
        @error('item_type') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-8">
        <label  class="form-label"> .  </label>
        <div class="row g-2 ">
          <div class="col-md-10" >
            <select  wire:model="item_type" name="item_type_l" id="item_type_l" class="form-control  form-select "
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
        <label for="pricebuy" class="form-label">سعر الشراء</label>
        <input wire:model="price_buy"  wire:keydown.enter="$emit('gotonext','pricesell')"  type="text" class="form-control" id="pricebuy" placeholder="" >
        @error('price_buy') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-6">
        <label for="pricesell" class="form-label">سعر البيع</label>
        <input wire:model="price_sell" wire:keydown.enter="$emit('gotonext','edit-save-item')"  type="text" class="form-control" id="pricesell" placeholder="" >
        @error('price_sell') <span class="error">{{ $message }}</span> @enderror
      </div>

    </div>
    <br>

    <input type="button"  id="edit-save-item"
           class="w-100 btn btn-outline-success  waves-effect waves-light   "
           wire:click.prevent="EditSaveItem"  wire:keydown.enter="EditSaveItem" value="موافق" />
    <br>
  </form>
</div>

@push('scripts')
  <script type="text/javascript">


      Livewire.on('gotonext',postid=>  {

          if (postid=='itemno') {  $("#item_no").focus(); $("#item_no").select();};
          if (postid=='edititemname') {  $("#edititemname").focus(); $("#edititemname").select();};
          if (postid=='edititemtype') { $("#edititemtype").focus();  $("#edititemtype").select(); };
          if (postid=='pricebuy') {  $("#pricebuy").focus(); $("#pricebuy").select();};
          if (postid=='pricesell') {  $("#pricesell").focus(); $("#pricesell").select(); };
          if (postid=='edit-save-item') { setTimeout(function() { document.getElementById('edit-save-item').focus(); },100);};

      })

  </script>
@endpush
