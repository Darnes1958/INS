<div class="col-md-12" >
  <select   wire:model="CustNo" id="Cust_L" class="Cust_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($CustList as $s)
      <option value="{{ $s->jeha_no }}">{{ $s->jeha_name }}</option>
    @endforeach
  </select>

</div>

