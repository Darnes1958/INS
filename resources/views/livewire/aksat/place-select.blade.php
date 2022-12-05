<div class="col-md-12" >
  <select   wire:model="PlaceNo" id="Place_L" class="Place_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($PlaceList as $s)
      <option value="{{ $s->place_no }}">{{ $s->place_name }}</option>
    @endforeach
  </select>
</div>