<div x-data class="row " style="margin-bottom: 20px;margin-top: 16px;" >
 <div class="col-md-4">
     <div  class="row g-3 " style="border:1px solid lightgray;background: white;">
         <div class="col-md-12" >
             @livewire('buy.buy-select')
         </div>
         <div class="col-md-6">
             <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
             <input wire:model="order_no"  wire:keydown.enter="ChkOrderNoAndGo" type="text" class=" form-control "
                    id="order_no"   autofocus >
             @error('order_no') <span class="error">{{ $message }}</span> @enderror
         </div>
         <div class="col-md-6">
             <label   for="date" class="form-label-me">التاريخ</label>
             <input  wire:model="tar_date" wire:keydown.enter="$emit('gotonext','jehano')"
                     class="form-control  "
                     type="date"  id="tar_date" >
             @error('tar_date') <span class="error">{{ $message }}</span> @enderror
         </div>
         <div class="col-md-12">
             <label  class="form-label-me">اختيار من القائمة</label>
             <select  x-bind:disabled="!$wire.OrderGeted " wire:model="item_no_L"   class="form-control  form-select "
                      style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"  >
                 <option >اختيار</option>
                 @foreach($items as $s)
                     <option value="{{ $s->item_no }}">{{ $s->item_name }}</option>
                 @endforeach
             </select>
         </div>
         <div class="col-md-4" >
             <label  for="itemno" class="form-label-me ">رقم الصنف</label>
             <input wire:model="item_no"
                    type="number" class="form-control"  id="item_no" style="text-align: center;height: 39px;" readonly>
         </div>
         <div class="col-md-8">
             <label  for="item_name" class="form-label-me ">اسم الصنف</label>
             <textarea wire:model="item_name" class="form-control" style="color: #0b5ed7; "
                       readonly id="item_name" ></textarea>
         </div>
         <div class="col-md-4 my-2" >
             <label  for="itemno" class="form-label-me ">الرصيد الكلي</label>
             <input wire:model="raseed"class="form-control" style="color: #0b5ed7; "   readonly>
         </div>
         <div class="col-md-4 my-2">
             <label  for="item_name" class="form-label-me ">رصيد المخزن</label>
             <input wire:model="st_raseed" class="form-control" style="color: #0b5ed7; "  readonly  >
         </div>
         <div class="col-4 my-2">
             <label for="quant" class="form-label-me " >الكمية</label>
             <input wire:model="quant" wire:keydown.enter="store"
                    x-bind:disabled="!$wire.OrderGeted || !$wire.ItemGeted"
                    class="form-control " name="quant" type="text" value="1"
                    id="quant"  style="text-align: center" >
             @error('quant') <span class="error">{{ $message }}</span> @enderror
         </div>
     </div>
 </div>
 <div class="col-md-8">
     <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
         <thead class="font-size-12">
         <tr>
             <th width="10%">الرقم الألي</th>
             <th width="12%">التاريخ</th>
             <th width="10%">رقم الصنف</th>
             <th >اسم الصنف</th>
             <th width="8%">الكمية</th>
             <th width="10%">السعر</th>
             <th width="12%">المجموع</th>
             <th width="5%"></th>
         </tr>
         </thead>
         <tbody id="addRow" class="addRow">
         @foreach($TableList as  $item)
             <tr class="font-size-12">
                 <td>{{$item->id}}</td>
                 <td>{{$item->tar_date}}</td>
                 <td>{{$item->item_no}}</td>
                 <td>{{$item->item_name}}</td>
                 <td>{{$item->quant}}</td>
                 <td>{{$item->price_input}}</td>
                 <td>{{$item->sub_tot}}</td>
                 <td  style="padding-top: 2px;padding-bottom: 2px; ">
                     <i wire:click="selectItem({{ $item->id }},{{$item->item_no}},{{$item->quant}})"
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

</div>
@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {
            if (postid=='order_no') {  $("#order_no").focus();$("#order_no").select(); };
            if (postid=='tar_date') {  $("#tar_date").focus();$("#tar_date").select(); };
            if (postid=='quant') {  $("#quant").focus();$("#quant").select(); };
        });
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
        $(document).ready(function ()
        {
            $('#Buy_L').select2({
                closeOnSelect: true
            });
            $('#Buy_L').on('change', function (e) {
                var data = $('#Buy_L').select2("val");
            @this.set('order_no', data);
            @this.set('TheOrderListSelected',1);
            });
        });
        window.livewire.on('buy-change-event',()=>{
            $('#Order_L').select2({
                closeOnSelect: true
            });
        });
        window.addEventListener('dodelete',function(e){
            MyConfirm.fire({
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('DoDelete');
                }
            })
        });
        window.addEventListener('OpenMyDelete', event => {
            $("#ModalMyDelete").modal('show');
        })
        window.addEventListener('CloseMyDelete', event => {
            $("#ModalMyDelete").modal('hide');
        })
    </script>
@endpush
