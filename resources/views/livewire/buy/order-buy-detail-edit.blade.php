
 <div x-data
      class="row g-3 " style="border:1px solid lightgray;background: white;">

      <div class="col-md-12" x-show="$wire.DetailOpen"  >
         <div class="row g-2 ">
           <div class="col-md-11" >
             @livewire('stores.item-select', ['PlaceSelectType' => 'items'])
           </div>
           <div class="col-md-1" >
               <button wire:click="OpenFirst" type="button" class="btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"></button>
           </div>
               <!-- Modal -->
               <div class="modal fade" id="ModalFormOne" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                   <div class="modal-dialog modal-dialog-centered">
                       <div class="modal-content">
                           <div class="modal-header">
                              <button wire:click="CloseFirst" type="button" class="btn-close" ></button>
                               <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال صنف جديد</h1>
                           </div>
                           <div class="modal-body">
                               @livewire('stores.add-item')
                           </div>
                       </div>
                   </div>
               </div>
             <div class="modal fade" id="ModalFormTwo" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                 <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                         <div class="modal-header">
                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                             <h3 class="modal-title fs-5" id="exampleModalToggleLabel2">ادخال النوع الجديد ثم اضغط ENTER</h3>
                         </div>
                         <div class="modal-body">
                             @livewire('stores.add-item-type')
                         </div>
                         <div class="modal-footer">
                             <button wire:click.prevent="CloseSecond" class="btn btn-primary" >رجوع</button>
                         </div>
                     </div>
                 </div>
             </div>

          </div>
      </div>

      <div class="col-md-4" >
             <label  for="itemno" class="form-label-me ">رقم الصنف</label>
             <input wire:model="item"  wire:keydown.enter="ChkItemAndGo"  x-bind:disabled="!$wire.DetailOpen"
                     type="number" class="form-control"  id="itemno" name="itemno" style="text-align: center;height: 39px;">
        </div>
      <div class="col-md-8">
            <label  for="item_name" class="form-label-me ">اسم الصنف</label>
            <textarea wire:model="item_name" class="form-control" style="color: #0b5ed7; "
                       readonly id="item_name" placeholder="اسم الصنف"></textarea>
            @error('item') <span class="error">{{ $message }}</span> @enderror
        </div>
      <div class="col-6 ">
            <label for="quant" class="form-label-me " >الكمية</label>
            <input x-bind:disabled="!$wire.DetailOpen || !$wire.ItemGeted"
                   wire:model="quant" wire:keydown.enter="ChkQuantAndGo"
                   class="form-control " type="number" min="1" oninput="validity.valid||(value='');" value="1" id="quant"  style="text-align: center" >
            @error('quant') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-6 ">
                <label for="raseed" class="form-label-me" >الرصيد الكلي</label>
                <input wire:model="raseed" class="form-control " type="text" readonly id="raseed"   >
      </div>
      <div class="col-6">
            <label for="price" class="form-label-me">السعر</label>
            <input x-bind:disabled="!$wire.DetailOpen || !$wire.ItemGeted" wire:model="price"
                   wire:keydown.enter="ChkPriceAndGo"
                   class="form-control" name="price" type="number"  min="1" oninput="validity.valid||(value='');"
                   id="price"  style="text-align: center" >
          <br>
          @error('price') <span class="error">{{ $message }}</span> @enderror
       </div>
      <div class="col-6 ">
            <label for="st_raseed" class="form-label-me " >رصيد المخزن</label>
            <input wire:model="st_raseed" class="form-control "  type="text" readonly  id="st_raseed"   >
        </div>
 </div>


@push('scripts')
    <script type="text/javascript">
      Livewire.on('gotonext',postid=>  {
            if (postid=='quant') {  $("#quant").focus();  $("#quant").select();};
            if (postid=='itemno') {  $("#itemno").focus(); $("#itemno").select();};
            if (postid=='price') {  $("#price").focus(); $("#price").select();};
        });
        window.addEventListener('CloseFirst', event => {
            $("#ModalFormOne").modal('hide');
        })
        window.addEventListener('OpenFirst', event => {
            $("#ModalFormOne").modal('show');
        })
        window.addEventListener('CloseSecond', event => {
            $("#ModalFormTwo").modal('hide');
        })
        window.addEventListener('OpenSecond', event => {
            $("#ModalFormTwo").modal('show');
        })
        $(document).ready(function ()
        {
            $('#Item_L').select2({
                closeOnSelect: true
            });
            $('#Item_L').on('change', function (e) {
                var data = $('#Item_L').select2("val");
                @this.set('item', data);
                @this.set('TheItemListSelected',1);
            });
        });
        window.livewire.on('item-change-event',()=>{
            $('#Item_L').select2({
                closeOnSelect: true
            });
        });
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
    </script>
@endpush

