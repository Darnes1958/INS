
<div class=" gy-1 my-1" style="border:1px solid lightgray;background: white;">
    <table class="table my-0 table-sm table-success table-bordered table-striped table-light "  id="mytable1" >

        <thead class="thead-dark font-size-12">
        <tr>
            <th width="5%">ت</th>
            <th width="25%">ت.الاستحقاق</th>
            <th width="25">ت.الخصم</th>
            <th width="12%">القسط</th>
            <th width="12%">الخصم</th>
            <th width="21%">طريقة الدفع</th>
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
        </tr>
        @endforeach
        </tbody>


    </table>
    {{ $TableList->links('custom-pagination-links-view') }}

</div>




