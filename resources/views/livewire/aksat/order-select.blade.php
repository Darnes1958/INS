<div class="col-md-12" >
  <select   wire:model="OrderNo" id="Order_L" class="Order_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($OrderList as $s)
      <option value="{{ $s->order_no }}">{{ $s->jeha_name }}</option>
    @endforeach
  </select>
</div>