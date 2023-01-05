<div class="col-md-12" >

  <select   wire:model="CenterNo" id="Center_L" class="Center_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($TableList as  $s)
      <option value="{{ $s->CenterNo }}">{{ $s->CenterName }} </option>
    @endforeach
  </select>
</div>
