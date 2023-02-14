<div>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >


    <div class="col-md-3 my-2 ">
        <div class="form-check form-check-inline">
            <input class="form-check-input" name="repchk" type="checkbox" wire:model="RepChk"  >
            <label class="form-check-label" for="repchk">إضهار الأصناف التي أرصدتها صفر</label>
        </div>

      <input wire:model="search"  type="search"   placeholder="ابحث هنا ......." style="width: 100%;">
    </div>

    <div class="col-md-8">
      <div x-data class="row">
        <div class="col-md-3 form-check form-check-inline">
          <input class="form-check-input"  name="placechk" type="checkbox" wire:model="PlaceChk"  >
          <label class="form-check-label" >مكان تخزين معين</label>
        </div>
        <div x-show="$wire.PlaceChk" class="col-md-3 ">

          <input  wire:model="place_no"  wire:keydown.enter="ChkPlaceAndGo" type="number" class=" form-control "
                  id="place_no"   autofocus >
            <div class="form-check form-check-inline">
                <input class="form-check-input"  name="placechk" type="radio" wire:model="place_type" value="0" >
                <label class="form-check-label" >مخزن</label>
            </div>
        </div>
        <div  x-show="$wire.PlaceChk" class="col-md-4" >

          @livewire('stores.store-select1',['table'=>$Table])
            <div class="form-check form-check-inline">
                <input class="form-check-input"  name="placechk" type="radio" wire:model="place_type" value="1" >
                <label class="form-check-label" >صالة</label>
            </div>
        </div>


      </div>
    </div>

  </div>


  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>

      <th style="width: 14%" >التصنيف</th>
      <th style="width: 8%" class="sort text-primary" wire:click="sortOrder('item_no')" > رقم الصنف {!! $sortLink !!}</th>
      <th  class="sort  text-primary" wire:click="sortOrder('item_name')"> اسم الصنف {!! $sortLink !!}</th>

      @can('سعر الشراء')
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
  </script>
@endpush


