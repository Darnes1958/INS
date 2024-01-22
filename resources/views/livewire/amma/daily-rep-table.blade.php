<div>
    @if ($TableName=='tar_buy_view' )
        <table class="table table-striped table-bordered table-sm">
            <thead class="font-size-12">
            <tr>
                <th width="12%">رقم الفاتورة</th>
                <th width="10%">الرقم الألي</th>

                <th width="10%">رقم الصنف</th>
                <th >اسم الصنف</th>
                <th width="8%">الكمية</th>
                <th width="10%">السعر</th>
                <th width="12%">المجموع</th>


            </tr>
            </thead>
            <tbody id="addRow" class="addRow">
            @foreach($TableList as  $item)
                <tr class="font-size-12">
                    <td>{{$item->order_no}}</td>
                    <td>{{$item->id}}</td>

                    <td>{{$item->item_no}}</td>
                    <td>{{$item->item_name}}</td>
                    <td>{{$item->quant}}</td>
                    <td>{{$item->price_input}}</td>
                    <td>{{$item->sub_tot}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
  @if ($TableName=='store_exp_view' )
    <table class="table table-striped table-bordered table-sm">
      <thead class="font-size-12">
      <tr>
        <th style="width: 10%">رقم إذن الاستلام</th>
        <th style="width: 16%">مــــــــن</th>
        <th style="width: 16%">إلــــــــي</th>
        <th style="width: 10%">رقم الصنف</th>
        <th >اسم الصنف</th>
        <th style="width: 8%">الكمية</th>
        <th style="width: 20%">بواسطة</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TableList as $key=> $item)
        <tr class="font-size-12">
          <td> {{ $item->per_no }} </td>
          <td> {{$item->st_name }} </td>
          <td> {{$item->place_name }} </td>
          <td> {{$item->item_no }} </td>
          <td> {{$item->item_name }} </td>
          <td> {{$item->quant }} </td>
          <td> {{$item->emp_name }} </td>
        </tr>
      @endforeach
      </tbody>
    </table>

  @endif
    @if ($TableName=='buys_view' || $TableName=='sells_view')
      <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
          @if ($TableName=='sells_view')
          <th width="16%">نقطة البيع</th>
          @endif
          <th width="12%">رقم الفاتورة</th>
          <th >العميل</th>
          <th width="12%">التاريخ</th>
          <th width="10%">الاجمالي</th>
          <th width="10%">المدفوع</th>
          <th width="8%">الأجل</th>
          <th width="10%">بواسطة</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($TableList as $item)
          <tr class="font-size-12">
            @if ($TableName=='sells_view')
            <td > {{ $item->place_name }} </td>
            @endif
            <td > {{ $item->order_no }} </td>
            <td > {{ $item->jeha_name }} </td>
            <td> {{ $item->order_date }} </td>
            <td> {{ $item->tot }} </td>
            <td> {{ $item->cash }} </td>
            <td> {{ $item->not_cash }} </td>
            <td> {{ $item->emp_name }} </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    @endif
      @if ($TableName=='rep_sell_tran' )
        <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
          <thead class="font-size-12">
          <tr>

            <th width="12%">نقطة البيع</th>

            <th width="8%">رقم الفاتورة</th>
            <th width="8%">رقم الصنف</th>
            <th >اسم الصنف</th>
            <th width="8%">الكمية</th>
            @can('سعر الشراء')
            <th width="8%">سعر الشراء</th>
            @endcan
              @can('سعر الشراء')
            <th width="8%">سعر التكلفة</th>
            @endcan()
            <th width="8%">سعر البيع</th>
            <th width="8%">الإجمالي</th>
              @role('admin')
            <th width="8%">الربح</th>
              @endrole


          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($TableList as $item)
            <tr class="font-size-12">

              <td > {{ $item->place_name }} </td>

              <td > {{ $item->order_no }} </td>
              <td > {{ $item->item_no }} </td>
              <td > {{ $item->item_name }} </td>
              <td> {{ $item->quant }} </td>
              @can('سعر الشراء')
              <td> {{ $item->price_buy }} </td>
              @endcan
                @can('سعر الشراء')
              <td> {{ $item->price_cost }} </td>
                @endcan
              <td> {{ $item->price }} </td>
              <td> {{ $item->sub_tot }} </td>
                @role('admin')
              <td> {{ $item->rebh }} </td>
                @endrole
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
                    <th >العميل</th>
                    <th width="16%">صادرة / واردة</th>
                    <th width="16%">طريقة الدفع</th>
                    <th width="10%">نوع الإيصال</th>
                    <th width="8%">المبلغ</th>
                  <th width="10%">بواسطة</th>
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
                      <td> {{ $item->emp_name }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

      @if ($TableName=='Aksat' )
        <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
          <thead class="font-size-12">
          <tr>
            <th width="8%">رقم العقد</th>
            <th >الإسم</th>
            <th width="18%">المصرف</th>
            <th width="12%">رقم الحساب</th>
            <th width="9%">تاريخ الخصم</th>
            <th width="9%">القسط المخصوم</th>
            <th width="8%">طريقة الدفع</th>

            <th width="10%">بواسطة</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($TableList as $item)
            <tr class="font-size-12">
              <td > {{ $item->no }} </td>
              <td > {{ $item->name }} </td>
              <td> {{ $item->bank_name }} </td>
              <td> {{ $item->acc }} </td>
              <td> {{ $item->ksm_date }} </td>
              <td> {{ $item->ksm }} </td>
              <td> {{ $item->ksm_type_name }} </td>
              <td> {{ $item->emp_name }} </td>

            </tr>
          @endforeach
          </tbody>
        </table>
      @endif

      @if ($TableName=='over_view' )
        <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
          <thead class="font-size-12">
          <tr>
            <th width="8%">رقم العقد</th>
            <th >الإسم</th>
            <th width="20%">المصرف</th>
            <th width="12%">رقم الحساب</th>
            <th width="9%">التاريخ</th>
            <th width="9%">المبلغ</th>
            <th width="10%">بواسطة</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($TableList as $item)
            <tr class="font-size-12">
              <td > {{ $item->no }} </td>
              <td > {{ $item->name }} </td>
              <td> {{ $item->bank_name }} </td>
              <td> {{ $item->acc }} </td>
              <td> {{ $item->tar_date }} </td>
              <td> {{ $item->kst }} </td>
              <td> {{ $item->emp_name }} </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      @endif
      @if ($TableName=='tar_view' )
        <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
          <thead class="font-size-12">
          <tr>
            <th width="8%">رقم العقد</th>
            <th >الإسم</th>
            <th width="20%">المصرف</th>
            <th width="12%">رقم الحساب</th>
            <th width="9%">التاريخ</th>
            <th width="9%">المبلغ</th>
            <th width="14%">طريقة الدفع</th>
            <th width="10%">بواسطة</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($TableList as $item)
            <tr class="font-size-12">
              <td > {{ $item->no }} </td>
              <td > {{ $item->name }} </td>
              <td> {{ $item->bank_name }} </td>
              <td> {{ $item->acc }} </td>
              <td> {{ $item->tar_date }} </td>
              <td> {{ $item->kst }} </td>
              <td> {{ $item->ksm_type_name }} </td>
              <td> {{ $item->emp_name }} </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      @endif
      @if ($TableName=='wrong_view' )
        <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
          <thead class="font-size-12">
          <tr>
            <th width="8%">الرقم الألي</th>
            <th >الإسم</th>
            <th width="20%">المصرف</th>
            <th width="12%">رقم الحساب</th>
            <th width="9%">التاريخ</th>
            <th width="9%">المبلغ</th>
            <th width="10%">بواسطة</th>
          </tr>
          </thead>
          <tbody id="addRow" class="addRow">
          @foreach($TableList as $item)
            <tr class="font-size-12">
              <td > {{ $item->wrong_no }} </td>
              <td > {{ $item->name }} </td>
              <td> {{ $item->bank_name }} </td>
              <td> {{ $item->acc }} </td>
              <td> {{ $item->tar_date }} </td>
              <td> {{ $item->kst }} </td>
              <td> {{ $item->emp_name }} </td>
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
                    <th >الإسم</th>
                    <th width="20%">المصرف</th>
                    <th width="12%">رقم الحساب</th>
                    <th width="9%">تاريخ العقد</th>
                    <th width="9%">إجمالي التقسيط</th>
                    <th width="8%">القسط</th>
                    <th width="8%">عدد الأقساط</th>
                    <th width="8%">بواسطة</th>
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
                        <td> {{ $item->emp_name }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        {{ $TableList->links() }}

</div>
