<div class="col-md-12" >
  <select   wire:model="TypeNo" id="Pay_L" class="Pay_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($PayList as $s)
      <option value="{{ $s->type_no }}">{{ $s->type_name }}</option>
    @endforeach
  </select>
</div>
