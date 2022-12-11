<div class="col-md-12" >

  <select   wire:model="BuyList" id="Buy_L" class="Buy_L" >
    <option value="">اختيار من القائمة</option>
    @foreach($OrderList as  $s)
      <option value="{{ $s->order_no }}">{{ $s->jeha_name }} | {{ $s->order_date }} |  {{ $s->tot }}</option>
    @endforeach
  </select>
</div>
