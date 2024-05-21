<div class="col-md-12" >

  <select   wire:model="ItemListNo2" id="Item_L2" class="Item_L2" >
    <option value="">اختيار من القائمة</option>
    @foreach($ItemList as  $s)
      <option value="{{ $s->item_no }}">{{ $s->item_name }}</option>
    @endforeach
  </select>
</div>
