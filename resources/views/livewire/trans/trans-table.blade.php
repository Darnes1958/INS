<div >
    <div class="d-flex justify-content-sm-between  my-1"> <input wire:model="search"   type="search"  style="width: 100%" placeholder="ابحث هنا ......."> </div>
    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
            <th>الرقم الألي</th>
            <th>التاريخ</th>
            <th>المبلغ</th>
            <th>ملاحظات</th>
            <th></th>
            <th></th>

        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($TableList as  $item)
            <tr class="font-size-12">
                <td>{{$item->tran_no}}</td>
                <td>{{$item->tran_date}}</td>
                <td>{{$item->val}}</td>
                <td>{{$item->notes}}</td>
                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                    <i wire:click="selectItem({{ $item->tran_no }},'update')"
                       class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
                </td>
                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                    <i wire:click="selectItem({{ $item->tran_no }},'delete')"
                       class="btn btn-outline-danger btn-sm fa fa-times "></i>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $TableList->links() }}


</div>
