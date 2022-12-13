<div x-data class="col-md-12 " style="margin-bottom: 20px;margin-top: 16px;" xmlns="http://www.w3.org/1999/html">

    <div  x-show="$wire.HeadOpen" class="row g-3 " style="border:1px solid lightgray;background: white;">
        <div class="col-md-12" >
            @livewire('sell.sell-select')
        </div>
        <div class="row g-3 ">
            <div class="col-md-4">
                <label  for="jehano" class="form-label-me">رقم الزبون</label>
                <input wire:model="jeha_no"
                       class="form-control  "  name="jehano" type="text"  id="jehano" readonly>
            </div>
        </div>

        <div class="col-md-6">
            <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
            <input wire:model="order_no"  wire:keydown.enter="ChkOrderNoAndGo"  type="text" class=" form-control "
                   id="order_no" name="order_no"   >
            @error('order_no') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="date" class="form-label-me">التاريخ</label>
            <input wire:model="order_date" wire:keydown.enter="$emit('gotonext','head-btn')"
                   x-bind:disabled="!$wire.OrderNoFound"  class="form-control  "  name="date" type="date"  id="date" >
            @error('order_date') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12">
            <label  for="order_no" class="form-label-me ">{{$PlaceLabel}}</label>
            <input wire:model="st_name"   class="form-control" readonly    type="text"   >

        </div>
        <div class="my-3 align-center justify-content-center "  style="display: flex">

            <input type="button"  id="head-btn"
                   class=" btn btn-outline-success  waves-effect waves-light   "
                   x-bind:hidden="!$wire.OrderNoFound"
                   wire:click.prevent="BtnHeader"  wire:keydown.enter="BtnHeader" value="موافق" />
            <input type="button"  id="head-btn2"
                   x-bind:hidden="!$wire.OrderNoFound" class= "mx-4 btn btn-outline-danger  waves-effect waves-light   "
                   wire:click.prevent="BtnHeaderDel"  value="الغاء الفاتورة" />

        </div>
    </div>

    <div  x-show="!$wire.HeadOpen" class="row g-3 " style="border:1px solid lightgray;background: white;">
        <div class="col-md-6">
            <label   class="form-label-me ">رقم الفاتورة</label>
            <input wire:model="order_no" type="text" class=" form-control "   readonly  >
        </div>
        <div class="col-md-6">
            <label  class="form-label-me">التاريخ</label>
            <input wire:model="order_date" type="text"  class="form-control  "   readonly >
        </div>

        <div class="col-md-12">
            <label  class="form-label-me">المورد</label>
            <input wire:model="jeha_name"   class="form-control  " type="text"  readonly >
        </div>
        <div   class="col-md-12" >
            <label  class="form-label-me">{{$PlaceLabel}}</label>
            <input wire:model="st_name"   class="form-control  " type="text"   readonly>
            <br>
        </div>
    </div>

    <div class="modal fade" id="ModalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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

</div>

@push('scripts')
    <script type="text/javascript">
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
           })
        });
        window.addEventListener('dodelete',function(e){

            MyConfirm.fire({
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('DoDelete');
                }
            })
        });
    </script>

    <script type="text/javascript">
        Livewire.on('jehachange',postid=>{

            $("#jehano").focus();
        })
        Livewire.on('mounthead',postid=>{

            $("#orderno").focus();
            $("#orderno").select();
        })


        Livewire.on('gotonext',postid=>  {
            if (postid=='orderno') {  $("#order_no").focus();$("#order_no").select(); };
            if (postid=='date') {  $("#date").focus();$("#date").select(); };
            if (postid=='jehano') {  $("#jehano").focus(); $("#jehano").select();};
            if (postid=='storeno') {  $("#storeno").focus(); $("#storeno").select();};
            if (postid=='head-btn') {
                setTimeout(function() { document.getElementById('head-btn').focus(); },100);};
        })

    </script>
    <script>
        window.addEventListener('CloseModal', event => {
            $("#ModalForm").modal('hide');
        })
        window.addEventListener('OpenModal', event => {
            $("#ModalForm").modal('show');
        })


    </script>
    <script>
        window.addEventListener('CloseSelljehaModal', event => {
            $("#ModalSelljeha").modal('hide');
        })
        window.addEventListener('OpenSelljehaModal', event => {
            $("#ModalSelljeha").modal('show');
        })
    </script>
    <script>

        $(document).ready(function ()
        {
            $('#Cust_L').select2({
                closeOnSelect: true
            });
            $('#Cust_L').on('change', function (e) {
                var data = $('#Cust_L').select2("val");
            @this.set('jeha', data);
            });
        });
        window.livewire.on('data-change-event',()=>{
            $('#Cust_L').select2({
                closeOnSelect: true
            });
            Livewire.emit('gotonext', 'jehano');
        });
        $(document).ready(function ()
        {
            $('#Sell_L').select2({
                closeOnSelect: true
            });
            $('#Sell_L').on('change', function (e) {
                var data = $('#Sell_L').select2("val");
            @this.set('order_no', data);
            @this.set('TheOrderListSelected',1);
            });
        });
        window.livewire.on('sell-change-event',()=>{
            $('#Sell_L').select2({
                closeOnSelect: true
            });
        });


    </script>

@endpush
