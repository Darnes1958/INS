<div class="col-md-12 mx-0" >
  <select   wire:model="PlaceNo1" id="Place_L1" class="Place_L1" >
    <option value="">اختيار من القائمة</option>
    @foreach($PlaceList1 as $s)
      <option value="{{ $s->place_no }}">{{ $s->place_name }}</option>
    @endforeach
  </select>
</div>