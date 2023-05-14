<div class="row">
    <div class="col-md-4">
        <div  class="card ">
            <div class="card-header " style="background: #0e8cdb;color: white;">شاشة عرض المرتبات</div>
            <div class="card-body">
                <div class="d-inline-flex  ">

                    <label  class="form-label-me mx-1" >السنة</label>
                    <input wire:model="Y" class="form-control mx-1 text-center" type="number"    id="year"   >


                </div>
                <table class="table table-sm table-bordered table-striped " width="100%"  >
                    <thead class="font-size-12 bg-primary text-white" >
                    <tr >
                        <th width="20%">الشهر</th>
                        <th width="20%">اجمالي المرتبات</th>
                        <th width="20%">الاضافات</th>
                        <th width="20%">الخصومات</th>
                        <th width="20%">السحوبات</th>
                    </tr>
                    </thead>
                    <tbody id="addRow" class="addRow">
                    @foreach($TableList as  $item)
                        <tr class="font-size-12">
                            <td ><a wire:click="selectItem({{ $item->M }})" href="#">{{ $item->M }}</a> </td>
                            <td ><a wire:click="selectItem({{ $item->M }})" href="#">{{ $item->sal }}</a> </td>
                            <td ><a wire:click="selectItem({{ $item->M }})" href="#">{{ $item->idafa }}</a> </td>
                            <td ><a wire:click="selectItem({{ $item->M }})" href="#">{{ $item->ksm }}</a> </td>
                            <td ><a wire:click="selectItem({{ $item->M }})" href="#">{{ $item->saheb }}</a> </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <div class="col-md-8">
        <div class="card ">

            <div class="card-body">
                <table class="table table-sm table-bordered table-striped " width="100%"  >
                    <caption class="caption-top text-center text-pink font-size-16">مرتبات شهر {{$M}}</caption>
                    <thead class="font-size-12 bg-primary text-white" >
                    <tr >
                        <th width="14%">الرقم الألي</th>
                        <th >الإسم</th>
                        <th width="14%">المرتب</th>
                        <th width="14%">الاضافة</th>
                        <th width="14%">الخصم</th>

                    </tr>
                    </thead>
                    <tbody id="addRow" class="addRow">
                    @foreach($TableDetail as  $item)
                        <tr class="font-size-12">
                            <td >{{ $item->id }} </td>
                            <td >{{ $item->Name }} </td>
                            <td>{{$item->Sal}}</td>
                            <td>{{$item->idafa}}</td>
                            <td>{{$item->ksm}}</td>
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

    </script>
@endpush
