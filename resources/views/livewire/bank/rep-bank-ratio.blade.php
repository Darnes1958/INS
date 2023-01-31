<div class="col-md-12">
    <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
        <div class="col-md-6">
            @livewire('aksat.rep.bank-comp',
            ['sender' => 'bank.rep-bank-ratio',])
        </div>

        <div class="col-md-4 my-2 ">
            <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
        </div>



    </div>
  <div x-data class="row">
   <div class="col-md-6">
    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <thead class="font-size-12">
        <tr>

            <th width="12%">نقطة البيع</th>
            <th width="18%">عدد الأقساط</th>
            <th width="8%">إجمالي الأقساط</th>
            <th width="8%">عمولة المصرف</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @if ($PlaceTable )
            @foreach($PlaceTable as $key=>$item)
                <tr class="font-size-12">
                    <td ><a wire:click="selectItem({{ $item->place_type }},{{ $item->place }})" href="#">{{ $item->place_name }}</a>   </td>
                    <td> {{ $item->kst_count }} </td>
                    <td> {{number_format($item->tot_kst,2, '.', ',')  }} </td>
                    <td> {{ number_format($item->tot_ratio,2, '.', ',') }} </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    @if ($PlaceTable )
        {{ $PlaceTable->links() }}
    @endif
   </div>
      <div class="col-md-6">
          <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
              <thead class="font-size-12">
              <tr>
                  <th width="8%">الشهر</th>
                  <th width="18%">عدد الأقساط</th>
                  <th width="8%">إجمالي الأقساط</th>
                  <th width="8%">عمولة المصرف</th>
              </tr>
              </thead>
              <tbody id="addRow" class="addRow">
              @if ($MonthTable )
                  @foreach($MonthTable as $key=>$item)
                      <tr class="font-size-12">
                          <td > {{ $item->M }} </td>
                          <td> {{ $item->kst_count }} </td>
                          <td> {{ $item->tot_kst }} </td>
                          <td> {{ $item->tot_ratio }} </td>
                      </tr>
                  @endforeach
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


