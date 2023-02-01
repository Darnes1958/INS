<div x-data class="col-md-12">
    <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
        <div class="col-md-6">
            @livewire('aksat.rep.bank-comp',
            ['sender' => 'bank.rep-bank-ratio',])
        </div>

      <div  class="col-md-6  d-inline-flex my-2 " >
        <label  class="form-label-me mx-1">السنة</label>
        <select x-bind:disabled="$wire.bank_no==null" wire:model="year"  name="year_id" id="year_id" class="form-control  form-select mx-1 text-center"
                style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"
        >
          @foreach($years as $key=>$s)
            <option value="{{ $s->year }}">{{ $s->year }}</option>
          @endforeach
        </select>

        <input wire:model="year" class="form-control mx-1 text-center" type="number"  min="2006" max="2050"  id="year" style="width: 50%; " readonly>
        @error('year') <span class="error">{{ $message }}</span> @enderror
      </div>



    </div>
  <div x-data class="row">
   <div class="col-md-6">
    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>

            <th >نقطة البيع</th>
            <th width="14%">عدد الأقساط</th>
            <th width="18%">إجمالي الأقساط</th>
            <th width="18%">عمولة المصرف</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @if ($PlaceTable )
          @php $sumkst_count=0;$sumtot_kst=0;$sumtot_ratio=0; @endphp
            @foreach($PlaceTable as $key=>$item)
                <tr class="font-size-12">
                    <td ><a wire:click="selectItem({{ $item->place_type }},{{ $item->place }},'{{ $item->place_name }}')" href="#">{{ $item->place_name }}</a>   </td>
                    <td><a wire:click="selectItem({{ $item->place_type }},{{ $item->place }},'{{ $item->place_name }}')" href="#">{{ $item->kst_count }}</a>  </td>
                    <td><a wire:click="selectItem({{ $item->place_type }},{{ $item->place }}),'{{ $item->place_name }}'" href="#">{{number_format($item->tot_kst,2, '.', ',')  }}</a>  </td>
                    <td> <a wire:click="selectItem({{ $item->place_type }},{{ $item->place }},'{{ $item->place_name }}')" href="#">{{ number_format($item->tot_ratio,2, '.', ',') }}</a> </td>
                </tr>
                @php $sumkst_count+=$item->kst_count;$sumtot_kst+=$item->tot_kst;$sumtot_ratio+=$item->tot_ratio; @endphp
            @endforeach
          <tr class="font-size-12 " style="font-weight: bold">
            <td >الإجمــــــــالي  </td>
            <td> {{number_format($sumkst_count, 0, '.', ',')}}  </td>
            <td> {{number_format($sumtot_kst, 2, '.', ',')}} </td>
            <td> {{number_format($sumtot_ratio, 2, '.', ',')}}  </td>
          </tr>
        @endif
        </tbody>
    </table>
    @if ($PlaceTable )
        {{ $PlaceTable->links() }}
    @endif
   </div>
      <div class="col-md-6">
          <h5 style="color: green">{{ $place_name }}</h5>
          <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
              <thead class="font-size-12">
              <tr>
                  <th width="20%">الشهر</th>
                  <th width="20%">عدد الأقساط</th>
                  <th width="30%">إجمالي الأقساط</th>
                  <th width="30%">عمولة المصرف</th>
              </tr>
              </thead>
              <tbody id="addRow" class="addRow">
              @if ($MonthTable )
                @php $sumkst_count=0;$sumtot_kst=0;$sumtot_ratio=0; @endphp
                  @foreach($MonthTable as $key=>$item)
                      <tr class="font-size-12">
                          <td > {{ $item->M }} </td>
                          <td> {{ $item->kst_count }} </td>
                          <td> {{ number_format($item->tot_kst,2, '.', ',') }} </td>
                          <td> {{ number_format($item->tot_ratio,2, '.', ',') }} </td>
                      </tr>
                      @php $sumkst_count+=$item->kst_count;$sumtot_kst+=$item->tot_kst;$sumtot_ratio+=$item->tot_ratio; @endphp
                  @endforeach
                <tr class="font-size-12 " style="font-weight: bold">
                  <td >الإجمـــــالي  </td>
                  <td> {{number_format($sumkst_count, 0, '.', ',')}}  </td>
                  <td> {{number_format($sumtot_kst, 2, '.', ',')}} </td>
                  <td> {{number_format($sumtot_ratio, 2, '.', ',')}}  </td>
                </tr>
              @endif
              </tbody>
          </table>
          @if ($MonthTable )
              {{ $MonthTable->links() }}
          @endif
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
@endpush


