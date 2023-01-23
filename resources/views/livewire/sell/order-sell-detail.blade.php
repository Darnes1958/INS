<div>
    <div  class="modal fade" id="ModalBring" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseBringModal" type="button" class="btn-close" ></button>
                </div>
                <div class="modal-body">
                    @livewire('sell.bring-item')
                </div>
            </div>
        </div>
    </div>
<div x-data="{ $wire.OrderDetailOpen: true }" x-show="$wire.OrderDetailOpen"

     class="row g-3 " style="border:1px solid lightgray;background: white;">


    <div class="col-md-12" x-show="$wire.DetailOpen"  >
        <div class="row g-2 ">
            <div class="col-md-12" >
                @livewire('stores.item-select', ['PlaceSelectType' => $OrderPlacetype,'PlaceToselect' => $OrderPlaceId])
            </div>
        </div>
    </div>

    <div class="col-md-4" >
        <label  for="itemno" class="form-label-me ">رقم الصنف</label>
        <input wire:model="item"  wire:keydown.enter="ItemKeyDown"  x-bind:disabled="!$wire.DetailOpen"
               type="text" class="form-control"  id="itemno" name="itemno" style="text-align: center;height: 39px;">
    </div>
    @if ($ShowBring)
    <div class="col-md-6">
        <label  for="item_name" class="form-label-me ">اسم الصنف</label>
        <textarea wire:model="item_name" name="item_name" class="form-control"
                  style="color: #0b5ed7; "
                  readonly id="item_name" ></textarea>
        @error('item') <span class="error">{{ $message }}</span> @enderror
    </div>
    @else
        <div class="col-md-8">
            <label  for="item_name" class="form-label-me ">اسم الصنف</label>
            <textarea wire:model="item_name" name="item_name" class="form-control"
                      style="color: #0b5ed7; "
                      readonly id="item_name" ></textarea>
            @error('item') <span class="error">{{ $message }}</span> @enderror
        </div>

    @endif

    <div x-show="$wire.ShowBring" class="col-md-2">
        <label class="form-label-me">&nbsp</label>
        <div class="row g-2 ">
            <div class="col-md-6" >
                <button wire:click="OpenBringModal" type="button" class="btn btn-outline-primary btn-sm fa fa-arrow-alt-circle-down" data-bs-toggle="modal"></button>
            </div>

        </div>
    </div>

    <div class="col-6 ">
        <label for="quant" class="form-label-me " >الكمية</label>
        <input wire:model="Quant" wire:keydown.enter="ChkQuant"  x-bind:disabled="!$wire.DetailOpen"
               class="form-control "  type="text" value="1"
               id="Quant"  style="text-align: center" >
        @error('Quant') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-6 ">
        <label for="raseed" class="form-label-me" >الرصيد الكلي</label>
        <input wire:model="raseed" class="form-control " name="raseed" type="text" readonly
               id="raseed"   >
    </div>
    <div class="col-6">
        <label for="price" class="form-label-me">السعر</label>
        <input wire:model="price" wire:keydown.enter="ChkRec" class="form-control" name="price" type="text" value=""
               id="price"  style="text-align: center"  x-bind:disabled="!$wire.DetailOpen">
        <br>

        @error('price') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-6 ">
        <label for="st_raseed" class="form-label-me " >{{$st_label}}</label>
        <input wire:model="st_raseed" class="form-control " name="st_raseed" type="text" readonly
               id="st_raseed"   >
    </div>
</div>
</div>


@push('scripts')
    <script type="text/javascript">
        Livewire.on('itemchange',postid=>{

            $("#itemno").focus();
        });

        Livewire.on('gotonext',postid=>  {

            if (postid=='Quant') {  $("#Quant").focus();  $("#Quant").select();};

            if (postid=='item_no') {  $("#itemno").focus(); $("#itemno").select(); };
            if (postid=='price') {  $("#price").focus(); $("#price").select();};
        });


        $(document).ready(function ()
        {
            $('#Item_L').select2({
                closeOnSelect: true
            });
            $('#Item_L').on('change', function (e) {
                var data = $('#Item_L').select2("val");
            @this.set('item', data);
            @this.set('TheItemListIsSelectd', 1);
            });
        });
        window.livewire.on('item-change-event',()=>{
            $('#Item_L').select2({
                closeOnSelect: true
            });
        });

        window.addEventListener('CloseBringModal', event => {
            $("#ModalBring").modal('hide');
        })
        window.addEventListener('OpenBringModal', event => {
            $("#ModalBring").modal('show');
        })
    </script>

@endpush

