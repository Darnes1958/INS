<div x-data="{open:  @entangle('ShowEditItem') }" class="row "  >
 <div class="col-md-4">
     <!-- Begin Header -->
     <div  class="row  mb-2" style="border:1px solid lightgray;background: white; padding: 4px;">

         <div class="col-md-6">
             <label for="date_date" class="form-label-me">التاريخ</label>
             <input wire:model="order_date" wire:keydown.enter="ChkOrder_date"
                    class="form-control  "  type="date"  id="order_date" >
             @error('order_date') <span class="error">{{ $message }}</span> @enderror
         </div>

         <div class="col-md-6"> </div>

         <div class="row  ">
             <div class="col-md-4">
                 <label  for="jeha_no" class="form-label-me">المورد</label>
                 <input wire:model="jeha_no" wire:keydown.enter="ChkJeha_no"
                        class="form-control" type="number"  id="jeha_no" >
                 @error('jeha_no') <span class="error">{{ $message }}</span> @enderror
                 @error('jeha_type') <span class="error">{{ $message }}</span> @enderror
             </div>
             <div class="col-md-8">
                 <label  class="form-label-me">&nbsp;</label>
                 <div class="row g-2 ">
                     <div  class="col-md-11" >

                         @livewire('jeha.supp-select')
                     </div>

                     <div class="col-md-1" >

                         <button wire:click="OpenModal" type="button" class="btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"></button>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-md-4">
             <label   class="form-label-me">المخزن</label>
             <input  wire:model="st_no" wire:keydown.enter="ChkSt_no"
                     class="form-control  "  type="number"  id="st_no" >
             @error('st_no') <span class="error">{{ $message }}</span> @enderror
         </div>
         <div  class="col-md-8" >
             <label  class="form-label-me">&nbsp;</label>
             <div class="row g-2 ">
                 <div  class="col-md-11" >
                     @livewire('stores.store-select1',['table'=>'Makazen'])
                 </div>
             </div>
         </div>


     </div>
     <div class="modal fade" id="ModalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-xl">
             <div class="modal-content">
                 <div class="modal-header">
                     <button wire:click="CloseModal" type="button" class="btn-close" ></button>
                     <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال مورد جديد</h1>
                 </div>
                 <div class="modal-body">
                     @livewire('jeha.add-supp')
                 </div>
             </div>
         </div>
     </div>
     <!-- End Header -->

     <!-- Begin Detail -->
     <div  class="row " style="border:1px solid lightgray;background: white;padding: 4px;">

         <div class="col-md-12"   >
             <div class="row g-2 ">
                 <div class="col-md-11" >
                     @livewire('stores.item-select')
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
                                 <button type="button" class="btn-close" wire:click.prevent="CloseSecond"></button>
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
             <label  for="item_no" class="form-label-me ">رقم الصنف</label>
             <input wire:model="item_no"  wire:keydown.enter="ChkItemAndGo"
                    type="text" class="form-control" value="0"
                    id="theitem" name="theitem" style="text-align: center;height: 39px;">
             @error('item_no') <span class="error">{{ $message }}</span> @enderror
         </div>
         <div class="col-md-8">
             <div class="d-flex">
                 <label  for="item_name" class="form-label-me ">اسم الصنف</label>
                 <button wire:click="DoEditItem" x-show="$wire.item_no!=null && $wire.item!=0 "
                         type="button" class="btn btn-outline-primary btn-sm fa fa-edit border-0" ></button>
             </div>
             <textarea wire:model="item_name" name="item_name" class="form-control"
                       style="color: #0b5ed7; "  readonly id="item_name" placeholder="اسم الصنف"></textarea>

         </div>
         <div class="col-md-4"  x-show:="open" >
         </div>
         <div class="col-md-8 mb-2"  x-show:="open" @click.outside="open = false">
          <textarea  wire:model="ItemToEdit" wire:keydown.enter="SaveItem"
                    class="form-control"  id="ItemToEdit" ></textarea>
         </div>


         <div class="col-6 ">
             <label for="quant" class="form-label-me " >الكمية</label>
             <input wire:model="quant" wire:keydown.enter="ChkQuantAndGo"  x-bind:disabled="!$wire.ItemGeted"
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
             <input wire:model="price" wire:keydown.enter="ChkPriceAndGo" class="form-control"  type="number"
                    id="price"  style="text-align: center"  x-bind:disabled="!$wire.ItemGeted">
             <br>
             @error('price') <span class="error">{{ $message }}</span> @enderror
         </div>
         <div class="col-6 ">
             <label for="st_raseed" class="form-label-me " >رصيد المخزن</label>
             <input wire:model="st_raseed" class="form-control " name="st_raseed" type="text" readonly
                    id="st_raseed"   >
         </div>
         <div class="col-6">
             <label for="price_nakdy" class="form-label-me">تعديل البيع نقدي</label>
             <input wire:model="price_nakdy" wire:keydown.enter="UpdNakdy" class="form-control"  type="number"
                    id="price_nakdy"  style="text-align: center"  x-bind:disabled="!$wire.ItemGeted">
             <br>
             @error('price_nakdy') <span class="error">{{ $message }}</span> @enderror
         </div>
         <div class="col-6">
             <label for="price_tak" class="form-label-me">تعديل البيع بالتقسيط</label>
             <input wire:model="price_tak" wire:keydown.enter="UpdTak" class="form-control"  type="number"
                    id="price_tak"  style="text-align: center"  x-bind:disabled="!$wire.ItemGeted">
             <br>
             @error('price_tak') <span class="error">{{ $message }}</span> @enderror
         </div>
     </div>
     <!-- End Detail -->
 </div>

 <!-- Begin Table -->
 <div x-show="$wire.OpenTable" class="col-md-8">
     <div x-data  style="border:1px solid lightgray;background: white;padding: 4px;">
         <table class="table-sm table-bordered " width="100%"   >
             <thead>
             <tr>
                 <th width="15%">رقم الصنف</th>
                 <th>اسم الصنف </th>
                 <th width="10%">الكمية</th>

                 <th width="15%">السعر </th>
                 <th width="18%">المجموع</th>
                 <th width="12%"></th>
             </tr>
             </thead>
             <tbody id="addRow" class="addRow">

             @foreach($orderdetail as $key => $item)

                 <tr>
                     <td style="color: #0c63e4; text-align: center"> {{ $item->item_no }} </td>
                     <td > {{ $item->item_name }} </td>
                     <td> {{ $item->quant }} </td>
                     <td> {{ $item->price }} </td>
                     <td> <input value="{{ number_format($item->subtot, 2, '.', '')  }}" type="number"
                                 class="form-control estimated_amount" readonly style="background-color: #ddd;" ></td>
                     <td style="padding-top: 2px;padding-bottom: 2px; ">
                         <i wire:click.prevent="edititem({{$item->item_no}})" class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
                         <i  wire:click.prevent="removeitem({{$item->item_no}})" class="btn btn-outline-danger btn-sm fa fa-times "></i>
                     </td>
                 </tr>
             @endforeach
             </tbody>
             <tbody>
             <tr>
                 <td colspan="4"> إجمالي الفاتورة</td>
                 <td>
                     <input wire:model="tot1" type="number"   id="tot1"
                            class="form-control estimated_amount" readonly style="background-color: #ddd;" >
                 </td>
                 <td></td>
             </tr>

             <tr>
                 <td colspan="4"> خصم (تخفيض)  @error('ksm') <span class="error">{{ $message }}</span> @enderror</td>
                 <td>
                     <input wire:model="ksm" wire:keydown.enter="ChkKsm" type="text" name="ksm" id="ksm" class="form-control estimated_amount"   >

                 </td>
             </tr>
             <tr>
                 <td colspan="4">المدفـــــــوع  @error('madfooh') <span class="error">{{ $message }}</span> @enderror</td>
                 <td>
                     <input wire:model="madfooh" wire:keydown.enter="ChkMadfooh" type="text" name="madfooh" id="madfooh" class="form-control estimated_amount"   >
                 </td>
             </tr>

             <tr>
                 <td colspan="4" style="color: #0c63e4;"> إجمالي الفاتورة النهائي</td>
                 <td>
                     <input wire:model="tot" type="text" name="tot"  id="tot" class="form-control estimated_amount"
                            readonly style="background-color: #ddd; color: #0c63e4;font-weight: bold ;" >
                 </td>
                 <td></td>
             </tr>
             </tbody>
         </table><br>


         <div class="row">
             <div class="col-md-4">
               <div class="row">
                 <div class="col-md-4">
                     <button wire:click.prevent="pre_store()" class="btn btn-info" id="storeButton">تخزين الفاتورة</button>
                 </div>
                 <div  class="col-md-8">
                     <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
                     <input wire:model="order_no"  wire:keydown.enter="store"
                            type="number" class=" form-control "  id="order_no"  x-bind:disabled="!$wire.OpenSave" autofocus >
                     @error('order_no') <span class="error">{{ $message }}</span> @enderror
                 </div>
               </div>
             </div>

             <div class="col-md-8">
                 <label for="ntoes" class="form-label">ملاحظات</label>
                 <textarea wire:model="notes" name="description" class="form-control" id="description" placeholder="ملاحظات"></textarea>
             </div>
         </div><br>



         <div class="row" >


             <div class="col-md-5 d-flex my-1">
                 <div  >
                     <input class="form-check-input" name="repchk" type="checkbox" wire:model="ToSal"  >
                     <label class="form-check-label" for="repchk" style="font-size: 8pt">نقل للصالة</label>
                 </div>
                 <input  wire:model="ToSal_L"
                         class="form-control w-25 mx-1 "
                         type="number"  id="ToSal_No" wire:keydown.enter="ChkToSal_No">
                 <select   wire:model="ToSal_L" name="sal_l_id" id="sal_l_id" class="form-control  form-select w-50"
                           style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;width: 100%"         >
                     @foreach($halls_names as $key=>$s)
                         <option value="{{ $s->hall_no }}">{{ $s->hall_name }}</option>
                     @endforeach
                 </select>
                 @error('ToSal_L') <span class="error">{{ $message }}</span> @enderror
             </div>



             <div class="col-md-4  d-flex "  >

                 <input type="button"  id="charge-btn"
                        class="w-50 mx-1 btn btn-outline-primary  waves-effect waves-light   "
                        wire:click.prevent="OpenCharge"   value="تكاليف إضافية" />
                 <input type="text"  id="charge-tot"
                        class="form-control w-50 my-1" wire:model="Charge_Tot" readonly  />


             </div>

             @if (session()->has('message'))
                 <div class="alert alert-success">
                     {{ session('message') }}
                 </div>
             @endif


         </div>

     </div>
 </div>
 <!-- End Table -->
    <div x-show="$wire.xcharge_open" class="col-md-8">
        @livewire('buy.charge-buy2')
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {

            if (postid=='theitem') {  $("#theitem").focus(); $("#theitem").select();};
            if (postid=='order_no') {  $("#order_no").focus();$("#order_no").select(); };
            if (postid=='order_date') {  $("#order_date").focus();$("#order_date").select(); };
            if (postid=='jeha_no') {  $("#jeha_no").focus(); $("#jeha_no").select();};
            if (postid=='st_no') {  $("#st_no").focus(); $("#st_no").select();};
            if (postid=='quant') {  $("#quant").focus();  $("#quant").select();};


            if (postid=='price') {  $("#price").focus(); $("#price").select();};
            if (postid=='ItemToEdit') {  $("#ItemToEdit").focus(); $("#ItemToEdit").select();};

            if (postid=='madfooh') {  $("#madfooh").focus();  $("#madfooh").select();};
            if (postid=='ksm') {  $("#ksm").focus();  $("#ksm").select();};

            if (postid=='price_nakdy') {  $("#price_nakdy").focus();  $("#price_nakdy").select();};
            if (postid=='price_tak') {  $("#price_tak").focus();  $("#price_tak").select();};


        })

        window.addEventListener('CloseModal', event => {
            $("#ModalForm").modal('hide');
        })
        window.addEventListener('OpenModal', event => {
            $("#ModalForm").modal('show');

        })
        window.addEventListener('CloseFirst', event => {
            $("#ModalFormOne").modal('hide');
            $("#theitem").focus();
            $("#theitem").select();

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
            $('#Supp_L').select2({
                closeOnSelect: true
            });
            $('#Supp_L').on('change', function (e) {
                var data = $('#Supp_L').select2("val");
            @this.set('jeha_no', data);
            @this.set('TheJehaIsSelected', 1);

            });
        });
        window.livewire.on('data-change-event',()=>{
            $('#Supp_L').select2({
                closeOnSelect: true
            });
        });
        $(document).ready(function ()
        {
            $('#Item_L').select2({
                closeOnSelect: true
            });
            $('#Item_L').on('change', function (e) {
                var data = $('#Item_L').select2("val");
            @this.set('item_no', data);
            @this.set('TheItemIsSelected', 1);
            });
        });
        window.livewire.on('item-change-event',()=>{
            $('#Item_L').select2({
                closeOnSelect: true
            });
        });
        $(document).ready(function ()
        {
            $('#Place_L1').select2({
                closeOnSelect: true
            });
            $('#Place_L1').on('change', function (e) {
                var data = $('#Place_L1').select2("val");
            @this.set('st_no', data);
            @this.set('ThePlace1ListIsSelected', 1);
            });
        });
        window.livewire.on('place1-change-event',()=>{
            $('#Place_L1').select2({
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
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });

    </script>
@endpush

