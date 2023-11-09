<div class="col-md-12" >
  <select   wire:model="Acc" id="Acc_L" class="Acc_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($AccList as $s)
      <option value="{{ $s->acc }}">{{ $s->name }}</option>
    @endforeach
  </select>
</div>
