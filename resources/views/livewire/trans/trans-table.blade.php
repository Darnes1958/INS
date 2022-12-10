<div >
    <div class="d-flex justify-content-sm-between  my-1"> <input wire:model="search"   type="search"  style="width: 100%" placeholder="ابحث هنا ......."> </div>
    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>
            <th width="20%">الرقم الألي</th>
            <th width="10%">التاريخ</th>
            <th width="10%">المبلغ</th>
            <th width="50%">ملاحظات</th>
            <th width="5%"></th>
            <th width="5%"></th>

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

    <div class="modal fade" id="ModalMyEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseEditDialog" type="button" class="btn-close" ></button>
                    <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">تعديل إيصال</h1>
                </div>
                <div class="modal-body">
                    @livewire('trans.edit-tran')
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
        window.addEventListener('OpenMyEdit', event => {
            $("#ModalMyEdit").modal('show');
        })
        window.addEventListener('CloseMyEdit', event => {
            $("#ModalMyEdit").modal('hide');
        })


    </script>
@endpush
