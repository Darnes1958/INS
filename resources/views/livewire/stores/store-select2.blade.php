<div class="col-md-12 mx-0" >
  <select   wire:model="PlaceNo2" id="Place_L2" class="Place_L2" >
    <option value="">اختيار من القائمة</option>
    @foreach($PlaceList2 as $s)
      <option value="{{ $s->place_no }}">{{ $s->place_name }}</option>
    @endforeach
  </select>
</div>