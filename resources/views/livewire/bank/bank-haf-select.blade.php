<div class="col-md-12" >
  <select   wire:model="BankHafNo" id="Bank_L_H" class="Bank_L_H" >
    <option value="">اختيار من القائمة</option>
    @foreach($BankHafList as $s)
      <option value="{{ $s->bank }}">{{ $s->bank_name }}</option>
    @endforeach
  </select>
</div>
