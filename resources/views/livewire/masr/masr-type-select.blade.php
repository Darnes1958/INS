<div class="col-md-12" >

  <select   wire:model="MasTypeNo" id="MasType_L" class="MasType_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($TableList as  $s)
      <option value="{{ $s->MasTypeNo }}">{{ $s->MasTypeName }} </option>
    @endforeach
  </select>
</div>