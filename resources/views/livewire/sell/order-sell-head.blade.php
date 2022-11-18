<div x-data class="col-md-12 " style="margin-bottom: 20px;margin-top: 16px;" xmlns="http://www.w3.org/1999/html">

    <div  x-show="$wire.HeadOpen" class="row g-3 " style="border:1px solid lightgray;background: white;">
        <div class="row g-3 ">
            <div class="col-md-4">
                <label  for="jehano" class="form-label-me">رقم الزبون</label>
                <input wire:model="jeha" wire:keydown.enter="JehaKeyDown"
                       class="form-control  "
                       name="jehano" type="text"  id="jehano" autofocus>
                @error('jeha') <span class="error">{{ $message }}</span> @enderror
                @error('jeha_type') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label-me">&nbsp</label>
                <div class="row g-2 ">
                    <div class="col-md-6" >
                        <button wire:click="OpenJehaSerachModal" type="button" class="btn btn-outline-primary btn-sm fa fa-arrow-alt-circle-down" data-bs-toggle="modal"></button>
                    </div>
                    <div class="col-md-6" >
                        <button wire:click="OpenModal" type="button" class="btn btn-outline-primary btn-sm fa fa-plus" data-bs-toggle="modal"></button>
                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" wire:model="OredrSellRadio" wire:click="ChangePlace" name="inlineRadioOptions" id="inlineRadio1" value="Makazen">
                    <label class="form-check-label" for="inlineRadio1">مخازن</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" wire:model="OredrSellRadio" wire:click="ChangePlace" name="inlineRadioOptions" id="inlineRadio2" value="Salat">
                    <label class="form-check-label" for="inlineRadio2">صالات</label>
                </div>


                <input wire:model="jeha_name"  class="form-control  "   type="text"  id="jehaname" readonly>

                    <div class="modal fade" id="ModalSelljeha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button wire:click="CloseJehaSerachModal" type="button" class="btn-close" ></button>

                                </div>
                                <div class="modal-body">
                                    @livewire('jeha.cust-search')
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
        </div>

        <div class="col-md-6">
            <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
            <input wire:model="order_no"  wire:keydown.enter="$emit('gotonext','date')" type="text" class=" form-control "
                   id="order_no" name="order_no"   >
            @error('order_no') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="date" class="form-label-me">التاريخ</label>
            <input wire:model="order_date" wire:keydown.enter="$emit('gotonext','storeno')"
                   class="form-control  "
                   name="date" type="date"  id="date" >
            @error('order_date') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-4">
            <label   for="storeno" class="form-label-me">{{$PlaceLabel}}</label>
            <input  wire:model="stno" wire:keydown.enter="PlaceKeyEnter"
                    class="form-control  "
                    name="storeno" type="text"  id="storeno" >
            @error('st_no') <span class="error">{{ $message }}</span> @enderror
        </div>

        @if ($OredrSellRadio=='Salat')
        <div  class="col-md-8" >
           <label  class="form-label-me">اختيار من القائمة</label>
            <select  wire:model="storel" name="store_id" id="store_id" class="form-control  form-select "
                     style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"
            >
                @foreach($halls_names as $key=>$s)
                    <option value="{{ $s->hall_no }}">{{ $s->hall_name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        @if ($OredrSellRadio=='Makazen')
            <div  class="col-md-8" >
                <label  class="form-label-me">اختيار من القائمة</label>
                <select  wire:model="storel" name="store_id" id="store_id" class="form-control  form-select "
                         style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"
                >
                    @foreach($stores_names as $key=>$s)
                        <option value="{{ $s->st_no }}">{{ $s->st_name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="my-3 align-center justify-content-center "  style="display: flex">

            <input type="button"  id="head-btn"
                   class=" btn btn-outline-success  waves-effect waves-light   "
                   wire:click.prevent="BtnHeader"  wire:keydown.enter="BtnHeader" value="موافق" />

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
            <label  class="form-label-me">المخزن</label>
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
    </script>

@endpush
