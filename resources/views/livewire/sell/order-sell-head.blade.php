<div x-data  class="col-md-12 " style="margin-bottom: 20px;margin-top: 16px;" >
    <div x-cloak x-show="$wire.HeadOpen" x-trap="$wire.HeadOpen" class="row  " style="border:1px solid lightgray;background: white;">

        <div x-data="{isTyped: @entangle('ShowSearch')}" x-trap.noscroll="isTyped" >
            <div class="row my-1">
                <div class="col-md-6">
                    <input type="text" autofocus
                           placeholder="{{__('بحث ...')}}"
                           x-on:input.debounce.200ms="isTyped = ($event.target.value != '')"
                           autocomplete="off"
                           wire:model.debounce.300ms="search"
                           @keydown.enter="isTyped =false"
                           wire:keydown.enter="SearchEnter"
                           @keydown.down="$focus.focus(div1)"
                           aria-label="Search input" />
                </div>
                {{-- search box --}}
                <div x-show="isTyped" x-cloak class="col-md-12">
                    @if(count($records)>0)
                        <div class="position-relative" >
                            <div  class=" w-100 border" >
                                @if(count($records)>0)
                                    <div id="div1" @keydown.down="$focus.focus(div2)" @keydown.up="$focus.focus(div5)" style="background: lightgray"
                                         wire:click="fetchEmployeeDetail({{ $records[0]->jeha_no }})"
                                         wire:keydown.enter="fetchEmployeeDetail({{ $records[0]->jeha_no }})" @keydown.enter="isTyped =false">
                                        {{ $records[0]->jeha_no}} | {{ $records[0]->jeha_name}}
                                    </div>
                                @endif
                                @if(count($records)>1)
                                    <div id="div2" @keydown.down="$focus.focus(div3)" @keydown.up="$focus.focus(div1)"
                                         wire:click="fetchEmployeeDetail({{ $records[1]->jeha_no }})"
                                         wire:keydown.enter="fetchEmployeeDetail({{ $records[1]->jeha_no }})" @keydown.enter="isTyped =false">
                                        {{ $records[1]->jeha_no}} | {{ $records[1]->jeha_name}}

                                    </div>
                                @endif
                                @if(count($records)>2)
                                    <div id="div3" @keydown.down="$focus.focus(div4)" @keydown.up="$focus.focus(div2)" style="background: lightgray"
                                         wire:click="fetchEmployeeDetail({{ $records[2]->jeha_no }})"
                                         wire:keydown.enter="fetchEmployeeDetail({{ $records[2]->jeha_no }})" @keydown.enter="isTyped =false"> {{ $records[2]->jeha_no}} | {{ $records[2]->jeha_name}}</div>
                                @endif
                                @if(count($records)>3)
                                    <div id="div4" @keydown.down="$focus.focus(div5)" @keydown.up="$focus.focus(div3)"
                                         wire:click="fetchEmployeeDetail({{ $records[3]->jeha_no }})"
                                         wire:keydown.enter="fetchEmployeeDetail({{ $records[3]->jeha_no }})" @keydown.enter="isTyped =false"> {{ $records[3]->jeha_no}} | {{ $records[3]->jeha_name}}</div>
                                @endif
                                @if(count($records)>4)
                                    <div id="div5" @keydown.down="$focus.focus(div1)" @keydown.up="$focus.focus(div4)" style="background: lightgray"
                                         wire:click="fetchEmployeeDetail({{ $records[4]->jeha_no }})"
                                         wire:keydown.enter="fetchEmployeeDetail({{ $records[4]->jeha_no }})" @keydown.enter="isTyped =false"> {{ $records[4]->jeha_no}} | {{ $records[4]->jeha_name}}</div>
                                @endif
                            </div>
                        </div>


                    @endif


                </div>
            </div>

        </div>
        <div class="row  " >
            <div x-show="$wire.price_type!=2" class="col-md-12"   >
                <div class="row ">
                    <div class="col-md-12" >
                        <label   class="form-label ">طريقة الدفع</label>
                        @livewire('sell.price-select')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label  for="jehano" class="form-label-me">رقم الزبون</label>
                <input wire:model="jeha_no" wire:keydown.enter="JehaKeyDown"
                       class="form-control  "
                       name="jehano" type="text"  id="jehano" >
                @error('jeha_no') <span class="error">{{ $message }}</span> @enderror

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
                <div class="modal fade" id="ModalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button wire:click="CloseModal" type="button" class="btn-close" ></button>
                                <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال زبون جديد</h1>
                            </div>
                            <div class="modal-body">
                                @livewire('jeha.add-supp')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <label  for="order_no" class="form-label-me ">رقم الفاتورة</label>
            <input wire:model="order_no"  wire:keydown.enter="$emit('gotohead','date')" type="text" class=" form-control "
                   id="order_no" name="order_no"   >
            @error('order_no') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="date" class="form-label-me">التاريخ</label>
            <input wire:model="order_date" wire:keydown.enter="$emit('gotohead','storeno')"
                   class="form-control  "
                   name="date" type="date"  id="date" >
            @error('order_date') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-4 my-2">
            <label   for="storeno" class="form-label-me">{{$PlaceLabel}}</label>
            <input  wire:model="stno" wire:keydown.enter="PlaceKeyEnter"
                    class="form-control  "
                    name="storeno" type="text"  id="storeno" >
            @error('st_no') <span class="error">{{ $message }}</span> @enderror
        </div>

        @if ($OredrSellRadio=='Salat')
        <div  class="col-md-8 my-2" >
           <label  class="form-label-me">اختيار من القائمة</label>
            <select  wire:model="storel" wire:click="FillStno" name="store_id" id="store_id" class="form-control  form-select "
                     style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"
            >
                @foreach($halls_names as $key=>$s)
                    <option value="{{ $s->hall_no }}">{{ $s->hall_name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        @if ($OredrSellRadio=='Makazen')
            <div  class="col-md-8 my-2" >
                <label  class="form-label-me">اختيار من القائمة</label>
                <select  wire:model="storel"   name="store_id" id="store_id" class="form-control  form-select "
                         style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"
                >
                    @foreach($stores_names as $key=>$s)
                        <option value="{{ $s->st_no }}">{{ $s->st_name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class=" col-md-12 my-3 align-center justify-content-center "  style="display: flex">
            <div class="col-md-3 align-center justify-content-center">
               <input type="button"  id="head-btn"
                   class=" btn btn-outline-success  waves-effect waves-light   "
                   wire:click.prevent="BtnHeader"  wire:keydown.enter="BtnHeader" value="موافق" />
            </div>

            @can('ادخال مخازن')
            @if ($OredrSellRadio=='Makazen' )
             <div  class="col-md-2">
                <input class="form-check-input" name="repchk" type="checkbox" wire:model="ToSal"  >
                <label class="form-check-label" for="repchk">نقل للصالة</label>
             </div>
            <div class="col-md-2">
                <input  wire:model="ToSal_L"
                        class="form-control  "
                         type="text"  id="ToSal_No" wire:keydown.enter="ChkToSal_No">
                @error('ToSal_L') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-4 mx-1">

              <select   wire:model="ToSal_L" name="sal_l_id" id="sal_l_id" class="form-control  form-select "
                        style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;width: 100%"         >
                  @foreach($halls_names as $key=>$s)
                      <option value="{{ $s->hall_no }}">{{ $s->hall_name }}</option>
                  @endforeach
              </select>
           </div>
           @endif
           @endcan




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
            <label  class="form-label-me">اسم الزبون</label>
            <input wire:model="jeha_name"   class="form-control  " type="text"  readonly >
        </div>
        <div   class="col-md-12" >
            <label  class="form-label-me">{{$PlaceLabel}}</label>
            <input wire:model="st_name"   class="form-control  " type="text"   readonly>
            <br>
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


        Livewire.on('gotohead',postid=>  {

            if (postid=='orderno') {  $("#order_no").focus();$("#order_no").select(); };
            if (postid=='date') {  $("#date").focus();$("#date").select(); };
            if (postid=='jehano') {  $("#jehano").focus(); $("#jehano").select();};
            if (postid=='storeno') {  $("#storeno").focus(); $("#storeno").select();};
            if (postid=='ToSal_No') {  $("#ToSal_No").focus(); $("#ToSal_No").select();};

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
            Livewire.emit('gotohead', 'jehano');
        });
        $(document).ready(function ()
        {
            $('#Price_L').select2({
                closeOnSelect: true
            });
            $('#Price_L').on('change', function (e) {
                var data = $('#Price_L').select2("val");
            @this.set('price_type', data);
            @this.set('ThePriceListIsSelected',1);
            });
        });
        window.livewire.on('price-change-event',()=>{
            $('#Price_L').select2({
                closeOnSelect: true
            });
        });
    </script>

@endpush
