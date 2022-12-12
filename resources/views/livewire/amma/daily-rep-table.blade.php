<div>
    @if ($TableName=='buys_view' || $TableName=='sells_view')
      <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
          <th width="16%">رقم الفاتورة</th>
          <th width="18%">العميل</th>
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
        @if ($TableName=='tran_view' )
            <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
                <thead class="font-size-12">
                <tr>
                    <th width="16%">رقم الإيصال</th>
                    <th width="26%">العميل</th>
                    <th width="16%">صادرة / واردة</th>
                    <th width="16%">طريقة الدفع</th>
                    <th width="10%">نوع الإيصال</th>
                    <th width="8%">المبلغ</th>
                </tr>
                </thead>
                <tbody id="addRow" class="addRow">
                @foreach($TableList as $item)
                    <tr class="font-size-12">
                        <td > {{ $item->tran_no }} </td>
                        <td > {{ $item->jeha_name }} </td>
                        <td> {{ $item->imp_exp_name }} </td>
                        <td> {{ $item->type_name }} </td>
                        <td> {{ $item->who_name }} </td>
                        <td> {{ $item->val }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if ($TableName=='main_view' )
            <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
                <thead class="font-size-12">
                <tr>
                    <th width="8%">رقم العقد</th>
                    <th width="26%">الإسم</th>
                    <th width="20%">المصرف</th>
                    <th width="12%">رقم الحساب</th>
                    <th width="9%">تاريخ العقد</th>
                    <th width="9%">إجمالي التقسيط</th>
                    <th width="8%">القسط</th>
                    <th width="8%">عدد الأقساط</th>
                </tr>
                </thead>
                <tbody id="addRow" class="addRow">
                @foreach($TableList as $item)
                    <tr class="font-size-12">
                        <td > {{ $item->no }} </td>
                        <td > {{ $item->name }} </td>
                        <td> {{ $item->bank_name }} </td>
                        <td> {{ $item->acc }} </td>
                        <td> {{ $item->sul_date }} </td>
                        <td> {{ $item->sul }} </td>
                        <td> {{ $item->kst }} </td>
                        <td> {{ $item->kst_count }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        {{ $TableList->links() }}

</div>
