<div x-data>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >

    <div class="col-md-4">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="ByBank">
        <label class="form-check-label" for="inlineRadio1">بالمصارف</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="ByPlace">
        <label class="form-check-label" for="inlineRadio2">بالفروع والمخازن</label>
      </div>
    </div>

    @if( $RepRadio=='ByPlace')
    <div class="col-md-9">
      <div x-data class="row ">
        <div class="col-md-2 ">
            <div class="form-check form-check-inline">
              <input class="form-check-input"  name="placechk" type="checkbox" wire:model="PlaceChk"  >
              <label class="form-check-me " style="font-size: 9pt;">مكان تخزين معين</label>
            </div>
        </div>

        <div x-show="$wire.PlaceChk" class="col-md-3 ">

          <input  wire:model="place_no"  wire:keydown.enter="ChkPlaceAndGo" type="number" class=" form-control "
                  id="place_no"   autofocus >
          <div class="form-check form-check-inline">
            <input class="form-check-input"  name="placechk" type="radio" wire:model="place_type" value="0" >
            <label class="form-check-label" >مخزن</label>
          </div>
        </div>
        <div  x-show="$wire.PlaceChk" class="col-md-3" >

          @livewire('stores.store-select3',['table'=>$Table])
          <div class="form-check form-check-inline">
            <input class="form-check-input"  name="placechk" type="radio" wire:model="place_type" value="1" >
            <label class="form-check-label" >صالة</label>
          </div>
        </div>

      </div>
    </div>
    @endif



  </div>

@if($RepRadio=='ByBank')
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th>ت</th>
      <th>رقم المصرف</th>
      <th>اسم المصرف</th>
      <th>عدد العقود</th>
      <th>اجمالي العقود</th>
      <th>المسدد</th>
      <th>المتبقي</th>
      <th class="text-primary">عدد الأقساط المتبقية</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">

    @if ($RepTable )
      @php $count=0;$sul=0;$pay=0;$raseed=0;$over=0;$tar=0;$wrong=0; @endphp

      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td> {{ $key+1}} </td>
          <td> {{ $item->bank}} </td>
          <td> {{ $item->bank_name }} </td>
          <td> {{ $item->WCOUNT }} </td>
          <td> {{ $item->sumsul }} </td>
          <td> {{ $item->sumpay }} </td>
          <td> {{ $item->sumraseed }} </td>
          <td class="text-primary"> {{ $item->kst_count }} </td>
        </tr>
        @php $count+=$item->WCOUNT;$sul+=$item->sumsul;$pay+=$item->sumpay;$raseed+=$item->sumraseed;             @endphp
      @endforeach


      <tr style="background: #9dc1d3;">
        <td colspan="3" style="text-align: center;"> إجمالي الصفحة </td>
        <td style="font-weight: bold"> {{ number_format($count,0, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($sul,2, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($pay,2, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($raseed,2, '.', ',') }} </td>


      </tr>

      <tr style="background: #9dc1d3;">
              <td colspan="3" style="text-align: center;"> الإجمــالي الكلي </td>
              <td style="font-weight: bold"> {{ number_format($ccount,0, '.', ',') }} </td>
              <td style="font-weight: bold"> {{ number_format($ssul,2, '.', ',') }} </td>
              <td style="font-weight: bold"> {{ number_format($ppay,2, '.', ',') }} </td>
              <td style="font-weight: bold"> {{ number_format($rraseed,2, '.', ',') }} </td>
              <td > </td>
              <td style="font-weight: bold">  </td>
              <td style="font-weight: bold">  </td>

          </tr>
       </tbody>
      @endif
  </table>

  @if ($RepTable )
      {{ $RepTable->links() }}

  @endif
 @endif
  @if($RepRadio=='ByPlace')
    <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
      <thead class="font-size-12">
      <tr>
        <th>ت</th>
        <th>نقطة البيع</th>
        <th>اسم المصرف</th>
        <th>عدد العقود</th>
        <th>اجمالي العقود</th>
        <th>المسدد</th>
        <th>المتبقي</th>
        <th class="text-success">عدد الأقساط المخصومة</th>
        <th class="text-primary">عدد الأقساط المتبقية</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @if ($PlaceTable )
        @foreach($PlaceTable as $key=>$item)
          <tr class="font-size-12">
            <td> {{ $key+1}} </td>
            <td> {{ $item->place_name}} </td>
            <td> {{ $item->bank_name }} </td>
            <td> {{ $item->WCOUNT }} </td>
            <td> {{ $item->sumsul }} </td>
            <td> {{ $item->sumpay }} </td>
            <td> {{ $item->sumraseed }} </td>
            <td class="text-success"> {{ $item->kst_count }} </td>
            <td class="text-primary"> {{ $item->kst_count_not }} </td>
          </tr>
        @endforeach
      </tbody>
      @endif
    </table>

    @if ($PlaceTable )
      {{ $PlaceTable->links() }}

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
          $('#Place_L3').select2({
              closeOnSelect: true
          });
          $('#Place_L3').on('change', function (e) {
              var data = $('#Place_L3').select2("val");
              alert(data);
          @this.set('place_no', data);
          @this.set('ThePlaceListIsSelected', 1);
          });
      });
      window.livewire.on('place3-change-event',()=>{
          $('#Place_L3').select2({
              closeOnSelect: true
          });
      });

  </script>
@endpush


