<div class="row">
    <div class="col-md-5">
        <div  class="card ">
            <div class="card-header " style="background: #0e8cdb;color: white;">شاشة عرض حركة مرتب لموظف</div>
            <div class="card-body">
                <div  class="d-inline-flex " >
                        <label  class="form-label col-md-4" >من تاريخ</label>
                        <input wire:model="date"
                               class="form-control font-size-12 col-md-4 "   type="date"  id="MasDate" autofocus>
                </div >
                <table class="table table-sm table-bordered table-striped " width="100%"  >
                    <thead class="font-size-12 bg-primary text-white" >
                    <tr >
                        <th width="14%">الرقم الألي</th>
                        <th >الإسم</th>
                        <th width="14%">المرتب</th>
                        <th width="14%">الرصيد</th>
                    </tr>
                    </thead>
                    <tbody id="addRow" class="addRow">
                    @foreach($TableList as  $item)
                        <tr class="font-size-12">
                            <td ><a wire:click="selectItem({{ $item->id }})" href="#">{{ $item->id }}</a> </td>
                            <td ><a wire:click="selectItem({{ $item->id }})" href="#">{{ $item->Name }}</a> </td>
                            <td>{{$item->Sal}}</td>
                            <td>{{$item->raseed}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $TableList->links() }}
            </div>

        </div>
    </div>
    <div class="col-md-7">
        <div class="card ">

            <div class="card-body">
                <table class="table table-sm table-bordered table-striped " width="100%"  >
                    <thead class="font-size-12 bg-primary text-white" >
                    <tr >
                        <th width="26%">التاريخ</th>

                        <th width="16%">المبلغ</th>
                        <th width="16%">البيان</th>
                        <th >ملاحظات</th>

                    </tr>
                    </thead>
                    <tbody id="addRow" class="addRow">
                    @foreach($TableDetail as  $item)
                        <tr class="font-size-12">
                            <td>{{$item->TranDate}}</td>
                            <td>{{$item->Val}}</td>
                            <td>{{$item->TypeName}}</td>
                            <td>{{$item->Notes}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $TableDetail->links() }}
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
        $(document).ready(function ()
        {
            $('#SalId_L').select2({
                closeOnSelect: true
            });
            $('#SalId_L').on('change', function (e) {
                var data = $('#SalId_L').select2("val");

            @this.set('SalaryId', data);
            @this.set('TheSalIdListIsSelected', 1);
            });
        });
        window.livewire.on('salid-change-event',()=>{
            $('#SalId_L').select2({
                closeOnSelect: true
            });
        });
    </script>
@endpush
