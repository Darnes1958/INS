<div class="col-md-12 mx-0" >
  <select   wire:model="TypeNo" id="Type_L" class="Type_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($TypeList as $s)
      <option value="{{ $s->type_no }}">{{ $s->type_name }}</option>
    @endforeach
  </select>
</div>
