<div class="col-md-12" >

  <select   wire:model="DetailNo" id="Detail_L" class="Detail_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($TableList as  $s)
      <option value="{{ $s->DetailNo }}">{{ $s->DetailName }} </option>
    @endforeach
  </select>
</div>