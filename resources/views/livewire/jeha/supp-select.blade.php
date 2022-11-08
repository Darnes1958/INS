<div class="col-md-12" >
  <select   wire:model="SuppNo" id="Supp_L" class="Supp_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($SuppList as $s)
      <option value="{{ $s->jeha_no }}">{{ $s->jeha_name }}</option>
    @endforeach
  </select>
</div>
