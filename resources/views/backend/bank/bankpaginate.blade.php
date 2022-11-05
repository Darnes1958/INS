<table id="gridtable"  class="table table-bordered dt-responsive nowrap font-size-12
           table-striped d-sm-table-row"
       style="border-collapse: collapse; border-spacing: 0;
       line-height: .3; width: 100%; ">
    <thead>
    <tr>
        <th>تسلسل</th>
        <th>رقم العقد</th>
        <th>اسم الزبون</th>
        <th>رقم الحساب</th>
        <th>تاريخ العقد</th>
        <th>اجمالي العقد</th>
        <th>عدد الأقساط</th>
        <th>القسط</th>
        <th>المسدد</th>
        <th>المتبقي</th>
    </thead>

    <tbody >

    @foreach($datatable as $key => $item)
        <tr >
            <td > {{ $key+1}} </td>
            <td> {{ $item->no }} </td>
            <td> {{ $item->name }} </td>
            <td> {{ $item->acc }} </td>
            <td> {{ $item->sul_date }} </td>
            <td> {{ $item->sul }} </td>
            <td> {{ $item->kst_count }} </td>
            <td> {{ $item->kst }} </td>
            <td> {{ $item->sul_pay }} </td>
            <td> {{ $item->raseed }} </td>
        </tr>

    @endforeach

    </tbody>
</table>

        {!! $datatable->links() !!}
