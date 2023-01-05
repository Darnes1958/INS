<div class="col-md-12" >

  <select   wire:model="PerNo" id="Per_L" class="Per_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($PerList as  $s)
      <option value="{{ $s->per_no }}">{{ $s->st_name }} | {{ $s->exp_date }} |  </option>
    @endforeach
  </select>
</div>