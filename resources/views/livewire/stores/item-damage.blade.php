<div x-data class="row">
    <div  class="col-md-6" style="border:1px solid lightgray;background: white;">
        <div class="row my-3 mx-1">


            <div class="col-md-12" >
                @livewire('stores.item-select')
            </div>

            <div class="col-md-4" >
                <label  for="itemno" class="form-label-me ">رقم الصنف</label>
                <input wire:model="itemno"  wire:keydown.enter="ChkItemAndGo"  x-bind:disabled="!$wire.DetailOpen"
                       type="text" class="form-control"  id="itemno" name="itemno" style="text-align: center;height: 39px;">
            </div>
            <div class="col-md-8">
                <label   class="form-label-me ">اسم الصنف</label>
                <textarea wire:model="item_name" name="item_name" class="form-control"
                          style="color: #0b5ed7; "
                          readonly id="item_name" ></textarea>
            </div>

            <div class="my-3 col-md-6 " >
                <label  class="form-label-me" >أسعار البيع</label>
                <table class="table-sm table-bordered " style="width: 100%">
                    <thead style="background: lightgray">
                    <tr>
                        <th style="width: 25%">الرقم الألي</th>
                        <th style="width: 50%">البيان </th>
                        <th style="width: 25%">السعر </th>
                    </tr>
                    </thead>
                    <tbody >
                    @foreach($pricetable as $key => $item)
                        <tr>
                            <td style="color: #0c63e4; text-align: center"> {{ $item->price_type }} </td>
                            <td > {{ $item->type_name }} </td>
                            <td> {{ $item->price }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-3 col-md-5 " >
                <label  class="form-label-me" >أماكن التخزين</label>
                <table class="table-sm table-bordered " style="width: 100%">
                    <thead style="background: lightgray">
                    <tr>
                        <th style="width: 60%">المكان </th>
                        <th style="width: 40%">الرصيد</th>
                    </tr>
                    </thead>
                    <tbody >
                    @foreach($placetable as $key => $item)
                        <tr>
                            <td > {{ $item->place_name }} </td>
                            <td> {{ $item->raseed }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div  class="col-md-6" style="border:1px solid lightgray;background: white;">
        <div class="row my-3 mx-1">


            <div class="col-md-10" >
                @livewire('stores.item-select2')
            </div>
            <div class="col-md-2" x-show="$wire.ItemGeted2 && $wire.ItemGeted">
                <input type="button"  id="btn-save"
                       class=" btn btn-outline-success  waves-effect waves-light   "
                       wire:click.prevent="Damage"   value="توحيد الصنف" />
            </div>


            <div class="col-md-4" >
                <label  for="itemno" class="form-label-me ">رقم الصنف</label>
                <input wire:model="itemno2"  wire:keydown.enter="ChkItemAndGo2"  x-bind:disabled="!$wire.DetailOpen2"
                       type="text" class="form-control"  id="itemno"  style="text-align: center;height: 39px;">
            </div>
            <div class="col-md-8">
                <label   class="form-label-me ">اسم الصنف</label>
                <textarea wire:model="item_name2"  class="form-control"
                          style="color: #0b5ed7; "
                          readonly id="item_name2" ></textarea>
            </div>

            <div class="my-3 col-md-6 " >
                <label  class="form-label-me" >أسعار البيع</label>
                <table class="table-sm table-bordered " style="width: 100%">
                    <thead style="background: lightgray">
                    <tr>
                        <th style="width: 25%">الرقم الألي</th>
                        <th style="width: 50%">البيان </th>
                        <th style="width: 25%">السعر </th>
                    </tr>
                    </thead>
                    <tbody >
                    @foreach($pricetable2 as $key => $item)
                        <tr>
                            <td style="color: #0c63e4; text-align: center"> {{ $item->price_type }} </td>
                            <td > {{ $item->type_name }} </td>
                            <td> {{ $item->price }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-3 col-md-5 " >
                <label  class="form-label-me" >أماكن التخزين</label>
                <table class="table-sm table-bordered " style="width: 100%">
                    <thead style="background: lightgray">
                    <tr>
                        <th style="width: 60%">المكان </th>
                        <th style="width: 40%">الرصيد</th>
                    </tr>
                    </thead>
                    <tbody >
                    @foreach($placetable2 as $key => $item)
                        <tr>
                            <td > {{ $item->place_name }} </td>
                            <td> {{ $item->raseed }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {
            if (postid=='itemno') {  $("#itemno").focus(); $("#itemno").select();};
            if (postid=='itemno2') {  $("#itemno2").focus(); $("#itemno2").select();};
        });

        $(document).ready(function ()
        {
            $('#Item_L').select2({
                closeOnSelect: true
            });
            $('#Item_L').on('change', function (e) {
                var data = $('#Item_L').select2("val");
            @this.set('itemno', data);
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
            $('#Item_L2').select2({
                closeOnSelect: true
            });
            $('#Item_L2').on('change', function (e) {
                var data = $('#Item_L2').select2("val");
            @this.set('itemno2', data);
            @this.set('TheItemIsSelected2', 1);
            });
        });
        window.livewire.on('item2-change-event',()=>{
            $('#Item_L2').select2({
                closeOnSelect: true
            });
        });
    </script>

@endpush


