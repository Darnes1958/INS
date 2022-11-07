<div class="col-md-10" >
  <select   wire:model="jehal" id="jeha_l" class="jeha_l" >
    <option value="">اختيار من القائمة</option>
    @foreach($supplist as $s)
      <option value="{{ $s->jeha_no }}">{{ $s->jeha_name }}</option>
    @endforeach
  </select>
</div>
