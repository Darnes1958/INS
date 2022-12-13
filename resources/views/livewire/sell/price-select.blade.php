<div class="col-md-12" >

  <select   wire:model="type_no" id="Price_L" class="Price_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($PriceList as  $s)
      <option value="{{ $s->type_no }}">{{ $s->type_name }}</option>
    @endforeach
  </select>
</div>

