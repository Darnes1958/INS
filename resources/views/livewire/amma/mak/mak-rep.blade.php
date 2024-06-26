<div>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >


    <div class="col-md-3 my-2 ">
        <div class="form-check form-check-inline">
            <input class="form-check-input" name="repchk" type="checkbox" wire:model="RepChk"  >
            <label class="form-check-label" for="repchk">إضهار الأصناف التي أرصدتها صفر</label>
        </div>

      <input wire:model="search"  type="search"   placeholder="ابحث هنا ......." style="width: 100%;">
    </div>

    <div class="col-md-9">
      <div x-data class="row ">
        <div class="col-md-2 ">
          @if(! $TotChk)
          <div class="form-check form-check-inline">
            <input class="form-check-input"  name="placechk" type="checkbox" wire:model="PlaceChk"  >
            <label class="form-check-me " style="font-size: 9pt;">مكان تخزين معين</label>
          </div>
          @endif
          <div class="form-check form-check-inline">
            <input class="form-check-input"  type="checkbox" wire:model="TotChk"  >
            <label class="form-check-me " style="font-size: 9pt;">تكلفة المخزون</label>
          </div>

        </div>
          <div class="col-md-2 ">

                  <div class="form-check form-check-inline">
                      <input class="form-check-input"   type="checkbox" wire:model="TypeChk"  >
                      <label class="form-check-me " style="font-size: 9pt;">تصنيف معين</label>
                  </div>


          </div>
        <div x-show="$wire.PlaceChk && ! $wire.TotChk" class="col-md-3 ">

          <input  wire:model="place_no"  wire:keydown.enter="ChkPlaceAndGo" type="number" class=" form-control "
                  id="place_no"   autofocus >
            <div class="form-check form-check-inline">
                <input class="form-check-input"  name="placechk" type="radio" wire:model="place_type" value="0" >
                <label class="form-check-label" >مخزن</label>
            </div>
        </div>
        <div  x-show="$wire.PlaceChk && ! $wire.TotChk" class="col-md-3" >

          @livewire('stores.store-select1',['table'=>$Table])
            <div class="form-check form-check-inline">
                <input class="form-check-input"  name="placechk" type="radio" wire:model="place_type" value="1" >
                <label class="form-check-label" >صالة</label>
            </div>
        </div>

          <div x-show="$wire.TypeChk " class="col-md-3 ">

              <input  wire:model="type_no"  wire:keydown.enter="ChkTypeAndGo" type="number" class=" form-control "
                      id="type_no"   autofocus >

          </div>
          <div  x-show="$wire.TypeChk " class="col-md-3" >

              @livewire('stores.item-type-select')

          </div>
        <div class="col-md-3 d-flex">
          @if(! $TotChk)
          @can('سعر الشراء')
           <a  href="{{route('repmakex',['place_type'=>$place_type,'place_no'=>$place_no,'withzero'=>$withzero])}}"
              class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fas fa-file-excel"> &nbsp;&nbsp;إكسل&nbsp;&nbsp;</i></a>
          @endcan

          @if($place_no!=0)
          <a  href="{{route('repmakpdf',['place_type'=>$place_type,'place_no'=>$place_no])}}"
              class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fas fa-print"> &nbsp;&nbsp;جرد&nbsp;&nbsp;</i></a>
            @endif
                @if($place_no!=0)
                    <a  href="{{route('repmakpdf2',['place_type'=>$place_type,'place_no'=>$place_no,'withzero'=>$withzero])}}"
                        class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fas fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
                @endif
        @endif
        </div>

      </div>
    </div>

  </div>


  @if(! $TotChk)
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th style="width: 14%" >التصنيف</th>
      <th style="width: 8%" class="sort text-primary" wire:click="sortOrder('item_no')" > رقم الصنف {!! $sortLink !!}</th>
      <th  class="sort  text-primary" wire:click="sortOrder('item_name')"> اسم الصنف {!! $sortLink !!}</th>
      @can('سعر الشراء')
      <th style="width: 9%">سعر الشراء</th>
      <th style="width: 9%">سعر التكلفة</th>
      @endcan
      <th style="width: 9%">سعر البيع نقداً</th>
      <th style="width: 13%">المخزن / الصالة</th>
      <th style="width: 11%">رصيد المخزن/الصالة</th>
      <th style="width: 8%">الرصيد الكلي</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )
      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">

          <td > {{ $item->type_name }} </td>
          <td> {{ $item->item_no }} </td>
          <td> {{ $item->item_name }} </td>
          @can('سعر الشراء')
          <td> {{ $item->price_buy }} </td>
          <td> {{ $item->price_cost }} </td>
          @endcan
          <td> {{ $item->price_sell }} </td>
          <td> {{ $item->place_name }} </td>
          <td> {{ $item->place_ras }} </td>
          <td> {{ $item->raseed }} </td>
        </tr>
      @endforeach
    @endif
    </tbody>
  </table>

  @if ($RepTable )

    {{ $RepTable->links() }}

  @endif
  @endif

  @if($TotChk)

  <table class="table table-sm table-bordered table-striped " style="width: 60%"   >
    <thead class="font-size-12">
    <tr style="background: #1c6ca1;color: white;">
      <th >المخزن / الصالة</th>
      <th style="width: 15%">سعر الشراء</th>
      <th style="width: 15%">سعر التكلفة</th>
      <th style="width: 15%">سعر البيع نقداً</th>
      <th style="width: 15%">سعر البيع تقسيط</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($TotTable )
      @php $buytot=0;$costtot=0;$selltot=0;$taktot=0; @endphp
      @foreach($TotTable as $key=>$item)
        <tr class="font-size-12">
          <td> {{ $item->place_name }} </td>
          <td> {{ number_format($item->price_buy, 2, '.', ',') }} </td>
          <td> {{ number_format($item->price_cost, 2, '.', ',') }} </td>
          <td> {{ number_format($item->price_sell, 2, '.', ',') }} </td>
          <td> {{ number_format($item->price_tak, 2, '.', ',') }} </td>

        </tr>
        @php $buytot+=$item->price_buy;$costtot+=$item->price_cost;
             $selltot+=$item->price_sell; $taktot+=$item->price_tak; @endphp
      @endforeach
      <tr class="font-size-12" style="font-weight: bold">
        <td> الاجمـــــــــــــالي </td>
        <td> {{ number_format($buytot, 2, '.', ',') }} </td>
        <td> {{ number_format($costtot, 2, '.', ',') }} </td>
        <td> {{ number_format($selltot, 2, '.', ',') }} </td>
        <td> {{ number_format($taktot, 2, '.', ',') }} </td>
      </tr>
    @endif
    </tbody>
  </table>

  @if ($TotTable )

    {{ $TotTable->links() }}

  @endif
  @endif

</div>
@push('scripts')
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
      $(document).ready(function ()
      {
          $('#Place_L1').select2({
              closeOnSelect: true
          });
          $('#Place_L1').on('change', function (e) {
              var data = $('#Place_L1').select2("val");
          @this.set('place_no', data);
          @this.set('ThePlaceListIsSelected', 1);
          });
      });
      window.livewire.on('place1-change-event',()=>{
          $('#Place_L1').select2({
              closeOnSelect: true
          });
      });
      $(document).ready(function ()
      {
          $('#Type_L').select2({
              closeOnSelect: true
          });
          $('#Type_L').on('change', function (e) {
              var data = $('#Type_L').select2("val");
          @this.set('type_no', data);
          @this.set('TheTypeListIsSelected', 1);
          });
      });
      window.livewire.on('itemtype-change-event',()=>{
          $('#Type_L').select2({
              closeOnSelect: true
          });
      });
  </script>
@endpush


