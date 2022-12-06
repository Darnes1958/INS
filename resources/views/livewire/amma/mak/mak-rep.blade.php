<div>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >


    <div class="col-md-4 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>
    <div class="col-md-4">
      <div class="form-check form-check-inline">
        <input class="form-check-input" name="repchk" type="checkbox" wire:model="RepChk"  >
        <label class="form-check-label" for="repchk">إضهار الأصناف التي أرصدتها صفر</label>
      </div>

    </div>

  </div>

  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="4%">ت</th>
      <th width="8%">التصنيف</th>
      <th width="12%">رقم الصنف</th>
      <th width="18%">اسم الصنف</th>
      <th width="8%">سعر الشراء نقداً</th>
      <th width="8%">سعر البيع نقداً</th>
      <th width="8%">المخزن / الصالة</th>
      <th width="8%">رصيد المخزن/الصالة</th>
      <th width="8">الرصيد الكلي</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )
      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td > {{ $key+1 }} </td>
          <td > {{ $item->type_name }} </td>
          <td> {{ $item->item_no }} </td>
          <td> {{ $item->item_name }} </td>
          <td> {{ $item->price_buy }} </td>
          <td> {{ $item->price_sell }} </td>
          <td> {{ $item->place_name }} </td>
          <td> {{ $item->place_ras }} </td>
          <td> {{ $item->raseed }} </td>
        </tr>
      @endforeach
    @endif
    </tbody>
  </table>

  @if ($RepTable )
    {{ $RepTable->links('custom-pagination-links-view') }}
  @endif
</div>
@push('scripts')
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>
@endpush


