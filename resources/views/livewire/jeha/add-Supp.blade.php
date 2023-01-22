<div class="col-md-12 ">
 <div class="row">


    <dev class="col-md-4" >
      <div class="card">
        <div class="card-header" style="background: #0e8cdb;color: white;font-size: 14pt;">ادخال {{$jeha_type_name}}</div>
        <div class="card-body">
            <div class="row mb-3">
             <label for="jeha_name" class="col-sm-6 g-2">اسم الزبون</label>


                 @livewire('jeha.search-jeha',['sender'=>'jeha.add-supp','jeha_type'=>$jeha_type])



            </div>
            <div class="row mb-3">
                <label for="address" class="col-sm-2 g-2">العنوان</label>
                <div  class="col-sm-10 form-group">
                    <input wire:model="address"  wire:keydown.enter="$emit('gotonext','libyana')" id="address" class="form-control" type="text"  >
                    @error('address') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="libyana" class="col-sm-2 g-2">لبيانا</label>
                <div  class="col-sm-10 form-group">
                    <input wire:model="libyana"  wire:keydown.enter="$emit('gotonext','mdar')" id="libyana" class="form-control" type="text"  >
                    @error('libyana') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="mdar" class="col-sm-2 g-2">المدار</label>
                <div  class="col-sm-10 form-group">
                    <input wire:model="mdar"  wire:keydown.enter="$emit('gotonext','others')" id="mdar" class="form-control" type="text"  >
                    @error('mdar') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3 g-2">
                <label for="others" class="col-sm-2">رقم الهوية</label>
                <div  class="col-sm-10 form-group">
                    <input wire:model="others"  wire:keydown.enter="$emit('gotonext','save-supp')" id="others" class="form-control" type="text"  >
                    @error('others') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col text-center">
                <input type="button" id="save-supp"
                       class="w-100 btn btn-primary btn-lg"
                       wire:click.prevent="SaveJeha" wire:keydown.enter="SaveJeha"    value="تخزين بيانات الصنف"/>

            </div>
        </div>
      </div>

    </dev> <!-- end col -->
   <div class="col-md-7">
     <div class="card">
       <div class="card-body">
         <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
           <thead class="font-size-12">
           <tr>
             <th width="10%">رقم الزبون</th>
             <th >اسم الزبون</th>
             <th width="5%"></th>
             <th width="5%"></th>
           </tr>
           </thead>
           <tbody id="addRow" class="addRow">
           @foreach($JehaTable as  $item)
             <tr class="font-size-12">
               <td>{{$item->jeha_no}}</td>
               <td>{{$item->jeha_name}}</td>

               <td  style="padding-top: 2px;padding-bottom: 2px; ">
                 <i wire:click="selectItem({{ $item->jeha_no }},'update')" @click="$focus.focus(search_box)"
                    class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
               </td>
               <td  style="padding-top: 2px;padding-bottom: 2px; ">
                 <i wire:click="selectItem({{ $item->jeha_no }},'delete')"
                    class="btn btn-outline-danger btn-sm fa fa-times "></i>
               </td>
             </tr>
           @endforeach
           </tbody>
         </table>
         {{ $JehaTable->links() }}
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
   </div>
 </div>
</div>

@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {
            if (postid=='jeha_name') {  $("#jeha_name").focus(); $("#jeha_name").select();};
            if (postid=='address') {  $("#address").focus(); $("#address").select();};
            if (postid=='libyana') {  $("#libyana").focus(); $("#libyana").select();};
            if (postid=='mdar') {  $("#mdar").focus(); $("#mdar").select();};
            if (postid=='others') {  $("#others").focus(); $("#others").select();};

            if (postid=='save-supp') {
                setTimeout(function() { document.getElementById('save-supp').focus(); },100);};
        })
        window.addEventListener('OpenMyDelete', event => {
            $("#ModalMyDelete").modal('show');
        })
        window.addEventListener('CloseMyDelete', event => {
            $("#ModalMyDelete").modal('hide');
        })

        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });

    </script>
@endpush
