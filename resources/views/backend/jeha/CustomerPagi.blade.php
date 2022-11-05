<a href="{{route('customer.add')}}" class="btn btn-dark waves-effect waves-light" style="float:right; margin-left: 20px;">اضافة</a>

{{$jeharep->links("pagination::bootstrap-5")}}
<table id="datatable" class="table table-bordered dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; line-height: .3; width: 100%;">
    <thead>
    <tr>
        <th>تسلسل</th>
        <th>رقم الزبون</th>
        <th>اسم الزبون</th>
        <th>العنوان</th>
        <th>لبيانا</th>
        <th>مدار</th>
        <th>اخر</th>

    </thead>


    <tbody >

    @foreach($jeharep as $key => $item)
        <tr>
            <td> {{ $key+1}} </td>
            <td> {{ $item->jeha_no }} </td>
            <td> {{ $item->jeha_name }} </td>
            <td> {{ $item->address }} </td>
            <td> {{ $item->libyana }} </td>
            <td> {{ $item->mdar }} </td>
            <td> {{ $item->others }} </td>

            <td style="padding-top: 2px;padding-bottom: 2px; ">
                <a href="{{route('customer.edit',$item->jeha_no)}}" class="btn btn-info " style ="height: 22px;width: 22px;
                                                padding: 1px;"  title="Edit Data">  <i class="fas fa-edit"></i> </a>

                <a href="{{route('customer.delete',$item->jeha_no)}}" class="btn btn-danger " style ="height: 22px;width: 22px;padding: 1px;" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

            </td>

        </tr>

    @endforeach

    </tbody>
</table>

