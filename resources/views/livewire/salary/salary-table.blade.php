<div class="card ">

 <div class="card-body">
     <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
         <thead class="font-size-12">
         <tr>
             <th width="12%">الرقم الألي</th>
             <th width="14%">الإسم</th>
             <th width="12%">المرتب</th>
             <th width="25%">محمل علي</th>
             @can('مرتب خاص')
             <th width="5%" style="text-align: center">مرتب خاص</th>
             @endcan
             <th width="5%"></th>
             <th width="5%"></th>

         </tr>
         </thead>
         <tbody id="addRow" class="addRow">
         @foreach($TableList as  $item)
             <tr class="font-size-12">

                 <td>{{$item->id}}</td>
                 <td>{{$item->Name}}</td>
                 <td>{{$item->Sal}}</td>
                 <td>{{$item->CenterName}}</td>
                 @can('مرتب خاص')
                     @if($item->vip==1)
                         <td  style="padding-top: 2px;padding-bottom: 2px; ">
                             <i wire:click="selectItem({{ $item->id }},'notspecial')"
                                class="btn btn-outline-dark btn-sm  fas fa-user-secret editable-input" style="margin-left: 2px;"></i>
                         </td>
                     @else
                         <td  style="padding-top: 2px;padding-bottom: 2px; ">
                             <i wire:click="selectItem({{ $item->id }},'special')"
                                class="btn btn-outline-secondary btn-sm  far fa-user-secret editable-input" style="margin-left: 2px;"></i>
                         </td>
                     @endif
                 @endcan
                 <td  style="padding-top: 2px;padding-bottom: 2px; ">
                     <i wire:click="selectItem({{ $item->id }},'update')"
                        class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
                 </td>
                 <td  style="padding-top: 2px;padding-bottom: 2px; ">
                     <i wire:click="selectItem({{ $item->id }},'delete')"
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




 </div>

    @push('scripts')
        <script>
            window.addEventListener('mmsg',function(e){
                MyMsg.fire({
                    confirmButtonText:  e.detail,
                })
            });
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

