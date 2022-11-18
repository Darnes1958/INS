<div class="col-md-12" >

  <select   wire:model="ItemNo" id="Item_L" class="Item_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($ItemList as  $s)
      <option value="{{ $s->item_no }}">{{ $s->item_name }}</option>
    @endforeach
  </select>
</div>
