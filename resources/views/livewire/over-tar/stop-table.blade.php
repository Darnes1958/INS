<div class="row">
  <div class="col-md-5 my-1">
    <table class="table table-sm table-bordered table-striped table-light "   id="mytable3" >
        <thead class="font-size-12">
        <tr>
            <th width="13%">الرقم الألي</th>
            <th width="13%">رقم العقد</th>
            <th width="13%">التاريخ</th>
            <th width="5%"></th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($TableList as  $item)
            <tr class="font-size-12">
                <td>{{$item->rec_no}}</td>
                <td>{{$item->no}}</td>
                <td>{{$item->stop_date}}</td>
                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                    <i wire:click="selectItem({{ $item->rec_no }},'delete')"
                       class="btn btn-outline-danger btn-sm fa fa-times "></i>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $TableList->links() }}
</div>

    <div class="col-md-6 my-1">
        <div class=" d-inline-flex ">
            <label for="baky" class="form-label mx-0 text-right " style="width: 30%; ">الباقي</label>
            <input wire:model="baky" class="form-control mx-0 text-center" type="number"  min="-10" max="50"  id="baky" style="width: 70%; ">
        </div>
    <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
        <thead class="font-size-12">
        <tr>

            <th width="20%">رقم العقد</th>
            <th >الاسم</th>
            <th width="10%"></th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($TableList2 as  $item)
            <tr class="font-size-12">
                <td>{{$item->no}}</td>
                <td>{{$item->name}}</td>
                <td><input class="form-check-input" type="checkbox" wire:model="mychecked.{{$item->no}}"
                           value="1" id="flexCheckDefault"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
        {{ $TableList2->links() }}
        <div class="my-3 align-center justify-content-center "  style="display: flex">
            <input x-bind:disabled="!$wire.OpenDetail" type="button"  id="SaveBtn"
                   class=" btn btn-outline-success  waves-effect waves-light   "
                   wire:click.prevent="SaveStops"   value="ايقاق الخصم" />
        </div>
    </div>




    <div class="modal fade" id="ModalMyDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                    <button wire:click="CloseDeleteDialog" type="button" class="close"  >
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>هل أنت متأكد من الإلغاء ?</h5>
                </div>
                <div class="modal-footer">
                    <button  wire:click="CloseDeleteDialog" type="button" class="btn btn-secondary close-btn" >تراجع</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">نعم متأكد</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('OpenMyDelete', event => {
            $("#ModalMyDelete").modal('show');
        })
        window.addEventListener('CloseMyDelete', event => {
            $("#ModalMyDelete").modal('hide');
        })
    </script>
@endpush
