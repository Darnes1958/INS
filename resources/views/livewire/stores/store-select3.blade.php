<div class="col-md-12 mx-0" >
  <select   wire:model="PlaceNo3" id="Place_L3" class="Place_L3" >
    <option value="">اختيار من القائمة</option>
    @foreach($PlaceList3 as $s)
      <option value="{{ $s->place_no }}">{{ $s->place_name }}</option>
    @endforeach
  </select>
</div>