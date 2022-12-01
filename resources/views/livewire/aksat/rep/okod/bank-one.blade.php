<div>
  <div   class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-5">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.bank-one',])
    </div>
    <div class="col-md-2 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>

  </div>


  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="4%">ت</th>
      <th width="7%">رقم العقد</th>
      <th width="12%">رقم الحساب</th>
      <th width="18%">الاسم</th>
      <th width="7%">تاريخ العقد</th>
      <th width="7%">اجمالي الفاتورة</th>
      <th width="7%">دفعة مقدما</th>
      <th width="7%">اجمالي التقسيط</th>
      <th width="7%">عدد الاقساط</th>
      <th width="7%">القسط</th>
      <th width="7%">المسدد</th>
      <th width="7">المطلوب</th>

    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )

      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td > {{ $key+1 }} </td>
          <td > {{ $item->no }} </td>
          <td> {{ $item->acc }} </td>
          <td> {{ $item->name }} </td>
          <td> {{ $item->sul_date }} </td>
          <td> {{ $item->sul_tot }} </td>
          <td> {{ $item->dofa }} </td>
          <td> {{ $item->sul }} </td>
          <td> {{ $item->kst_count }} </td>
          <td> {{ $item->kst }} </td>
          <td> {{ $item->sul_pay }} </td>
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

