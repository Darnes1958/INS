<div class="col-md-12 mx-0" >
  <select   wire:model="UserNo" id="User_L" class="User_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($UserList as $s)
      <option value="{{ $s->id }}">{{ $s->name }}</option>
    @endforeach
  </select>
</div>
