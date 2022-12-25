<div x-data x-show="$wire.Show" class="col-md-8">
    <div class="card">
        <div class="card-header">عرض لبيانات الشركات</div>
        <div class="card-body">
            <table class="table-sm table-bordered " width="100%"  id="perlist" >
                <thead>
                <tr>
                    <th width="15%">ت</th>
                    <th width="40%">الاسم</th>
                    <th width="20%"> قاعدة البيانات</th>
                    <th width="15%">الرقم القديم</th>
                </tr>
                </thead>
                <tbody id="addRow" class="addRow">
                @foreach($Tabledata as  $item)
                    <tr>
                        <td > {{ $item->id }} </td>
                        <td > {{ $item->name }} </td>
                        <td> {{ $item->company }} </td>
                        <td> {{ $item->empno }} </td>
                    </tr>
                @endforeach
                </tbody>
                <br>
            </table>

        </div>
    </div>
</div>
