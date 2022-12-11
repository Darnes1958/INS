<div>
    @if ($TableName=='buys_view')
      <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
          <th width="16%">رقم الفاتورة</th>
          <th width="18%">الجهة الموردة</th>
          <th width="26%">التاريخ</th>
          <th width="10%">الاجمالي</th>
          <th width="10%">المدفوع</th>
          <th width="8%">الأجل</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($TableList as $item)
          <tr class="font-size-12">
            <td > {{ $item->order_no }} </td>
            <td > {{ $item->jeha_name }} </td>
            <td> {{ $item->order_date }} </td>
            <td> {{ $item->tot }} </td>
            <td> {{ $item->cash }} </td>
            <td> {{ $item->not_cash }} </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    @endif
</div>
