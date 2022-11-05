
 <div x-data="{ $wire.OrderDetailOpen: true }" x-show="$wire.OrderDetailOpen"
         class="row g-3 " style="border:1px solid lightgray;background: white;">

      <div class="col-md-12" x-show="$wire.DetailOpen"  >
         <div class="row g-2 ">
           <div class="col-md-11" >
             @livewire('buy.item-drop-down')
           </div>
           <div class="col-md-1" >

               <button type="button" class="btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"
                       data-bs-target="#ModalForm">

               </button>
           </div>
               <!-- Modal -->
               <div class="modal fade" id="ModalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">

                              <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                               <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال صنف جديد</h1>

                           </div>
                           <div class="modal-body">
                               @livewire('stores.add-item')
                           </div>

                       </div>
                   </div>
               </div>

          </div>
      </div>

      <div class="col-md-4" >
             <label  for="itemno" class="form-label-me ">رقم الصنف</label>
             <input wire:model="item"  wire:keydown.enter="$emit('gotonext','quant')"  x-bind:disabled="!$wire.DetailOpen"
                     type="text" class="form-control"  id="itemno" name="itemno" style="text-align: center;height: 39px;">
        </div>
      <div class="col-md-8">
            <label  for="item_name" class="form-label-me ">اسم الصنف</label>
            <textarea wire:model="item_name" name="item_name" class="form-control"
                      style="color: #0b5ed7; "
                       readonly id="item_name" placeholder="اسم الصنف"></textarea>
            @error('item') <span class="error">{{ $message }}</span> @enderror
        </div>
      <div class="col-6 ">
            <label for="quant" class="form-label-me " >الكمية</label>
            <input wire:model="quant" wire:keydown.enter="$emit('gotonext','price')"  x-bind:disabled="!$wire.DetailOpen"
                   class="form-control " name="quant" type="text" value="1"
                   id="quant"  style="text-align: center" >
            @error('quant') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div class="col-6 ">
                <label for="raseed" class="form-label-me" >الرصيد الكلي</label>
                <input wire:model="raseed" class="form-control " name="raseed" type="text" readonly
                       id="raseed"   >
      </div>
      <div class="col-6">
            <label for="price" class="form-label-me">السعر</label>
            <input wire:model="price" wire:keydown.enter="ChkItem" class="form-control" name="price" type="text" value=""
                   id="price"  style="text-align: center"  x-bind:disabled="!$wire.DetailOpen">
          <br>

            @error('price') <span class="error">{{ $message }}</span> @enderror
       </div>
      <div class="col-6 ">
            <label for="st_raseed" class="form-label-me " >رصيد المخزن</label>
            <input wire:model="st_raseed" class="form-control " name="st_raseed" type="text" readonly
                   id="st_raseed"   >
        </div>
 </div>


@push('scripts')
    <script type="text/javascript">
        Livewire.on('itemchange',postid=>{

            $("#itemno").focus();
        });

        Livewire.on('gotonext',postid=>  {

            if (postid=='quant') {  $("#quant").focus();  $("#quant").select();};
            if (postid=='item_no') {  $("#itemno").focus(); $("#itemno").select();};
            if (postid=='price') {  $("#price").focus(); $("#price").select();};
        });


    </script>
@endpush

