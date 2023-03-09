<div class="col-md-12 mx-0" >
  <select   wire:model="SalId" id="SalId_L" class="SalId_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($SalIdList as $s)
      <option value="{{ $s->id }}">{{ $s->Name }}</option>
    @endforeach
  </select>
</div>