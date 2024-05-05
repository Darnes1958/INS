
<div class=" gy-1 my-1" style="border:1px solid lightgray;background: white;">
    <table class="table my-0 table-sm table-success table-bordered table-striped table-light "  id="mytable1" >

        <thead class="thead-dark font-size-12">
        <tr>
            <th width="5%">ت</th>
            <th width="16%">ت.الاستحقاق</th>
            <th width="16">ت.الخصم</th>
            <th width="8%">القسط</th>
            <th width="8%">الخصم</th>
            <th width="10%">طريقة الدفع</th>
            <th width="14%">بواسطة</th>
            <th width="24%">ملاحظات</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($TableList as $key=>$item)
        <tr class="font-size-12">
            <td > {{ $item->ser }} </td>
            <td > {{ $item->kst_date }} </td>
            <td> {{ $item->ksm_date }} </td>
            <td> {{ $item->kst }} </td>
            <td> {{ $item->ksm }} </td>
            <td> {{ $item->ksm_type_name }} </td>
            <td> {{ $item->EMP_NAME }} </td>
            <td> {{ $item->kst_notes }} </td>
        </tr>
        @endforeach
        </tbody>


    </table>
    {{ $TableList->links('custom-pagination-links-view') }}

</div>




