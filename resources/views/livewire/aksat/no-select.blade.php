<div class="col-md-12" >
  <select  x-bind:disabled="!$wire.NoSelectOpen" wire:model="MainNo" id="Main_L" class="Main_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($MainList as $s)
      <option value="{{ $s->no }}">{{ $s->name }}</option>
    @endforeach
  </select>
</div>