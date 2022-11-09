<div class="col-md-12" >
  <select   wire:model="BankNo" id="Bank_L" class="Bank_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($BankList as $s)
      <option value="{{ $s->bank_no }}">{{ $s->bank_name }}</option>
    @endforeach
  </select>
</div>
